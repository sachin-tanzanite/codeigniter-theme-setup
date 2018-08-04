<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
function err_page($code = 404) {
    header("HTTP/1.0 404 Not Found");
    echo 'Invalid Access';
}

function get_date_time($format = '', $date = '') {
    date_default_timezone_set('UTC');
    
    
    date_default_timezone_set('Asia/Calcutta');
    

    if (trim($date) == '') {
        $date = date('Y-m-d H:i:s');
    }
    if (trim($format) == '') {
        $format = 'Y-m-d H:i:s';
    }

    return date($format, strtotime($date));
}

function get_category_id_from_url($url) {
    $cat_id = 0;
    if (trim($url) != '') {
        $exp = explode('/', $url);
        sort($exp);

        foreach ($exp as $a) {
            if (is_numeric($a) && $a > 0) {
                $cat_id = $a;
                break;
            }
        }
    }
    return $cat_id;
}

function get_follow_api_url($user_id) {
    return BASE_URL . API_BASE_PATH . 'users/' . $user_id . '/follow/';
}

function get_follows_api_url($user_id) {
    return BASE_URL . API_BASE_PATH . 'users/' . $user_id . '/follows/';
}

function get_categories_zip_path() {
	return BASE_URL . '/assets/categories.zip';
}

function get_followed_by_api_url($user_id) {
    return BASE_URL . API_BASE_PATH . 'users/' . $user_id . '/followed_by/';
}

function get_user_details_api_url($user_id) {
    return BASE_URL . API_BASE_PATH . 'users/' . $user_id . '/';
}

function get_categories_api_url($user_id) {
    return BASE_URL . API_BASE_PATH . 'users/' . $user_id . '/categories/categories_followed/';
}

function get_views_api_url($user_id) {
    return BASE_URL . API_BASE_PATH . 'users/' . $user_id . '/views/';
}

function get_categories_api_url_by_category_id($category_id) {
    return BASE_URL . API_BASE_PATH . 'categories/' . $category_id . '/';
}

function get_hashtag_api_url_by_hashtag_id($hashtag_id) {
    return BASE_URL . API_BASE_PATH . 'hashtags/' . $hashtag_id . '/';
}

function get_hashtags_from_string($str) {

    preg_match_all('/#([^.,\s]+)/', $str, $matches);
    //$hashtags = implode(',', $matches[1]);
    $hashtags = $matches[1];
    return $hashtags;
}

function get_mentioned_users_from_string($str) {

    preg_match_all('/@([^.,\s]+)/', $str, $matches);
    //$usernames = implode(',', $matches[1]);
    $usernames = $matches[1];
    return $usernames;
}

function clean_string($string) {
	return filter_username($string);
    return preg_replace(array('#[\\s-]+#', '#[^A-Za-z0-9\. -]+#'), array(' ', ''), $string);
}

function base64_encode_custom($str) {
    /* ---- custom encoding process ----
      -- step 1 : encode value
      -- step 2 : inter-change characters
      -- step 3 : return string
      ------- end --------- */
    $str = base64_encode($str);
    $from = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
    $to = "zyxwvutsrqponmlkjihgfedcbaZYXWVUTSRQPONMLKJIHGFEDCBA9876543210-_";
    $str = strtr($str, $from, $to); // inter-change characters
    return $str;
}

function base64_decode_custom($str) {
    /* ---- custom decoding process ----
      -- step 1 : inter-change characters
      -- step 2 : decode value
      -- step 3 : return string
      ------- end --------- */
    $from = "zyxwvutsrqponmlkjihgfedcbaZYXWVUTSRQPONMLKJIHGFEDCBA9876543210-_";
    $to = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
    $str = strtr($str, $from, $to); // inter-change characters
    $str = base64_decode($str);
    return $str;
}




function send_mail($email, $subject, $message, &$return_message) {
    
    $mail = new PHPMailer();
    $mail->IsSMTP(); // we are going to use SMTP
    $mail->SMTPAuth = true; // enabled SMTP authentication
    $mail->SMTPSecure = "tls";  // prefix for secure protocol to connect to the server
    $mail->Host = "smtp.gmail.com";      // setting GMail as our SMTP server
    $mail->Port = 587;                   // SMTP port to connect to GMail
    $mail->Username = "tanzanite.questionareapp@gmail.com";  // user email address
    $mail->Password = "Divij@123";            // password in GMail
    $mail->SetFrom('tanzanite.questionareapp@gmail.com', 'Questionnare Application'); 
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->IsHTML(true);
    $mail->AddAddress($email);

    
    if (!$mail->Send()) {
        $return_message = "Error: " . $mail->ErrorInfo;
        return false;
    } else {
        $return_message = "Message sent correctly!";
		return true;
    }
}

