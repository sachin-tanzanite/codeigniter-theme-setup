<?php
if (!function_exists('is_admin_login')) {
    
    function is_admin_login($redirect = true) {
        $islogin = false;
        if (isset($_COOKIE['user_login']) && trim($_COOKIE['user_login']) != '') {
            $decoded_data = base64_decode_custom($_COOKIE['user_login']);
            $data = json_decode($decoded_data, true);
            if (isset($data['id']) && ($data['id']) > 0) {
                $islogin = true;
            } else {
                $islogin = false;
            }
        }
        if ($islogin) {
            return true;
        } else {
            if ($redirect) {
                redirect('admin/login');
            } else {
                return false;
            }
        }
    }
}

if (!function_exists('has_admin_permission')) {
    
    function has_admin_permission($permission) {
        if (trim($permission) == '') {
            return false; // invalid permission
        }
        $admin_details = get_admin_user_details();

        if (isset($admin_details['id']) && $admin_details['id'] > 0) {
            if ($admin_details['user_type'] == USER_TYPE_SUPERADMIN) {
                return true; // super admin has all access
            } else {

                $user_permission_arr = (trim($admin_details['user_permissions']) != '' && substr($admin_details['user_permissions'], 0, 1) == "{") ? json_decode($admin_details['user_permissions'], true) : array();

                $parent_permission = $permission;
                $sub_permision = 0;
                if (strpos($permission, "_") !== false) {
                    $exp = explode("_", $permission);
                    $parent_permission = $exp[0];
                    $sub_permision = $exp[1];
                }

                if ($parent_permission > 0) {
                    if (isset($user_permission_arr[$parent_permission])) {
                        // check sub permission
                        if (trim($sub_permision) != '' && $sub_permision != 0) {
                            if (in_array($permission, $user_permission_arr[$parent_permission])) {
                                return true; // has sub permission
                            }
                            return false; // user don't have sub permission
                        }
                        return true; // has parent permission
                    } else {
                        return false; // user don't have parent permission
                    }
                } else {
                    return false; // invalid permission type
                }
            }
        } else {
            return false; // admin details not found
        }
    }
}

if (!function_exists('get_header_tag_data')) {
    
    function get_header_tag_data() {
        global $_SERVER;
        $str = APP_NAME;
        if (isset($_SERVER['REDIRECT_QUERY_STRING']) && trim($_SERVER['REDIRECT_QUERY_STRING']) != '') {
            return $str . (ucwords(str_replace("/", " > ", ($_SERVER['REDIRECT_QUERY_STRING']))));
        } else {
            return $str . " > Admin Panel";
        }
    }
}

