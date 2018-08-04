<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_model extends CI_Model {

    public function __construct() {
        
    }

    function get_dashboard_counts() {

        $result = array();

        // Students count
        $where_condition = array(USER_TYPE_STUDENT, STATUS_ACTIVE);
        $sql = "select count(distinct c.id) as total from " . TABLE_ACCOUNTS_USER . " c where c.user_type = ? and c.status = ?";
        $output = $this->db->query($sql, $where_condition);
        $row_array = $output->row_array();
        $result['student_count'] = isset($row_array['total']) ? (int) $row_array['total'] : 0;

        // Classes count
        $where_condition = array(STATUS_ACTIVE);
        $sql = "select count(distinct c.id) as total from " . TABLE_CLASSES_LIST . " c where c.status = ?";
        $output = $this->db->query($sql, $where_condition);
        $row_array = $output->row_array();
        $result['class_count'] = isset($row_array['total']) ? (int) $row_array['total'] : 0;

        // Subjects count
        $where_condition = array(STATUS_ACTIVE);
        $sql = "select count(distinct c.id) as total from " . TABLE_SUBJECTS_LIST . " c where c.status = ?";
        $output = $this->db->query($sql, $where_condition);
        $row_array = $output->row_array();
        $result['subject_count'] = isset($row_array['total']) ? (int) $row_array['total'] : 0;

        // Topics count
        $where_condition = array(STATUS_ACTIVE);
        $sql = "select count(distinct c.id) as total from " . TABLE_TOPICS_LIST . " c where c.status = ?";
        $output = $this->db->query($sql, $where_condition);
        $row_array = $output->row_array();
        $result['topic_count'] = isset($row_array['total']) ? (int) $row_array['total'] : 0;

        // Questionnaire count
        $where_condition = array(STATUS_ACTIVE);
        $sql = "select count(distinct c.id) as total from " . TABLE_QUESTIONNAIRE_LIST . " c where c.status = ?";
        $output = $this->db->query($sql, $where_condition);
        $row_array = $output->row_array();
        $result['questionnaire_count'] = isset($row_array['total']) ? (int) $row_array['total'] : 0;

        // Exams count
        $where_condition = array(0);
        $sql = "select count(distinct c.id) as total from " . TABLE_QUESTIONNAIRE_RESULTS . " c where c.qid > ?";
        $output = $this->db->query($sql, $where_condition);
        $row_array = $output->row_array();
        $result['exam_count'] = isset($row_array['total']) ? (int) $row_array['total'] : 0;


        return $result;
    }

    /**
     * Function to log activity
     *
     * @author	Sachin
     * @Created	15-May-2018
     * @Updated	15-May-2018
     * @param	array
     * @return	array
     */
    function log_activity($data) {
        $result = array();

        $action = isset($data["action"]) ? $data["action"] : '';
        $url = isset($data["url"]) ? $data["url"] : '';
        $content = isset($data["content"]) ? $data["content"] : '';
        $target_user_id = isset($data["user_id"]) ? $data["user_id"] : '0';
        $additional_content = isset($data["additional_content"]) ? $data["additional_content"] : '';
        $object_id = isset($data["object_id"]) ? $data["object_id"] : '0';
        $owner_id = (isset($data["owner_id"]) && $data["owner_id"] > 0) ? $data["owner_id"] : NULL;


        if ($target_user_id > 0) {
            if ($object_id > 0) {

                $field = array();
                $field["action"] = $action;
                $field["url"] = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
                $field["content"] = $content;
                $field["target_user_id"] = $target_user_id;
                $field["additional_content"] = $additional_content;

                $field["owner_id"] = $owner_id;


                $field["object_id"] = $object_id;

                $field["timestamp"] = get_date_time();
                $sql_ins = $this->db->insert(TABLE_ACTIVITIES_ACTIVITY, $field);

                $last_id = $this->db->insert_id();

                if ($last_id > 0) {
                    $result['status'] = '200';
                    $result['message'] = "Activity saved successfully";
                } else {
                    $result['status'] = '202';
                    $result['message'] = "Activity not saved";
                }
            } else {
                $result['status'] = '202';
                $result['message'] = "Target not found";
            }
        } else {
            $result['status'] = '202';
            $result['message'] = "User not found";
        }

        return $result;
    }

    function generate_pagination($data) {
        $config = [];
        $config["base_url"] = $data['base_url'];
        $config["per_page"] = $data['per_page']; //10;
        if (isset($data['anchor_class'])) {
            $config['attributes'] = array('class' => $data['anchor_class']); //10;
        }



        $config['num_links'] = 5;
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['use_page_numbers'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = TRUE;
        $config["total_rows"] = $data['total_rows']; //$this->db->count_all("users");
        $this->pagination->initialize($config);

        return explode('&nbsp;', $this->pagination->create_links());
    }

    function insert_push_notification($data) {
        /* student_id
         * push_type
         * message
         */
        $where_condition = array();
        $student_id = (isset($data['student_id']) && $data['student_id'] > 0) ? $data['student_id'] : '0';
        $push_type = (isset($data['push_type']) && $data['push_type'] > 0) ? $data['push_type'] : '0';
        $message = (isset($data['message']) && $data['message'] != '') ? $data['message'] : '';

        if ($student_id > 0 && $push_type > 0) {
            $where_condition = array($student_id);
            $sql = "Select user_id, token, platform from " . TABLE_ACCOUNTS_DEVICETOKEN . " where user_id = ? ";
            $output = $this->db->query($sql, $where_condition);
            
            $result_array = $output->result_array();
            if (count($result_array) > 0) {
                $device_ids = array();
                foreach ($result_array as $k => $v) {
                    $notification_data = array();
                    $notification_data['user_id'] = $v['user_id'];
                    $notification_data['push_type'] = $push_type;
                    $notification_data['device_token'] = $v['token'];
                    $notification_data['device_type'] = $v['platform'];
                    $notification_data['created_date'] = get_date_time();
                    $notification_data['modified_date'] = get_date_time();
                    $sql = $this->db->insert(TABLE_PUSH_NOTIFICATIONS, $notification_data);
                    $last_id = $this->db->insert_id();
                    if ($last_id > 0) {
                        $notification_data['notification_id'] = $last_id;
                        $device_ids[] = $notification_data;
                    }
                }
                if (count($device_ids) > 0) {
                    return $device_ids;
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

}