function filter_username($string) {
    return strtolower(preg_replace(array('#[\\s-]+#', '#[^A-Za-z0-9\. _-]+#'), array('', ''), $string));
}

function get_hashtag_ids_from_encoded_string($str) {
	$ids = array();	
	$exp = '{##HASHTAG-';
	$exp2 = '##}';
	$arr = explode($exp,$str);
	if(count($arr) > 0) {
		foreach($arr as $a) {
			if($a != '') {
				$exp_new = explode($exp2, $a);
				if(isset($exp_new[0]) && is_numeric($exp_new[0]) && $exp_new[0] > 0) {
					$ids[] = $exp_new[0];
				}
			}
		}
	}
	return @array_unique($ids);
}

function get_user_ids_from_encoded_string($str) {
	$ids = array();	
	$exp = '{##USER-';
	$exp2 = '##}';
	$arr = explode($exp,$str);
	if(count($arr) > 0) {
		foreach($arr as $a) {
			if($a != '') {
				$exp_new = explode($exp2, $a);
				if(isset($exp_new[0]) && is_numeric($exp_new[0]) && $exp_new[0] > 0) {
					$ids[] = $exp_new[0];
				}
			}
		}
	}
	return @array_unique($ids);
}

function sendPushNotification($data) {
    $API_ACCESS_KEY = 'AAAAgO58Xv8:APA91bH5Fcv2FGnM8PLVMSdgs3aYN-Rozi7IcF8hYbHrHB6_K7e8_Z3wmfDqN4dncWdcQFJW_MrpNqPG_7oteNzrIACZi6TmZR9FlevnO31xCqvKsuYSQWHDgFjf0FZhA-t9qHWhH--zNBRJvquUjiSGIJ46fSkAjg';
    
    /* data params
     * user_id :: db id
     * notification_id :: db id
     * title :: notification title
     * message :: notifcation message
     * device_type :: 1, 2 
     * device_token :: unique app token
     * extra :: push_type, push_message
     */
    $error = array();
    
    if(!(isset($data['title']) && trim($data['title']) != '')) {
        $error[] = "Notification Title Not Found";
    }
    if(!(isset($data['message']) && trim($data['message']) != '')) {
        $error[] = "Notification Message Not Found";
    }
    if(!(isset($data['device_type']) && trim($data['device_type']) > '0')) {
        $error[] = "Device Type Not Found";
    }
    if(!(isset($data['device_token']) && trim($data['device_token']) != '')) {
        $error[] = "Device Token Not Found";
    }
    
    if(count($error) == 0) {
        $registrationIds = $data['device_token'];
        //$registrationIds = 'dS5A9YVrxP0:APA91bHtnzU95dYLL9eDf60fYIdpi1eB6RNP4IXNunVfhFgmVX5KU5xoM3GOnI0EZeDdj0FSU2POhIQZMLXQ8mB2qr8FdEEo1oAPCUv_nbaXt1bg7c_XGt6_scUhl1u5Q92bnfuemeOG8jha1cdA3xPw7-tUNm2TCw';
        #prep the bundle
        $msg = array(
            'body' 	=> $data['message'],
            'title'	=> $data['title']
        );
        
        if(isset($data['extra']) && count($data['extra']) > 0) {
            $msg["extra"] = $data['extra'];
        }
         
        if(isset($data['notification']['icon']) && trim($data['notification']['icon']) != '') {
            $msg["icon"] = $data['notification']['icon'];
        }
        
        if(isset($data['notification']['sound']) && trim($data['notification']['sound']) != '') {
            $msg["sound"] = $data['notification']['sound'];
        }
        
        $fields = array(
            'to'		=> $registrationIds,
            'data'	=>          $msg
        );
        
        $headers = array(
            'Authorization: key=' . $API_ACCESS_KEY,
            'Content-Type: application/json'
        );
        
        #Send Reponse To FireBase Server	
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        #Echo Result Of FireBase Server
        //echo 'request :'.pr(json_encode( $fields ));
        //echo '<br/>';
        //pr(json_decode($result, true)); die;
    } else {
        return $error;
    }
}