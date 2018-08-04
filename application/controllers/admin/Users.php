<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('User_model');
        $this->load->model('Classes_model');
    }

    /* Users module */

    public function index() {
        redirect('admin/users/students');
    }

    public function students() {
        $data = array();
        is_admin_login();
        $base_url = base_url() . 'admin/users/students';
        $config_arr = array();
        $config_arr['base_url'] = (isset($base_url)) ? $base_url : '';
        $config_arr['per_page'] = '30';
        $config_arr['total_rows'] = $this->User_model->student_record_count();
        $offset = ($this->input->get('page')) ? ( ( $this->input->get('page') - 1 ) * $config_arr["per_page"] ) : 0;
        $inp_arr = array('limit' => $config_arr["per_page"], 'offset' => $offset);
        $data["user_records"] = $this->User_model->get_student_list($inp_arr);
        $data["page_links"] = $this->Common_model->generate_pagination($config_arr);
        $this->load->view('admin/students', $data);
    }

    public function admin_users() {
        $data = array();
        is_admin_login();
        $base_url = base_url() . 'admin/users/admin_users';
        $config_arr = array();
        $config_arr['base_url'] = (isset($base_url)) ? $base_url : '';
        $config_arr['per_page'] = '30';
        $config_arr['total_rows'] = $this->User_model->admin_record_count();

        $offset = ($this->input->get('page')) ? ( ( $this->input->get('page') - 1 ) * $config_arr["per_page"] ) : 0;
        $inp_arr = array('limit' => $config_arr["per_page"], 'offset' => $offset);
        $data["user_records"] = $this->User_model->admin_user_records($inp_arr);
        $data["page_links"] = $this->Common_model->generate_pagination($config_arr);

        $this->load->view('admin/user', $data);
    }

    public function view_user_details($user_id) {
        $data = array();
        is_admin_login();
        if (isset($user_id) && $user_id > 0) {
            $data['user_details'] = $this->User_model->get_user_detail($user_id);
        }
        $this->load->view('admin/view_user_details', $data);
    }

    public function add_student($id = 0) {
        is_admin_login();
        $data = array();
        $db_data = array();
        if (is_numeric($id) && $id > 0) {
            $input_array = array('limit' => 0, 'offset' => 0, 'id' => $id);
            $db_data = $this->User_model->get_student_list($input_array);

            $_POST['db_email'] = $db_data['email'];
        }

        $inp_arr = array('limit' => 0, 'offset' => 0);
        // to display class list in view file
        $classes = $this->Classes_model->admin_classes_records($inp_arr);

        if (isset($_POST['submit_button']) && $_POST['submit_button'] != '') {
            $data = filter_input_data($_POST);

            $password = isset($data['password']) ? trim($data['password']) : '';
            $confirm_password = isset($data['confirm_password']) ? trim($data['confirm_password']) : '';
            if ($id == 0) {
                $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length[8]');
                $this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|required|xss_clean');
            }
            $this->form_validation->set_rules('class_id', 'Class name', 'trim|required|xss_clean|greater_than[0]', array('greater_than' => 'You must select a class from dropdown list'));
            $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
            if ($this->form_validation->run() == false) {
                
            } else {
                if ($password == $confirm_password) {

                    $user = $this->User_model->add_student_by_admin($data);
                    if ($user === true) {
                        $message = ($id > 0) ? "Record updated successfully" : "Record added successfully";
                        set_success_message($message);
                        redirect('admin/users');
                    } else {
                        set_error_message($user);
                    }
                } else {

                    set_error_message("Password and confirm password does not matched");
                }
            }
        } elseif (count($db_data) > 0) {
            $_POST = $db_data;
        }
        if (isset($classes) && count($classes) > 0) {
            $data['class_records'] = $classes;
        }
        $this->load->view('admin/add_student', $data);
    }

    public function add_admin_user($id = 0) {
        is_admin_login();
        $data = array();
        $db_data = array();
        if (is_numeric($id) && $id > 0) {
            $input_array = array('limit' => 0, 'offset' => 0, 'id' => $id);
            $db_data = $this->User_model->admin_user_records($input_array);
            $data['db_email'] = $db_data['email'];
        }
        if (isset($_POST['submit_button']) && $_POST['submit_button'] != '') {

            $password = isset($data['password']) ? trim($data['password']) : '';
            $confirm_password = isset($data['confirm_password']) ? trim($data['confirm_password']) : '';
            if ($id == 0) {
                $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length[8]');
                $this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|required|xss_clean');
            }
            $this->form_validation->set_rules('user_type', 'User type', 'trim|required|xss_clean|greater_than[0]', array('greater_than' => 'You must select a user type from dropdown list'));
            $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
            if ($this->form_validation->run() == false) {
                
            } else {
                if ($password == $confirm_password) {
                    $user = $this->User_model->add_admin($_POST);
                    if ($user === true) {
                        $message = ($id > 0) ? "User updated successfully" : "User added successfully";
                        set_success_message($message);
                        redirect('admin/users/admin_users');
                    } else {
                        set_error_message($user);
                    }
                } else {

                    set_error_message("Password and confirm password does not matched");
                }
            }
        } elseif (count($db_data) > 0) {
            $_POST = $db_data;
        }
        $this->load->view('admin/add_admin', $data);
    }

    public function add_user($id = 0) {
        is_admin_login();
        $data = array();
        $db_data = array();
        if (is_numeric($id) && $id > 0) {
            $input_array = array('limit' => 0, 'offset' => 0, 'id' => $id);
            $db_data = $this->User_model->admin_user_records($input_array);
        }
        if (isset($_POST['submit_button']) && $_POST['submit_button'] != '') {
            $data = filter_input_data($_POST);

            $password = isset($data['password']) ? trim($data['password']) : '';
            $confirm_password = isset($data['confirm_password']) ? trim($data['confirm_password']) : '';
            $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
            if ($id == 0) {
                $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length[8]');
                $this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|required|xss_clean');
            }
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
            $this->form_validation->set_rules('is_superuser', 'Staff member', 'trim|required|xss_clean');
            if ($this->form_validation->run() == false) {
                
            } else {
                if ($password == $confirm_password) {

                    $user = $this->User_model->add_user_by_admin($data);
                    if ($user === true) {
                        $message = ($id > 0) ? "Record updated successfully" : "Record added successfully";
                        set_success_message($message);
                        redirect('admin/users');
                    } else {
                        set_error_message($user);
                    }
                } else {

                    set_error_message("Password and confirm password does not matched");
                }
            }
        } elseif (count($db_data) > 0) {
            $_POST = $db_data;
        }
        $this->load->view('admin/add_user', $data);
    }

    public function getuserlistforselectbox($id = 0) {
        is_admin_login();

        $search_text = urldecode($this->input->get("q"));
        //$id = $this->input->get("id");

        $user_list = $this->Common_model->get_user_list_for_selectbox($search_text, $id);

        $new_list = array();
        if (is_array($user_list) && count($user_list) > 0) {
            foreach ($user_list as $a => $b) {
                $tmp = array();
                $tmp['id'] = (int) $b['id'];
                $tmp['text'] = $b['username'];

                $new_list[] = $tmp;
            }
        }

        echo json_encode($new_list);
    }

    /* Delete Student */

    public function delete_student($user_id) {
        is_admin_login();

        if (isset($user_id) && $user_id > 0) {
            $students = $this->User_model->admin_delete_student($user_id);
            if ($students === true) {
                $message = "Student has been deleted";
                set_success_message($message);
                redirect('admin/users/students');
            } else {
                set_error_message('No Student has been deleted');
            }
        }
    }

    /* Delete Selected students */

    public function delete_selected_students() {
        is_admin_login();
        if (isset($_POST['action']) && $_POST['action'] == 'delete') {
            $checked_ids = (isset($_POST['checked_ids']) && count($_POST['checked_ids']) > 0) ? $_POST['checked_ids'] : '';
            if (trim($checked_ids) != '') {
                $student_ids = explode(',', $checked_ids);
                if (count($student_ids) > 0) {
                    $students = $this->User_model->admin_delete_student($student_ids);
                    if ($students === true) {
                        $message = "Student has been deleted";
                        set_success_message($message);
                        redirect('admin/users/students');
                    } else {
                        set_error_message('No Student has been deleted');
                    }
                } else {
                    set_error_message('Please check atleast one checkbox to perform delete action.');
                }
            }
        }
    }

    /* Delete Admin User */

    public function delete_admin_user($user_id) {
        is_admin_login();

        if (isset($user_id) && $user_id > 0) {
            $admins = $this->User_model->admin_delete_admin_user($user_id);
            if ($admins === true) {
                $message = "Admin user has been deleted";
                set_success_message($message);
                redirect('admin/users/admin_users');
            } else {
                set_error_message('No Admin User has been deleted');
            }
        }
    }

    /* Delete Selected Admin Users */

    public function delete_selected_admin_users() {
        is_admin_login();
        if (isset($_POST['action']) && $_POST['action'] == 'delete') {
            $checked_ids = (isset($_POST['checked_ids']) && count($_POST['checked_ids']) > 0) ? $_POST['checked_ids'] : '';
            if (trim($checked_ids) != '') {
                $admin_user_ids = explode(',', $checked_ids);
                if (count($admin_user_ids) > 0) {
                    $admins = $this->User_model->admin_delete_admin_user($admin_user_ids);
                    if ($admins === true) {
                        $message = "Admin user has been deleted";
                        set_success_message($message);
                        redirect('admin/users/admin_users');
                    } else {
                        set_error_message('No Admin User has been deleted');
                    }
                } else {
                    set_error_message('Please check atleast one checkbox to perform delete action.');
                }
            }
        }
    }

    /* change student password */

    public function change_password() {
        is_admin_login();
        $data = array();
        $admin_data = get_admin_user_details();
        $data['admin_data'] = $admin_data;
        if (isset($_POST['submit_button']) && $_POST['submit_button'] == 'submit') {
            $current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
            $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
            $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
            $this->form_validation->set_rules('current_password', 'Current password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                
            } else {
                if ($confirm_password == $new_password) {
                    $_POST['user_id'] = $admin_data['id'];
                    $response = $this->User_model->user_change_password($_POST);
                    if ($response['status'] == '200') {
                        $message = $response['message'];
                        set_success_message($message);
                        redirect('admin/users/change_password');
                    } elseif ($response['status'] == '202') {
                        $message = $response['message'];
                        set_error_message($message);
                        redirect('admin/users/change_password');
                    }
                } else {
                    set_error_message("Password and Confirm password does not matched!");
                }
            }
        }
        $this->load->view('admin/change_password', $data);
    }

}
