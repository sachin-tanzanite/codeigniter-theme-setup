<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
        public function __construct() {
		parent::__construct();
	}
        
	public function index() {
            $data = array();
            
            $dir_path = str_replace("\\","/",str_replace("\application\controllers", "", __DIR__));
            $dir_path = str_replace($_SERVER['DOCUMENT_ROOT'], '', $dir_path);
            if(!isset($_POST['root_path'])) {
                $_POST['root_path'] = $dir_path.'/';
            }
            
            if(!isset($_POST['site_url'])) {
                $_POST['site_url'] = 'http://'.$_SERVER['HTTP_HOST'].$_POST['root_path'];
            }
            
            if(!isset($_POST['step'])) {
                $_POST['step'] = '1';
            }
            
            $previous_data = (is_array($this->session->userdata('setup_details')) && count($this->session->userdata('setup_details')) > 0) ? $this->session->userdata('setup_details') : array();
            
            if(isset($_POST['submit_details']) && trim($_POST['submit_details']) != '') {
                $_POST['step'] = $_POST['step']+1;
                
                $_POST = (count($previous_data) > 0) ? array_merge($previous_data, $_POST) : $_POST;
                $this->session->set_userdata('setup_details', $_POST);
            } elseif(isset($_POST['back_step']) && trim($_POST['back_step']) != '') {
                $_POST['step'] = $_POST['step']-1;
                
                $_POST = (count($previous_data) > 0) ? array_merge($previous_data, $_POST) : $_POST;
                $this->session->set_userdata('setup_details', $_POST);
            }
            
            if(is_array($this->session->userdata('setup_details')) && count($this->session->userdata('setup_details')) > 0) {
                $_POST = $this->session->userdata('setup_details');
            }
            //pr($_POST);
	    $this->load->view('welcome', $data);
	}
	
	
}
