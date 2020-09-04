</div>
<!--mainpanel dic Ends-->
</section>

<?php echo add_js(array('jquery-migrate-1.2.1.min', 'jquery-ui-1.10.3.min', 'bootstrap.min', 'modernizr.min', 'jquery.sparkline.min', 'toggles.min', 'retina.min', 'jquery.cookies', 'jquery.autogrow-textarea', 'bootstrap-fileupload.min', 'bootstrap-timepicker.min', 'jquery.maskedinput.min', 'jquery.tagsinput.min', 'jquery.mousewheel', 'chosen.jquery.min', 'dropzone.min', 'colorpicker', 'screenfull', 'custom', 'jquery.blockUI', 'ddaccordion', 'common', 'jquery.datatables.min', 'jquery.slugify','jquery.placeholder')); ?>

<script>
    $(function() {
        $('input, textarea').placeholder();
    });
    jQuery(document).ready(function() {

        // Chosen Select
        jQuery(".chosen-select").chosen({'width': '100%', 'white-space': 'nowrap', disable_search_threshold: 10});

        // Tags Input
        jQuery('#tags').tagsInput({width: 'auto'});

        // Textarea Autogrow
        jQuery('#autoResizeTA').autogrow();

        // Color Picker
        if (jQuery('#colorpicker').length > 0) {
            jQuery('#colorSelector').ColorPicker({
                onShow: function(colpkr) {
                    jQuery(colpkr).fadeIn(500);
                    return false;
                },
                onHide: function(colpkr) {
                    jQuery(colpkr).fadeOut(500);
                    return false;
                },
                onChange: function(hsb, hex, rgb) {
                    jQuery('#colorSelector span').css('backgroundColor', '#' + hex);
                    jQuery('#colorpicker').val('#' + hex);
                }
            });
        }

        // Color Picker Flat Mode
        jQuery('#colorpickerholder').ColorPicker({
            flat: true,
            onChange: function(hsb, hex, rgb) {
                jQuery('#colorpicker3').val('#' + hex);
            }
        });

        // Date Picker
        jQuery('#datepicker').datepicker();

        jQuery('#datepicker-inline').datepicker();

        jQuery('#datepicker-multiple').datepicker({
            numberOfMonths: 3,
            showButtonPanel: true
        });

        // Spinner
        var spinner = jQuery('#spinner').spinner();
        spinner.spinner('value', 0);

        // Input Masks
        jQuery("#date").mask("99/99/9999");
        jQuery("#phone").mask("(999) 999-9999");
        jQuery("#ssn").mask("999-99-9999");

        // Time Picker
        jQuery('#timepicker').timepicker({defaultTIme: false});
        jQuery('#timepicker2').timepicker({showMeridian: false});
        jQuery('#timepicker3').timepicker({minuteStep: 15});


    });
</script>

<script>
    $(document).ready(function() {
        $("ul.menu li ul li.active").parent().parent().addClass('active');
        // $(".nav-parent.active").children().children().addClass('fa-folder-open');
        $(".nav-parent.active  > a > i").removeClass('fa fa-folder');
        $(".nav-parent.active  > a > i").addClass('fa fa-folder-open');
    });



</script>

</body>
</html>

