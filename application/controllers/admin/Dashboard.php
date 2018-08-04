<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Questionnairs_model');
    }

    public function index() {
        is_admin_login();
        
        $data = array();
        $data['dashboard_counts'] = $this->Common_model->get_dashboard_counts();
        $limit = array('limit' => '6');
        $data['recent_users'] = $this->User_model->get_student_list($limit);
        $data['recent_questionnaires'] = $this->Questionnairs_model->admin_questionnairs_data($limit);
        $data['recent_questionnaires_subject_wise'] = $this->Questionnairs_model->admin_questionnairs_data_subject_wise($limit);
//        pr($data['recent_questionnaires_subject_wise']);
//        die;
        $this->load->view('admin/dashboard', $data);
    }

    public function logout() {
        is_admin_login();

        if (get_admin_user_details('id') > 0) {
            $cookie = array(
                'name' => 'user_login',
                'value' => '',
                'expire' => (time() - (86400 * 10))
            );
            $this->input->set_cookie($cookie);
        }
        redirect('admin/login?logout=1');
    }

}
