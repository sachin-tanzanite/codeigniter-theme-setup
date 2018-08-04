<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('phpass-0.1/PasswordHash.php');

define('STATUS_ACTIVATED', '1');
define('STATUS_NOT_ACTIVATED', '0');

/**
 * User_auth
 *
 * Authentication library.
 *
 * @package		User_auth
 * @author		vineet gupta (vineet.gupta@tanzaniteinfotech.com)
 * @version		0.1
 */
class User_auth
{
	private $error = array();

	function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->config('user_auth', TRUE);
		$this->ci->load->library('session');
		$this->ci->load->database();
	}

	
	/**
	 * Generate hass for user password
	 * $password
	 *
	 * @param	string
	 * @return	string
	 */
	function generatePassword($password)
	{
		if(!empty($password)) {
			// Hash password using phpass
			$hasher = new PasswordHash(
				$this->ci->config->item('phpass_hash_strength', 'tanza_auth'),
				$this->ci->config->item('phpass_hash_portable', 'tanza_auth'));
			$hashed_password = $hasher->HashPassword($password);
			return $hashed_password;
		}
		return NULL;
	}
	
	/**
	 * Login user on the site. Return TRUE if login is successful
	 * (user exists and activated, password is correct), otherwise FALSE.
	 *
	 * @param	string	(username or email or both depending on settings in config file)
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function checkPassword($password, $user_password)
	{
		// Does password match hash in database?
		$hasher = new PasswordHash(
			$this->ci->config->item('phpass_hash_strength', 'tanza_auth'),
			$this->ci->config->item('phpass_hash_portable', 'tanza_auth')
		);
		if ($hasher->CheckPassword($password, $user_password)) {		// password ok
			return TRUE;
		} 
		return FALSE;
	}
		
	function getUserInfo() {
		return $this->ci->session->userdata('userId');
	}

	/**
	 * Check if user logged in. Also test if user is activated or not.
	 *
	 * @param	bool
	 * @return	bool
	 */
	function is_logged_in()
	{
		$userId = $this->getUserInfo();
		if(!empty($userId)) {
			return $userId;
		}
		return false;
	}

	/**
	 * Get error message.
	 * Can be invoked after any failed operation such as login or register.
	 *
	 * @return	string
	 */
	function get_error_message()
	{
		return $this->error;
	}
	
	
	/**
	 * Get user_group_id
	 *
	 * @return	string
	 */
	function get_user_group_id()
	{
		return $this->ci->session->userdata('role');
	}

}

/* End of file User_auth.php */
/* Location: ./application/libraries/User_auth.php */