if (!function_exists('get_admin_user_details')) {
    
    function get_admin_user_details($key = 'all') {

        if (isset($_COOKIE['user_login']) && trim($_COOKIE['user_login']) != '') {
            $decoded_data = base64_decode_custom($_COOKIE['user_login']);
            $data = json_decode($decoded_data, true);

            if (isset($data['id']) && count($data['id']) > 0) {
                $ci = & get_instance();
                $sql = "Select * from " . TABLE_ACCOUNTS_USER . " Where `id` = ?";
                $result = $ci->db->query($sql, $data['id']);

                $result_array = $result->row_array();

                if (isset($result_array['id']) && $result_array['id'] > 0) {
                    return ($key == 'all') ? $result_array : (isset($result_array[$key]) ? $result_array[$key] : false);
                } else {
                    return false;
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
}

if (!function_exists('set_error_message')) {
    
    function set_error_message($message) {
        $ci = & get_instance();
        $ci->session->set_userdata('error_message', (is_array($message)) ? implode('<br>', $message) : $message);
    }
}

if (!function_exists('set_success_message')) {
    
    function set_success_message($message) {
        $ci = & get_instance();
        $ci->session->set_userdata('success_message', $message);
    }
}

if (!function_exists('get_error_message')) {
    
    function get_error_message() {
        $ci = & get_instance();
        $error = $ci->session->userdata('error_message');
        $html = '';

        if ($error != '') {
            $html = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong>' . $error . '</strong></div>';
            $ci->session->unset_userdata('error_message');
        }
        return $html;
    }
}

if (!function_exists('get_success_message')) {
    
    function get_success_message() {
        $ci = & get_instance();
        $success = $ci->session->userdata('success_message');

        $html = '';

        if ($success != '') {
            $html = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong>' . $success . '</strong></div>';
            $ci->session->unset_userdata('success_message');
        }
        return $html;
    }
}

if (!function_exists('display_number_format')) {
    
    function display_number_format($num) {
        return number_format($num);
    }
}

if (!function_exists('set_search_filters')) {
    
    function set_search_filters($input, $delete_action = array()) {
        /*
          input types :
         * text :: text search
         * text_2 :: text search
         * date_range :: date from - to search
         * status :: search by particular status
         * class :: search by particular class
         * subject :: search by particular subject
         * topic :: search by particular topic
         */

        /*
          delete action :
         * title :: title to display
         * action :: path to redirect
         * method :: post
         * heading :: section heading (default 'take action')
         */

        $ci = & get_instance();

        $form_action = '';
        if (isset($input['action'])) {
            $form_action = $input['action'];
            unset($input['action']);
        }
        if (count($input) == 0) {
            //$input['text'] = array('title' => 'Search By Text', 'placeholder' => 'Search By Text', 'name' => 'text_search');
        }
        $html = '';
        $filter_data = isset($_GET['filter']) ? $_GET['filter'] : array();

        $filer_count = count($input);

        if (isset($input['date_range']) && count($input['date_range']) == 2) {
            $filer_count = $filer_count + 1;
        }


        $width_class = ($filer_count > 0) ? ceil(12 / $filer_count) : 0;
        $width_class = 3;

        $html = '<div class="row" id="_filter_row">';
        if (count($input) > 0) {
            $html .= '<div class="col-xs-12 col-sm-12">';
            $html .= '<div class="search-area well well-sm">';
            $html .= '<div class="search-filter-header bg-primary"><h5 class="smaller no-margin-bottom"><i class="ace-icon fa fa-sliders light-green bigger-130"></i>&nbsp; Refine your Search [<a class="white" href="' . $form_action . '">Reset Filters</a>]</h5></div>';
            $html .= '<div class="space-10"></div>';
            $html .= '<form method="get" autocomplete="off" action = "' . $form_action . '">';
            if (isset($input['text']['title']) && $input['text']['title'] != '') {
                $val = isset($filter_data[$input['text']['name']]) ? $filter_data[$input['text']['name']] : '';
                $html .= '<div class="col-xs-10 col-sm-' . $width_class . '"><label>' . ucwords($input['text']['title']);
                $html .= '<div class="input-group"><span class="input-group-addon"><i class="fa fa-search bigger-110"></i></span><input class=" form-control search" placeholder="' . ucwords($input['text']['placeholder']) . '" type="text" value="' . $val . '" name="filter[' . $input['text']['name'] . ']" /></div>';
                $html .= '</label></div>';
            }
            if (isset($input['text_2']['title']) && $input['text_2']['title'] != '') {
                $val = isset($filter_data[$input['text_2']['name']]) ? $filter_data[$input['text_2']['name']] : '';
                $html .= '<div class="col-xs-10 col-sm-' . $width_class . '"><label>' . ucwords($input['text_2']['title']);
                $html .= '<div class="input-group"><span class="input-group-addon"><i class="fa fa-search bigger-110"></i></span><input class=" form-control search" placeholder="' . ucwords($input['text_2']['placeholder']) . '" type="text" value="' . $val . '" name="filter[' . $input['text_2']['name'] . ']" /></div>';
                $html .= '</label></div>';
            }

            if (isset($input['date_range']) && count($input['date_range']) > 0) {
                if (isset($input['date_range']['from']['title']) && $input['date_range']['from']['title'] != '') {
                    $val = isset($filter_data[$input['date_range']['from']['name']]) ? $filter_data[$input['date_range']['from']['name']] : '';
                    $html .= '<div class="col-xs-10 col-sm-' . $width_class . '"><label>' . ucwords($input['date_range']['from']['title']);
                    $html .= '<div class="input-group"><span class="input-group-addon"><i class="fa fa-clock-o bigger-110"></i></span><input dateformat="yyyy-mm-dd" readonly class=" date-picker form-control search" placeholder="' . ucwords($input['date_range']['from']['placeholder']) . '" type="text" value="' . $val . '" name="filter[' . $input['date_range']['from']['name'] . ']" /></div>';
                    $html .= '</label></div>';
                }

                if (isset($input['date_range']['to']['title']) && $input['date_range']['to']['title'] != '') {
                    $val = isset($filter_data[$input['date_range']['to']['name']]) ? $filter_data[$input['date_range']['to']['name']] : '';
                    $html .= '<div class="col-xs-10 col-sm-' . $width_class . '"><label>' . ucwords($input['date_range']['to']['title']);
                    $html .= '<div class="input-group"><span class="input-group-addon"><i class="fa fa-clock-o bigger-110"></i></span><input dateformat="yyyy-mm-dd" readonly class=" date-picker form-control search" placeholder="' . ucwords($input['date_range']['to']['placeholder']) . '" type="text" value="' . $val . '" name="filter[' . $input['date_range']['to']['name'] . ']" /></div>';
                    $html .= '</label></div>';
                }
            }

            if (isset($input['status']['title']) && $input['status']['title'] != '') {
                $nwc = ($filer_count < 5) ? ($width_class - 1) : $width_class;
                $status_type = $ci->config->config['user_status'];
                $val = isset($filter_data[$input['status']['name']]) ? $filter_data[$input['status']['name']] : '';
                $html .= '<div class="col-xs-10 col-sm-' . $nwc . '"><label>' . ucwords($input['status']['title']);
                $html .= '<div class="input-group"><span class="input-group-addon"><i class="fa fa-hourglass-start bigger-110"></i></span><select class=" form-control search" name="filter[' . $input['status']['name'] . ']"><option value="">All</option>';
                foreach ($status_type as $a => $b) {
                    $sel = (trim($val) != '' && $a == $val) ? "selected" : '';
                    $html .= '<option ' . $sel . ' value="' . $a . '">' . $b['title'] . '</option>';
                }
                $html .= '</select></div>';
                $html .= '</label></div>';
            }

            $html .= '<input type="submit" value="Search" class="btn btn-primary" style="margin-top: 21px; padding:6px 3px; line-height: 12px;"></form>';

            $html .= '</div>';
            $html .= '</div>';
        }
        $html .= '</div>';

        // add dropdown section
        $heading = (isset($delete_action['heading']) && trim($delete_action['heading']) != '') ? $delete_action['heading'] : "Take Action";
        $action = (isset($delete_action['action']) && trim($delete_action['action']) != '') ? $delete_action['action'] : $form_action;
        $delete_title = (isset($delete_action['title']) && trim($delete_action['title']) != '') ? $delete_action['title'] : 'Delete Selected';

        $html .= '<div class="row" id="_checkbox_row" style="display:none">';
        if (count($delete_action) > 0) {
            $html .= '<div class="col-xs-12 col-sm-12">';
            $html .= '<div class="search-area well well-sm">';
            $html .= '<div class="search-filter-header bg-primary"><h5 class="smaller no-margin-bottom"><i class="ace-icon fa fa-sliders light-green bigger-130"></i>&nbsp; ' . $heading . '</h5></div>';
            $html .= '<div class="space-10"></div>';
            $html .= '<form method="post" action = "' . $action . '" onsubmit="return validate(this)">';
            $html .= '<div class="col-xs-10 col-sm-3"><label>Select Action';

            $html .= '<div class="input-group"><span class="input-group-addon"><i class="fa fa-trash bigger-110"></i></span><select class="select_action form-control" name="action"><option value="">Select Action</option>';
            $html .= '<option value="delete">' . $delete_title . '</option>';
            $html .= '</select></div><input type="hidden" name="checked_ids" value="" id="checked_ids">';
            $html .= '</label></div>';

            $html .= '<button type="submit" name="action" value="delete" class="btn btn-primary go_button" style="margin-top: 21px; padding:6px 3px; line-height: 12px;">Go</button></form>';
            $html .= '</div>';
            $html .= '</div>';
        }
        $html .= '</div>';
        return $html;
    }
}