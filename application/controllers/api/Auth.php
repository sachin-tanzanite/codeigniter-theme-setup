<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
 */
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Auth extends REST_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('User_model');
    }

    public function classes_list() {
        
    }

    public function register() {

        if ($this->is_valid_auth_token(false, $return_message, $return_user_id)) {

            if (isset($this->request_data) && count($this->request_data) > 0) {

                $data = filter_input_data($this->request_data);
                if (isset($data['email'])) {
                    $data['email'] = strtolower($data['email']);
                }
                $mandatory_key = array('email', 'password', 'full_name', 'class_id');

                if (!mandatory_params_present($mandatory_key, $data, $missing_param)) {
                    $response['message'] = $missing_param;
                    $response['status'] = "201";
                    $this->response($response, 200); // 200 being the HTTP response code
                } else {
                    $error = array();
                    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                        $error[] = "Please Enter Valid Email Address";
                    }

                    if (count($error) > 0) {
                        $estr = (count($error) > 1) ? "errors" : "error";
                        $response['message'] = count($error) . " {$estr} found : " . implode(', ', $error);
                        $response['status'] = "201";
                        $this->response($response, 200); // 200 being the HTTP response code
                    } else {

                        $user = $this->User_model->user_register($data);
                        $this->response($user, 200); // 200 being the HTTP response code
                    }
                }
            } else {
                $response['message'] = "No Input Fields Found";
                $response['status'] = "201";
                $this->response($response, 200); // 200 being the HTTP response code
            }
        } else {
            $response['message'] = $return_message;
            $response['status'] = "210";
            $this->response($response, 200); // 200 being the HTTP response code
        }
    }

    public function login() {

        if ($this->is_valid_auth_token(false, $return_message, $return_user_id)) {
            if (isset($this->request_data) && count($this->request_data) > 0) {

                $data = filter_input_data($this->request_data);

                if (isset($data['email'])) {
                    $data['email'] = strtolower($data['email']);
                }

                $mandatory_key = array('email', 'password');

                if (!mandatory_params_present($mandatory_key, $data, $missing_param)) {
                    $response['message'] = $missing_param;
                    $response['status'] = "201";
                    $this->response($response, 200); // 200 being the HTTP response code
                } else {
                    $user = $this->User_model->user_login($data);

                    $this->response($user, 200); // 200 being the HTTP response code
                }
            } else {
                $response['message'] = "No Input Fields Found";
                $response['status'] = "201";
                $this->response($response, 200); // 200 being the HTTP response code
            }
        } else {
            $response['message'] = $return_message;
            $response['status'] = "210";
            $this->response($response, 200); // 200 being the HTTP response code
        }
    }

    public function me() {

        if ($this->is_valid_auth_token(true, $return_message, $return_user_id)) {
            if (isset($_POST) && count($_POST) > 0) {
                pr($_POST);
            }
        } else {
            $response['message'] = $return_message;
            $response['status'] = "210";
            $this->response($response, 200); // 200 being the HTTP response code
        }
    }

    public function s3accessdetails() {

        if ($this->is_valid_auth_token(false, $return_message, $return_user_id)) {
            if (isset($this->request_data) && count($this->request_data) >= 0) {

                $data = filter_input_data($this->request_data);

                $mandatory_key = array();

                if (!mandatory_params_present($mandatory_key, $data, $missing_param)) {
                    $response['message'] = $missing_param;
                    $response['status'] = "201";
                    $this->response($response, 200); // 200 being the HTTP response code
                } else {
                    $response = array();

                    $response['message'] = "S3 Details";
                    $response['status'] = "200";
                    $response['details']['policy'] = base64_encode_custom(S3_POLICY);
                    $response['details']['key_prefix'] = base64_encode_custom(S3_KEY_PREFIX);
                    $response['details']['success_action_redirect'] = base64_encode_custom(S3_SUCCESS_REDIRECT);
                    $response['details']['signature'] = base64_encode_custom(S3_SIGNATURE);
                    $response['details']['access_key'] = base64_encode_custom(S3_ACCESS_KEY);
                    $response['details']['secret_key'] = base64_encode_custom(S3_SECRET_KEY);
                    $response['details']['region_name'] = base64_encode_custom(S3_REGION_NAME);
                    $this->response($response, 200); // 200 being the HTTP response code
                }
            } else {
                $response['message'] = "No Input Fields Found";
                $response['status'] = "201";
                $this->response($response, 200); // 200 being the HTTP response code
            }
        } else {
            $response['message'] = $return_message;
            $response['status'] = "210";
            $this->response($response, 200); // 200 being the HTTP response code
        }
    }

    function forgotpassword() {

        if ($this->is_valid_auth_token(false, $return_message, $return_user_id)) {
            if (isset($this->request_data) && count($this->request_data) > 0) {

                $data = filter_input_data($this->request_data);
                $mandatory_key = array('email');

                if (!mandatory_params_present($mandatory_key, $data, $missing_param)) {
                    $response['message'] = $missing_param;
                    $response['status'] = "201";
                    $this->response($response, 200); // 200 being the HTTP response code
                } else {
                    $response = array();

                    $response = $this->User_model->forgot_password($data);
                    
                    $this->response($response, 200); // 200 being the HTTP response code
                }
            } else {
                $response['message'] = "No Input Fields Found";
                $response['status'] = "201";
                $this->response($response, 200); // 200 being the HTTP response code
            }
        } else {
            $response['message'] = $return_message;
            $response['status'] = "210";
            $this->response($response, 200); // 200 being the HTTP response code
        }
    }

    /**
     * Function to reset password
     * @author	Jyoti
     * @Created	2-June-2018
     * @Updated	30-May-2018
     * @param	array
     * @return	array
     */
    public function resetpassword() {
        if ($this->is_valid_auth_token(true, $return_message, $return_user_id)) {
            if (isset($this->request_data) && count($this->request_data) > 0) {
                $data = filter_input_data($this->request_data);
                $mandatory_key = array('current_password', 'new_password');
                if (!mandatory_params_present($mandatory_key, $data, $missing_param)) {
                    $response['message'] = $missing_param;
                    $response['status'] = "201";
                    $this->response($response, 200); // 200 being the HTTP response code
                } else {
                    $response = array();
                    $data['user_id'] = $return_user_id;
                    $response = $this->User_model->reset_password($data);

                    $this->response($response, 200); // 200 being the HTTP response code
                }
            } else {
                $response['message'] = "No Input Fields Found";
                $response['status'] = "201";
                $this->response($response, 200); // 200 being the HTTP response code
            }
        } else {
            $response['message'] = $return_message;
            $response['status'] = "210";
            $this->response($response, 200); // 200 being the HTTP response code
        }
    }

    /**
     * Function to Edit Profile
     * @author	Jyoti
     * @Created	2-June-2018
     * @Updated	30-May-2018
     * @param	array
     * @return	array
     */
    public function edit_profile() {
        if ($this->is_valid_auth_token(true, $return_message, $return_user_id)) {
            if (isset($this->request_data) && count($this->request_data) > 0) {
                $data = filter_input_data($this->request_data);
                if (isset($data['email'])) {
                    $data['email'] = strtolower($data['email']);
                }
                $mandatory_key = array('full_name', 'email');

                $data['user_id'] = ($return_user_id > 0) ? $return_user_id : 0;

                if (!mandatory_params_present($mandatory_key, $data, $missing_param)) {
                    $response['message'] = $missing_param;
                    $response['status'] = "201";
                    $this->response($response, 200); // 200 being the HTTP response code
                } else {
                    $error = array();
                    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                        $error[] = "Please Enter Valid Email Address";
                    }
                    if (count($error) > 0) {
                        $estr = (count($error) > 1) ? "errors" : "error";
                        $response['message'] = count($error) . " {$estr} found : " . implode(', ', $error);
                        $response['status'] = "201";
                        $this->response($response, 200); // 200 being the HTTP response code
                    } else {
                        $user_data = $this->User_model->edit_user_detail($data);
                        $this->response($user_data, 200); // 200 being the HTTP response code
                    }
                }
            }
        } else {
            $response['message'] = $return_message;
            $response['status'] = "210";
            $this->response($response, 200); // 200 being the HTTP response code
        }
    }

    /**
     * Function to User Logout
     * @author	Jyoti
     * @Created	2-June-2018
     * @Updated	30-May-2018
     * @param	array
     * @return	array
     */
    public function user_logout() {
        if ($this->is_valid_auth_token(true, $return_message, $return_user_id)) {
            if (isset($this->request_data) && count($this->request_data) > 0) {
                $mandatory_key = array();
                $data = $this->request_data;
                $auth_token = isset($data['auth_token']) ? $data['auth_token'] : '';
                $device_token = isset($data['token']) ? $data['token'] : '';
                $data['user_id'] = $return_user_id;
                if (!mandatory_params_present($mandatory_key, $data, $missing_param)) {
                    $response['message'] = $missing_param;
                    $response['status'] = "201";
                    $this->response($response, 200); // 200 being the HTTP response code
                } else {
                    $user_data = $this->User_model->logout($data);
                    $this->response($user_data, 200); // 200 being the HTTP response code
                }
            }
        } else {
            $response['message'] = $return_message;
            $response['status'] = "210";
            $this->response($response, 200); // 200 being the HTTP response code
        }
    }

}

?>
