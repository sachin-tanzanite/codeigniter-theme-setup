<?php
$step = $this->input->post('step');
?>
<html lang="en"><head>
<meta charset="utf-8">
<title>Setup Your Project</title>
<style type="text/css">

::selection { background-color: #E13300; color: white; }
::-moz-selection { background-color: #E13300; color: white; }

body {
	background-color: #f9f9f9;
	margin: 40px auto;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
        width: 60%;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #444;
	background-color: #f1f1f1;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
	border: 1px solid #D0D0D0;
	box-shadow: 0 0 8px #D0D0D0;
}

p {
	margin: 12px 15px 12px 15px;
}
table {
    margin: 12px 15px 12px 15px;
    font-size: 14px;
    border: solid 0px;
    display: block;
    
}
table td {
    padding: 15px 5px;
    border: solid 0px;
}
.td_head {
    width: 24%;
    text-align: right;
    font-weight: normal;
}
.input-box {
    padding: 5px;
    border: none;
    width: 280px;
    border: solid 1px #f9f9f9;
    border-bottom: solid 1px #d6d6d6;
    background: #f9f9f9;
    outline: none;
}
.input-box:focus {
    border-bottom: solid 1px #ff0000;
}
.info {
    color: #999;
    text-transform:lowercase;
    font-style: italic;
    display: inline-block;
    padding: 5px 10px;
    font-family: Consolas, Monaco, Courier New, Courier, monospace;
    font-size: 12px;
}
h1 .info {
    font: 17px normal Helvetica, Arial, sans-serif;
    text-transform: capitalize;
    padding: 5px 0px;
    color: #ccc;
}
.info.arrow {
    color: #c9c9c9;
}
.info.completed {
    color: #cc0000;
}
.info.active {
    color: #444;
}
td.tr_head {
    background: #eaeaea;
    text-transform: uppercase;
    font-weight: bold;
    font-size: 12px;
}
input.input-btn {
    background: #e84f4f;
    border: solid 1px #920000;
    padding: 5px;
    color: #fff;
    outline: none;
}
input.input-btn.input-btn-reset {
    background: #ccc;
    border-color: #999;
    color: #555;
}
</style>
</head>
<body>
	<div id="container">
            <h1>
                Setup Your Project :: 
                <span class="info <?php echo ($step == '1') ? "active" : (($step > '1') ? "completed" : "");?>">Site Details</span> 
                <span class="info arrow">&raquo;</span> 
                <span class="info <?php echo ($step == '2') ? "active" : (($step > '2') ? "completed" : "");?>">Database Configuration</span> 
                <span class="info arrow">&raquo;</span> 
                <span class="info <?php echo ($step == '3') ? "active" : (($step > '3') ? "completed" : "");?>">Add Admin Details</span> 
                <span class="info arrow">&raquo;</span> 
                <span class="info <?php echo ($step == '4') ? "active" : (($step > '4') ? "completed" : "");?>">Finialize</span>
            </h1>
            <p>Please specify below the configuration details.</p>
            <div>
                <form method="post" name="configform" action="" autocomplete="off">
                    <input type="hidden" name="step" value="<?php echo $step?>" />
                    <table>
                        <?php if($step == '1' || $step == '4') {?>
                        <tr>
                            <td class="td_head">SITE NAME</td>
                            <td><input type="text" placeholder="Enter Site Name Here..." name="site_name" class="input-box" value="<?php echo $this->input->post('site_name');?>" /> <span class="info">this should be your project name</span></td>
                        </tr>
                        <tr>
                            <td class="td_head">SITE URL</td>
                            <td><input type="text" placeholder="Enter Site Url Here..." name="site_url" class="input-box" value="<?php echo $this->input->post('site_url');?>" /> <span class="info">this should be your project url</span></td>
                        </tr>
                        <tr>
                            <td class="td_head">ROOT PATH</td>
                            <td><input type="text" placeholder="Enter Root Path Here..." name="root_path" class="input-box" value="<?php echo $this->input->post('root_path');?>" /> <span class="info">this should be your base folder path</span></td>
                        </tr>
                        <?php }
                        if($step == '2' || $step == '4') {?>
                        <tr>
                            <td class="td_head">DATABASE HOST</td>
                            <td><input type="text" placeholder="Enter Database Host Here..." name="database_host" class="input-box" value="<?php echo $this->input->post('database_host');?>" /> <span class="info">this should be your database host</span></td>
                        </tr>
                        <tr>
                            <td class="td_head">DATABASE NAME</td>
                            <td><input type="text" placeholder="Enter Database Name Here..." name="database_name" class="input-box" value="<?php echo $this->input->post('database_name');?>" /> <span class="info">this should be your database name</span></td>
                        </tr>
                        <tr>
                            <td class="td_head">DATABASE USER</td>
                            <td><input type="text" placeholder="Enter Database User Name Here..." name="database_user" class="input-box" value="<?php echo $this->input->post('database_user');?>" /> <span class="info">this should be your database user name</span></td>
                        </tr>
                        <tr>
                            <td class="td_head">DATABASE PASSWORD</td>
                            <td><input type="password" placeholder="Enter Database Password Here..." name="database_password" class="input-box" value="<?php echo $this->input->post('database_password');?>" /> <span class="info">this should be your database password</span></td>
                        </tr>
                        <?php }
                        if($step == '3' || $step == '4') {
                            if($step == '4') {?>
                        
                            <?php }?>
                        <tr>
                            <td class="td_head">ADMIN USER EMAIL</td>
                            <td><input type="text" placeholder="Enter Admin User Email..." name="admin_user" class="input-box" value="<?php echo $this->input->post('admin_user');?>" /> <span class="info">this should be your admin user name</span></td>
                        </tr>
                        <tr>
                            <td class="td_head">ADMIN PASSWORD</td>
                            <td><input type="password" placeholder="Enter Admin Password Here..." name="admin_password" class="input-box" value="<?php echo $this->input->post('admin_password');?>" /> <span class="info">this should be your admin password</span></td>
                        </tr>
                        <?php }
                        if($step == '4') {?>
                        <tr>
                            <td class="tr_head" colspan="2">Site Details</td>
                        </tr>
                        <tr>
                            <td class="td_head">SITE NAME</td>
                            <td><input type="text" placeholder="Enter Site Name Here..." name="site_name" class="input-box" value="<?php echo $this->input->post('site_name');?>" /> <span class="info">this should be your project name</span></td>
                        </tr>
                        <tr>
                            <td class="td_head">SITE URL</td>
                            <td><input type="text" placeholder="Enter Site Url Here..." name="site_url" class="input-box" value="<?php echo $this->input->post('site_url');?>" /> <span class="info">this should be your project url</span></td>
                        </tr>
                        <tr>
                            <td class="td_head">ROOT PATH</td>
                            <td><input type="text" placeholder="Enter Root Path Here..." name="root_path" class="input-box" value="<?php echo $this->input->post('root_path');?>" /> <span class="info">this should be your base folder path</span></td>
                        </tr>
                        <tr>
                            <td class="tr_head" colspan="2">Database Configuration</td>
                        </tr>
                        <tr>
                            <td class="td_head">DATABASE HOST</td>
                            <td><input type="text" placeholder="Enter Database Host Here..." name="database_host" class="input-box" value="<?php echo $this->input->post('database_host');?>" /> <span class="info">this should be your database host</span></td>
                        </tr>
                        <tr>
                            <td class="td_head">DATABASE NAME</td>
                            <td><input type="text" placeholder="Enter Database Name Here..." name="database_name" class="input-box" value="<?php echo $this->input->post('database_name');?>" /> <span class="info">this should be your database name</span></td>
                        </tr>
                        <tr>
                            <td class="td_head">DATABASE USER</td>
                            <td><input type="text" placeholder="Enter Database User Name Here..." name="database_user" class="input-box" value="<?php echo $this->input->post('database_user');?>" /> <span class="info">this should be your database user name</span></td>
                        </tr>
                        <tr>
                            <td class="td_head">DATABASE PASSWORD</td>
                            <td><input type="password" placeholder="Enter Database Password Here..." name="database_password" class="input-box" value="<?php echo $this->input->post('database_password');?>" /> <span class="info">this should be your database password</span></td>
                        </tr>
                        <tr>
                            <td class="tr_head" colspan="2">Add Admin Details</td>
                        </tr>
                        <tr>
                            <td class="td_head">ADMIN USER EMAIL</td>
                            <td><input type="text" placeholder="Enter Admin User Email..." name="admin_user" class="input-box" value="<?php echo $this->input->post('admin_user');?>" /> <span class="info">this should be your admin user name</span></td>
                        </tr>
                        <tr>
                            <td class="td_head">ADMIN PASSWORD</td>
                            <td><input type="password" placeholder="Enter Admin Password Here..." name="admin_password" class="input-box" value="<?php echo $this->input->post('admin_password');?>" /> <span class="info">this should be your admin password</span></td>
                        </tr>
                        
                        <?php }?>
                        <tr>
                            <td class="td_head"></td>
                            <td>
                                <?php if($step > '1'){?>
                                <input type="submit" name="back_step" class="input-btn input-btn-reset" value="<?php echo "Back to Step ".($step-1)."!"?>" />
                                <?php }?>
                                <input type="submit" name="submit_details" class="input-btn" value="<?php echo ($step == '4') ? "All Done, Create My Site!" : "Continue to Step ".($step+1)."!"?>" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>

</body></html>