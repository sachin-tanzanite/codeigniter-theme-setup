<?php //echo $this->uri->uri_string(); pr($this->uri->segments);die;             ?>
<?php
$segments = $this->uri->segment_array();
$search_array = array();

//foreach ($segments as $segment) {
//    $search_array['controller'] = $segments[2];
//    if (!empty($segments[3])) {
//        $search_array['method'] = $segments[3];
//    } else {
//        $search_array['method'] = '';
//    }
//}
//pr($search_array);
?>


<div id="sidebar" class="sidebar responsive ace-save-state">
    <script type="text/javascript">
        try {
            ace.settings.loadState('sidebar')
        } catch (e) {
        }
    </script>

    <ul class="nav nav-list">
        <li>
            <a href="<?php echo base_url(); ?>admin/dashboard">
                <i class="menu-icon fa fa-tachometer"></i> 
                <span class="menu-text"> Dashboard </span>
            </a>
            <b class="arrow"></b>
        </li>

        <?php if(has_admin_permission(PERMISSION_TYPE_STUDENT)){?>
        <li class="">
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-users"></i>
            <span class="menu-text">Student Mgmt.</span>
            <b class="arrow fa fa-angle-down"></b>
        </a>
        <b class="arrow"></b>
        <ul class="submenu">
            
            <li class=""><a href="<?php echo base_url(); ?>admin/users/students" >View Students </a><b class="arrow"></b></li>
            <?php if(has_admin_permission(PERMISSION_TYPE_STUDENT_ADD_NEW)){?>
            <li> <a href="<?php echo base_url(); ?>admin/users/add_student" >Add New Student</a>  </li>
            <?php }?>
        </ul>
        </li>
        <?php
        }
        if(has_admin_permission(PERMISSION_TYPE_CLASS)){
        ?>
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-list"></i>
                <span class="menu-text"> Classes Mgmt. </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li> <a href="<?php echo base_url(); ?>admin/classes" >View Classes</a>  </li>
                <?php if(has_admin_permission(PERMISSION_TYPE_CLASS_ADD_NEW)){?>
                <li> <a href="<?php echo base_url(); ?>admin/classes/add_class" > Add New Class</a>  </li>
                <?php }?>
            </ul>
        </li>
        <?php
        }
        if(has_admin_permission(PERMISSION_TYPE_SUBJECT)){
        ?>
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-book"></i>
                <span class="menu-text"> Subjects Mgmt. </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li> <a href="<?php echo base_url(); ?>admin/subjects" > View Subjects</a>  </li>
                <?php if(has_admin_permission(PERMISSION_TYPE_SUBJECT_ADD_NEW)){?>
                <li> <a href="<?php echo base_url(); ?>admin/subjects/add_subject" >Add Subject</a>  </li>
                <?php }?>
            </ul>
        </li>
        <?php
        }
        if(has_admin_permission(PERMISSION_TYPE_TOPIC)){
        ?>
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-list-ol"></i>
                <span class="menu-text"> Topics Mgmt. </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li> <a href="<?php echo base_url(); ?>admin/topics" > View Topics</a>  </li>
                <?php if(has_admin_permission(PERMISSION_TYPE_TOPIC_ADD_NEW)){?>
                <li> <a href="<?php echo base_url(); ?>admin/topics/add_topic" >Add Topic</a>  </li>
                <?php }?>
            </ul>
        </li>
        <?php
        }
        if(has_admin_permission(PERMISSION_TYPE_ASSIGNMENT)){
        ?>
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-list-ol"></i>
                <span class="menu-text"> Assignments Mgmt. </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li> <a href="<?php echo base_url(); ?>admin/assignments" > View Assignments</a>  </li>
                <?php if(has_admin_permission(PERMISSION_TYPE_ASSIGNMENT_ADD_NEW)){?>
                <li> <a href="<?php echo base_url(); ?>admin/assignments/add_assignment" >Add Assignments</a>  </li>
                <?php }?>
            </ul>
        </li>
        <?php
        }
        if(has_admin_permission(PERMISSION_TYPE_QUESTIONNAIRE)){
        ?>
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon ace-icon fa fa-graduation-cap"></i>
                <span class="menu-text"> Questionniare Mgmt. </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li> <a href="<?php echo base_url(); ?>admin/questionnairs" > View Questionairs</a>  </li>
                <?php if(has_admin_permission(PERMISSION_TYPE_QUESTIONNAIRE_ADD_NEW)){?>
                <li> <a href="<?php echo base_url(); ?>admin/questionnairs/add_new_questionnairs" > Add Questionairs</a>  </li>
                <?php }?>
                <li> <a href="<?php echo base_url(); ?>admin/questionnairs/admin_results" > View Results </a>  </li>
               
            </ul>
        </li>
        <?php
        }
        if(has_admin_permission(PERMISSION_TYPE_ADMIN)){
        ?>
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-user"></i>
                <span class="menu-text"> Admin User Mgmt. </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li> <a href="<?php echo base_url(); ?>admin/users/admin_users" > View Admin Users </a>  </li>
                <?php if(has_admin_permission(PERMISSION_TYPE_ADMIN_ADD_NEW)){?>
                <li> <a href="<?php echo base_url(); ?>admin/users/add_admin_user" >Add Admin User</a>  </li>
                <?php }?>
            </ul>
        </li>
        <?php }?>
    </ul><!-- /.nav-list -->

    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
</div>
