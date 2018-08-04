

<div class="footer">
    <div class="footer-inner">
        <div class="footer-content">

        </div>
    </div>
</div>

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
    <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
</a>
</div><!-- /.main-container -->
<?php
$page_url = base_url();
if(isset($this->uri->segments) && is_array($this->uri->segments) && count($this->uri->segments) > 0) {
    $tmp = array();
    foreach($this->uri->segments as $a) {
        if(!is_numeric($a)) {
            $tmp[] = $a;
        }
    }
    if(count($tmp) > 0) {
        $page_url = $page_url. implode("/", $tmp);
    }
}
?>

<script src="<?php echo base_url(); ?>assets/admin/js/bootstrap.min.js"></script>

<!-- page specific plugin scripts -->

<!--[if lte IE 8]>
  <script src="assets/js/excanvas.min.js"></script>
<![endif]-->
<script src="<?php echo base_url(); ?>assets/admin/js/jquery-ui.custom.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.ui.touch-punch.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/chosen.jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.easypiechart.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.sparkline.index.min.js"></script>
<!--<script src="<?php echo base_url(); ?>assets/admin/js/jquery.flot.min.js"></script>-->
<!--        <script src="<?php echo base_url(); ?>assets/admin/js/jquery.flot.pie.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.flot.resize.min.js"></script>-->

<!-- ace scripts -->
<script src="<?php echo base_url(); ?>assets/admin/js/ace-elements.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/ace.min.js"></script>
<!--<script src="<?php echo base_url(); ?>assets/admin/js/bootstrap-datepicker.min.js"></script>-->

<script src="<?php echo base_url(); ?>assets/admin/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/bootstrap-datetimepicker.min.js"></script>
 <script src="<?php echo base_url(); ?>assets/admin/js/bootstrap-datepicker.min.js"></script>

<script src="<?php echo base_url(); ?>assets/admin/js/bootstrap-editable.min.js"></script>

<script src="<?php echo base_url(); ?>assets/admin/js/ace-editable.min.js"></script>
 <script src="<?php echo base_url(); ?>assets/admin/js/wizard.min.js"></script>

<!-- inline scripts related to this page -->
<script type="text/javascript">
    
    function set_active_class_on_menu() {
        var url = "<?php echo $page_url?>"; 
        $(".nav-list li").removeClass("active").removeClass("open");
        $(".submenu li a",".nav-list").each(function(index, element){
            var href = $(this).attr('href');
            var par = $(this).parent();
            var par_li = $(par).parents('li');
            
            if(href == url) {
                $(par_li).addClass('active').addClass('open');
                $(par).addClass('active');
                return false;
            }
        });
    }
    
    function delete_circle_row(obj) {
        var row_id = $(obj).attr('row_id');
        $('#' + row_id).remove();
    }
    function initDateTimePicker(cname) {
        $('.' + cname).datetimepicker({
            //format: 'MM/DD/YYYY h:mm:ss A',//use this option to display seconds
            icons: {
                time: 'fa fa-clock-o',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-arrows ',
                clear: 'fa fa-trash',
                close: 'fa fa-times'
            }
        }).next().on(ace.click_event, function () {
            $(this).prev().focus();
        });
    }
    function initDatePicker(cname) {
        var fname = $('.' + cname).attr('dateformat');
        fname = fname!=''?fname:'yyyy-mm-dd';
        $('.' + cname).datepicker({
            format: fname
            
        });
    }

    jQuery(function ($) {
        set_active_class_on_menu();
        $('#add_rows').on('click', function () {

//            var html = $(this).closest('table').find('tr:last').prev('tr').html();
            var rand = Math.round(Math.random() * 100000);
            var d_class = 'date-timepicker-' + rand;
            var tr_class = 'tr-row-' + rand;
            var html = $('.extra_tr').html();
            html = html.replace(/##datepicker##/g, d_class);
            html = html.replace(/##trid##/g, tr_class);
            $('#add_user_table').append(html);
            $('td.custtd', '#add_user_table').each(function (index, element) {
                if ($('.select2-container', element).length > 1) {
                    $('.select2-container', element).each(function (ind, ele) {
                        if (ind > 0) {
                            $(ele).remove();
                        }
                    });
                }
            });

            initDateTimePicker(d_class);
        });


        if (!ace.vars['old_ie'])
            initDateTimePicker('date-timepicker');
        
        if (!ace.vars['old_ie'])
            initDatePicker('date-picker');

        $('#id-disable-check').on('click', function () {
            var inp = $('#form-input-readonly').get(0);
            if (inp.hasAttribute('disabled')) {
                inp.setAttribute('readonly', 'true');
                inp.removeAttribute('disabled');
                inp.value = "This text field is readonly!";
            } else {
                inp.setAttribute('disabled', 'disabled');
                inp.removeAttribute('readonly');
                inp.value = "This text field is disabled!";
            }
        });
        if (!ace.vars['touch']) {
            $('.chosen-select').chosen({allow_single_deselect: true});
            //resize the chosen on window resize
        }
        $('[data-rel=tooltip]').tooltip({container: 'body'});
        $('[data-rel=popover]').popover({container: 'body'});

    });
    function check_uncheck_checkboxes(obj) {
        var is_all = $(obj).attr('all');
        var active_class = 'active';
        var hidden_obj = $('#checked_ids');
        var arr = [];

        if (obj.checked) {
            if (is_all == '1') {
                $(".reserved").prop('checked', true);

            } else {
                // do nothing
            }
        } else {
            if (is_all == '1') {
                $(".reserved:checked").prop('checked', false).removeAttr('checked');
            } else {
                $(obj).attr('checked', false).removeAttr('checked');
            }
        }
        $(".reserved:checked").each(function (index, element) {
            arr.push($(element).val());
        });
        $(hidden_obj).val(arr);
        var checked_ids = $(hidden_obj).val();
        
        // change box type
        var len_chk = $(".reserved:checked").length;
        if(len_chk > 0) {
            $("#_filter_row").hide();
            $("#_checkbox_row").show();
        } else {
            $("#_checkbox_row").hide();
            $("#_filter_row").show();
        }
        
        if (checked_ids != '') {
            return checked_ids;
        }

    }
    function  validate(a) {
        if ($(".reserved:checked").length > 0) {
            if ($('.select_action').val() == '') {
                alert('Please select action');
                return false;
            } else {
                return true;
            }
        } else {
            alert('Please select atleast one reserved username');
            return false;
        }
    }



</script>

<div class="modal fade" id="myModal" style='display: none;'>
    <div class="modal-dialog">
        <div class="modal-content modal-lg ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title"> Details</h3>
            </div>
            <div class="modal-body" style="padding: unset;"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                <!--<button type="button" class="btn btn-primary">Save Changes</button>-->
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>
</html>
