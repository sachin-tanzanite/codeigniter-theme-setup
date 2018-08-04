<?php $this->load->view('admin/header'); ?>
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
                    <?php
                    ?>
                    <li>
                        <a href="<?php echo base_url(); ?>admin/users">Users</a>
                    </li>
                    <?php
                    if ($user != '') {
                        $url = base_url() . 'admin/users/edit_user/' . $user['id'];

                        $username = ($user['username'] != '') ? '<li><a href="' . $url . '">' . $user['username'] . '</a></li>' : '';
                        echo $username;
                    }
                    ?>
                    <li class="active">Change password</li>
                </ul><!-- /.breadcrumb -->


            </div>

            <div class="page-content">
                <div class="page-header">
                    <h1>
                        Change Password

                        <small>
                            <i class="ace-icon fa fa-angle-double-right"></i>

                        </small>
                    </h1>
                </div><!-- /.page-header -->

                <div class="row">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->
                        <?php
                        echo get_error_message();
                        echo get_success_message();
                        echo form_open('admin/users/user_change_password' . ($this->input->post('id') > 0 ? '/' . $this->input->post('id') : ''), 'class="form-horizontal"');
                        ?>
                        <input type="hidden" name="id" value="<?php echo $this->input->post('id'); ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Username </label>

                            <div class="col-sm-9">
                                <span class="col-xs-10 col-sm-5" style="font-size: 14px; padding-top: 1%;font-weight: bold;color: #999;"> <?php echo ($user['username'] != '') ? $user['username'] : ''; ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">New Password </label>

                            <div class="col-sm-9">
                                <input type="password" id="form-field-1"  placeholder="New Password" name="new_password"  class="col-xs-10 col-sm-5" />
                                <span style="color: red;"><?php echo form_error('new_password'); ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Confirm Password </label>

                            <div class="col-sm-9">
                                <input type="password" id="form-field-1"  placeholder="Confirm Password" name="confirm_password"  class="col-xs-10 col-sm-5" />
                                <span style="color: red;"><?php echo form_error('confirm_password'); ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <button name ="submit_button" value="submit" class="btn btn-info float-right" type="submit">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Update
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
<?php $this->load->view('admin/footer'); ?>

<script type="text/javascript">

</script>
