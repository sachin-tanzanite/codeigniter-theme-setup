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

                    <li>
                        <a href="<?php echo base_url(); ?>admin/users">Users</a>
                    </li>
                    <li class="active">Change Password</li>
                </ul><!-- /.breadcrumb -->


            </div>

            <div class="page-content">
                <div class="page-header">
                    <h1>
                        Change Password


                    </h1>
                </div><!-- /.page-header -->

                <div class="row">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->
                        <?php
                        echo get_error_message();
                        echo get_success_message();
                        echo form_open('admin/users/change_password', 'class="form-horizontal"');
                        $full_name = (isset($admin_data['full_name']) && $admin_data['full_name'] != '') ? $admin_data['full_name'] : '';
                        ?>
                        <div class="form-group" style="display: none">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Full name </label>

                            <div class="col-sm-9">
                                <input type="text" id="form-field-1" placeholder="Full name" name="full_name" class="col-xs-10 col-sm-5" value="<?php echo $full_name; ?>" />
                                <?php echo form_error('full_name'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Current Password </label>

                            <div class="col-sm-9">
                                <input type="password" id="form-field-1" placeholder="Current Password" name="current_password" class="col-xs-10 col-sm-5" />
                                <?php echo form_error('current_password'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">New Password </label>

                            <div class="col-sm-9">
                                <input type="password" id="form-field-1"  placeholder="New Password" name="new_password"  class="col-xs-10 col-sm-5" />
                                <?php echo form_error('new_password'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Confirm Password </label>

                            <div class="col-sm-9">
                                <input type="password" id="form-field-1"  placeholder="Confirm Password" name="confirm_password"  class="col-xs-10 col-sm-5" />
                                <?php echo form_error('confirm_password'); ?>
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