<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('User_model');
    }

    public function index() {
        $data = array();
        
        if(isset($_GET['push']) && $_GET['push'] == '1') {
            $inp = array('title' => 'Questionnaire App Title', 'message' => 'Here goes the full notification message in application', 'device_type' => DEVICE_TYPE_ANDROID, 'device_token' => 'csVt8SpJMHQ:APA91bEAcDZ-lz72z8hOIYlbMHB_zNUc-8QpdzYqTyH_k4hqQSumvspbSXJ4Ca_YUVKKChva8yLnpiZbK-Kb2qtWZqK9gGKCUKEmZbtTHxL8COYdEkW-MufCXwYO8x1XWqIWkKyXx9piSn_4l9hkHf0aljG7D2wSsA');
            sendPushNotification($inp);
        }
        
        if (isset($_POST) && count($_POST) > 0) {
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                
            } else {
                $st = $this->User_model->admin_login($_POST);
                
                if ($st === true) {
                    redirect('admin/dashboard');
                } else {
                    $data['error_message'] = $st;
                }
            }
        }
        $this->load->view('admin/login_page', $data);
    }

}
