<?php
$this->load->view('admin/header');
$add_edit_str = ($this->input->post('id') > 0) ? "Edit" : "Add";
$is_superadmin = ($this->input->post('user_type') != '' && $this->input->post('user_type') == USER_TYPE_SUPERADMIN ) ? true : false;
?>
<div class="main-container ace-save-state" id="main-container">
    <script type="text/javascript">
        try {
            ace.settings.loadState('main-container')
        } catch (e) {
        }
    </script>
    <?php $this->load->view('admin/sidebar'); ?>

    <div class="main-content">
        <div class="main-content-inner">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="ace-icon fa fa-home home-icon"></i>
                        <a href="<?php echo base_url(); ?>admin/dashboard">Home</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>admin/users/admin_users">Admin Users</a>
                    </li>
                    <li class="active"><?php echo $add_edit_str ?> Admin user</li>
                </ul><!-- /.breadcrumb -->


            </div>

            <div class="page-content">
                <div class="page-header">
                    <h1>
                        <?php echo $add_edit_str ?> Admin
                    </h1>
                </div><!-- /.page-header -->

                <div class="row">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->
                        <?php
                        echo get_error_message();
                        echo get_success_message();
                        echo form_open('admin/users/add_admin_user' . ($this->input->post('id') > 0 ? '/' . $this->input->post('id') : ''), 'class="form-horizontal"');
                        ?>
                        <input type="hidden" name="id" value="<?php echo $this->input->post('id'); ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right blue" for="form-field-1">User type </label>
                            <div class="col-sm-4">
                                <select class="form-control" id="user_type_id" name="user_type">
                                    <option value="0">Select User type</option>
                                    <?php
                                    $user_type = ($this->input->post('user_type') != '') ? $this->input->post('user_type') : '0';
                                    if (isset($this->config->config['user_type'])) {
                                        foreach ($this->config->config['user_type'] as $k => $v) {
                                            if ($k == USER_TYPE_STUDENT) {
                                                continue;
                                            }
                                            ?>
                                            <option value="<?php echo $k ?>" <?php
                                            if ($user_type == $k) {
                                                echo 'selected';
                                            }
                                            ?>> <?php echo $v['title']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>     

                                </select>
                                <?php echo form_error('user_type'); ?>
                            </div>

                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right blue" for="form-field-1"> Full Name </label>

                            <div class="col-sm-9">
                                <input type="text" id="form-field-1" placeholder="Full Name" name="full_name" value="<?php echo $this->input->post('full_name'); ?>" class="col-xs-10 col-sm-5" />
                                <?php echo form_error('full_name'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right blue" for="form-field-1"> Email address </label>
                            <div class="col-sm-9">
                                <input type="text" id="form-field-1" placeholder="Email address" name="email" value="<?php echo $this->input->post('email'); ?>" class="col-xs-10 col-sm-5" />
                                <?php echo form_error('email'); ?> 
                            </div>
                        </div>
                        <?php if ($this->input->post('id') == 0) { ?>


                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right blue" for="form-field-1"> Password </label>

                                <div class="col-sm-9">
                                    <input type="password" id="form-field-1" placeholder="Password" name="password"  class="col-xs-10 col-sm-5" />
                                    <?php echo form_error('password'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right blue" for="form-field-1"> Confirm password </label>

                                <div class="col-sm-9">
                                    <input type="password" id="form-field-1" placeholder="Confirm password"  name="confirm_password" class="col-xs-10 col-sm-5" />
                                    <?php echo form_error('confirm_password'); ?>
                                </div>
                            </div>
                        <?php } ?>

                        <?php
                        $permission_json_arr = ($this->input->post('user_permissions') != '') ? json_decode($this->input->post('user_permissions'), true) : array();
                        $permission_array = $this->config->config['user_permission_types'];
                        ?>

                        <div class="form-group <?php echo ($is_superadmin == true) ? 'hide' : ''; ?>" id='permissions_div'>
                            <label class="col-sm-3 control-label no-padding-right blue" for="form-field-1">User Permissions </label>

                            <div class="col-sm-9">
                                <ul id="tree1" class="pers_ul tree tree-unselectable" style="overflow: hidden">
                                    <?php
                                    foreach ($permission_array as $a => $b) {

                                        $checked = isset($permission_json_arr[$a]) ? true : false;
                                        $chk = ($checked) ? 'checked' : '';
                                        $display = ($checked) ? 'block' : 'none';
                                        $display = ($checked) ? 'block' : 'none';
                                        $sign = ($checked) ? 'minus' : 'plus';
                                        echo '<li ids="' . $a . '" id="li_item_' . $a . '" class="tree-branch" role="treeitem" aria-expanded="false"><div class="tree-branch-header" ids="' . $a . '"  onclick="show_hide_pers(this)"><span class="tree-branch-name"><i class="icon-folder ace-icon tree-'.$sign.'"></i><span class="tree-label"><div style="display: inline-block;padding: 0px;" class="radio"><label style="padding-left:5px"><input  name="permission[' . $a . ']" value="' . $a . '" class="ace" type="checkbox" ' . $chk . ' > ' . $b['title'] . '</div></label></span></span></div><ul id="sub_pers_ul_' . $a . '" class="tree-branch-children" role="group" style="display:' . $display . '">';


                                        foreach ($b['sub_permissions'] as $c => $d) {
                                            $chk1 = '';
                                            if (isset($permission_json_arr[$a]) && is_array($permission_json_arr[$a]) && count($permission_json_arr[$a]) > 0 && in_array($c, $permission_json_arr[$a])) {
                                                $chk1 = 'checked';
                                            }
                                            echo '<li class="tree-item" role="treeitem"><div class="radio" style="padding: 0px;"><label><input name="permission[' . $a . '][]" value="' . $c . '" class="ace" type="checkbox" ' . $chk1 . ' ><span class="lbl"> ' . $d . '</span></label></div></li>';
                                        }
                                        echo '</ul><div class="tree-loader hidden" role="alert"><div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div></div></li>';
                                    }
                                    ?>
                                </ul>

                            </div>
                        </div>


                        <div class="form-group ">
                            <label class="col-sm-3 control-label no-padding-right blue" for="form-field-1"> User status </label>
                            <div class="col-md-9">
                                <div class="radio">
                                    <?php
                                    $status_value = ($this->input->post('status') != '') ? $this->input->post('status') : '1';
                                    foreach ($this->config->config['user_status'] as $k => $v) {
                                        ?>
                                        <label>
                                            <input name="status" value="<?php echo $k; ?>" class="ace" type="radio" <?php echo ($status_value == $k) ? "checked" : ''; ?> >
                                            <span class="lbl"> <?php echo $v['title'] ?></span>
                                        </label>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php echo form_error('status'); ?>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button name = "submit_button" value="submit" class="btn btn-info float-right" type="submit">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Submit
                                </button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>


                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div>
    </div><!-- /.main-content -->
    <?php $this->load->view('admin/footer'); ?>
    <script>
        $(document).ready(function () {
            $('#user_type_id').on('change', function () {
                var user_type_val = $(this).val();
                if (user_type_val == 2) {
                    $('#permissions_div').removeClass('hide');
                } else {
                    $('#permissions_div').addClass('hide');
                }

            });
        });
        function show_hide_pers(obj) {
            var ids = $(obj).attr('ids');
            var par = $(obj).parent();
            var par2 = $(obj).parents("li#li_item_" + ids);
            $("#sub_pers_ul_" + ids).toggle();
        }
        jQuery(function ($) {




        });
    </script>