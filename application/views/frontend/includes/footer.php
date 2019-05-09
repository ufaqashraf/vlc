<?php

if (!isset($footer_block) || empty($footer_block))
    $footer_block = volgo_get_block('footer_block');

foreach ($footer_block as $key => $value) {
    echo $value->code;
}
?>

<!--jqeuery jquery min JS -->
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/jquery.min.js'; ?>"></script>
<!--jqeuery jquery-ui min JS -->
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/jquery-ui.min.js'; ?>"></script>
<!--jqeuery popper min JS -->
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/popper.min.js'; ?>"></script>
<!--jqeuery bootstrap min JS -->
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/bootstrap.min.js'; ?>"></script>
<!--jqeuery bootstrap-select min JS -->
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/bootstrap-select.min.js'; ?>"></script>
<!--jqeuery flex sider JS -->
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/jquery.flexslider.js'; ?>"></script>
<!--jqeuery cookie JS -->
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/cookie.min.js'; ?>"></script>
<!--Number (optional) JS -->
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/TelInput.js'; ?>"></script>
<!--jqeuery msdropdown JS -->
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/jquery.dd.min.js'; ?>"></script>
<!--custom JS -->
<script type="text/javascript" src="<?php echo base_url() . 'assets/js/custom.js'; ?>"></script>

</body>
</html>

<script>

    jQuery(document).ready(function ($) {

        // property listing page advace search js function start

        $("#advnce-ser1").click(function () {
            var icon = $(this).find("i");
            icon.toggleClass("fa-plus-circle fa-minus-circle");
            $(".advanceSection").toggleClass("mainking");
        });

        // property listing page advace search js function end

        $('.child_cats').change(function () {
            let $this = $(this);
            let cat_id = $($this).attr('data-parent_id');

            $(document).find('.dynamic-header-form-wrapper-' + cat_id + ' > #dynamic-header-form').empty();

            $('.dynamic-header-form-wrapper-' + cat_id + ' > .spinner-loader-wrapper').show();

            $.ajax({
                method: "POST",
                url: "<?php echo base_url('home/ajax__get_child_cats_by_parent_id'); ?>",
                data: {parent_id: $($this).val()}
            }).done(function (data) {
                data = $.parseJSON(data);

                if (data.status === 'error') {
                    console.error("unable to get categories");
                    return;
                }


                if (data.length > 0) {

                    //@todo: We need to write logic to entertain more subchilds on homepage header section.
                    console.log(data);
                    console.log('write logic for more childs');

                    $('.dynamic-header-form-wrapper-' + cat_id + ' > .spinner-loader-wrapper').hide();
                } else {
                    // fetch the form

                    $.ajax({
                        method: "POST",
                        url: "<?php echo base_url('home/ajax__header_search_form_by_child_cat_id'); ?>",
                        data: {child_id: $($this).val()}
                    }).done(function (data) {
                        data = $.parseJSON(data);

                        if (data.status === 'error') {
                            console.error("unable to get form");
                            return;
                        }

                        if (data.length > 0) {
                            $('.dynamic-header-form-wrapper-' + cat_id + ' > #dynamic-header-form').html(data[0]['meta_value']);
                        }

                        $('.dynamic-header-form-wrapper-' + cat_id + ' > .spinner-loader-wrapper').hide();
                    });
                }
            });

        });

        <?php if (!empty($this->session->flashdata('paypal_payment_plan_error'))): ?>
        // Open payment fail model
        $(".popup-overlay, .popup-content").addClass("active");
        $("html, body").animate({scrollTop: 0}, "slow");
        <?php endif; ?>

        <?php if (!empty($this->session->flashdata('paypal_payment_plan_success'))): ?>
        // Open payment success model
        $(".popup-overlay, .popup2").addClass("active");
        $("html, body").animate({scrollTop: 0}, "slow");
        <?php endif; ?>

        // Open subscriber fail model
        <?php if (!empty($this->session->flashdata('subscriber_error'))): ?>
        $(".popup-overlay, .popup-content-subscriber").addClass("active");
        $("html, body").animate({scrollTop: 0}, "slow");
        <?php endif; ?>

        // Open subscriber success model
        <?php if (!empty($this->session->flashdata('subscriber_success'))): ?>
        $(".popup-overlay, .popup3").addClass("active");
        $("html, body").animate({scrollTop: 0}, "slow");
        <?php endif; ?>

        // change the search tab in homepage search
        $('.parent_cat_select').change(function () {
            let target = $(this).find(':selected').attr('data-target_nav');

            $(document).find('a[href="' + target + '"]').click();
        });

        $('#nav-tab').find('a').click(function () {
            $('#searchHolder_single').hide();
        });

        $('.closeTab').click(function () {
            $('#searchHolder_single').show();
        });

        // sign up page telephone field
        if ($("#mobile-number").length > 0)
            $("#mobile-number").intlTelInput();

        // cookie set and update based on user country in the top header.
        $('.topheader_user_country').change(function (e) {
            let $this = $(this);

            $('.top-header-loader').show();

            if ($.cookie('volgo_user_country_id') === undefined) {
                $.cookie(
                    "volgo_user_country_id",
                    $($this).val(),
                    {
                        // The "expires" option defines how many days you want the cookie active. The default value is a session cookie, meaning the cookie will be deleted when the browser window is closed.
                        expires: 2,
                        // The "path" option setting defines where in your site you want the cookie to be active. The default value is the page the cookie was defined on.
                        path: '',
                        // The "domain" option will allow this cookie to be used for a specific domain, including all subdomains (e.g. labs.openviewpartners.com). The default value is the domain of the page where the cookie was created.
                        domain: '',
                        // The "secure" option will make the cookie only be accessible through a secure connection (like https://)
                        secure: false
                    }
                );

            } else {
                $.cookie("volgo_user_country_id", $($this).val());
            }

            $.ajax({
                method: "POST",
                url: "<?php echo base_url('home/ajax__get_states_by_country_id'); ?>",
                data: {country_id: $($this).val()}
            }).done(function (data) {
                data = $.parseJSON(data);

                if (data.status === 'error') {
                    console.error("unable to get states");
                    return;
                }

                $('.top-header-loader').hide();
                location.reload();
            });
        });

        /* --- AD POST jQuery --- */
        $('#inputCountry').change(function () {
            let $this = $(this);

            $('.loader-wrapper').show();

            $.ajax({
                method: "POST",
                url: "<?php echo base_url('users/ajax__get_states_by_country_id'); ?>",
                data: {country_id: $($this).val()}
            }).done(function (data) {
                data = $.parseJSON(data);

                let html = "<option>Choose State</option>";

                $(data).each(function (i, e) {
                    html += "<option value='" + e.id + "' >" + e.name + "</option>";
                });

                $('#inputState').empty().append(html);
                $('.loader-wrapper').hide();
            });
        });


        /* --- AD POST jQuery --- */
        $('.counrty_selec').change(function () {
            let $this = $(this);

            $('.loader-wrapper').show();

            $.ajax({
                method: "POST",
                url: "<?php echo base_url('users/ajax__get_states_by_country_id'); ?>",
                data: {country_id: $($this).val()}
            }).done(function (data) {
                data = $.parseJSON(data);

                let html = "<option>Choose State</option>";

                $(data).each(function (i, e) {
                    html += "<option value='" + e.id + "' >" + e.name + "</option>";
                });

                $('.state_selected').empty().append(html);
                $('.loader-wrapper').hide();
            });
        });


        $('#inputState').change(function () {
            let $this = $(this);

            $('.loader-wrapper').show();

            $.ajax({
                method: "POST",
                url: "<?php echo base_url('users/ajax__get_cities_by_state_id'); ?>",
                data: {state_id: $($this).val()}
            }).done(function (data) {
                data = $.parseJSON(data);

                let html = "<option>Choose City</option>";

                $(data).each(function (i, e) {
                    html += "<option value='" + e.id + "' >" + e.name + "</option>";
                });

                $('#inputCity').attr('disabled', false).empty().append(html);
                $('.loader-wrapper').hide();
            });
        });

        $('.state_selected').change(function () {
            let $this = $(this);

            $('.loader-wrapper').show();

            $.ajax({
                method: "POST",
                url: "<?php echo base_url('users/ajax__get_cities_by_state_id'); ?>",
                data: {state_id: $($this).val()}
            }).done(function (data) {
                data = $.parseJSON(data);

                let html = "<option>Choose City</option>";

                $(data).each(function (i, e) {
                    html += "<option value='" + e.id + "' >" + e.name + "</option>";
                });

                $('.city_selected').attr('disabled', false).empty().append(html);
                $('.loader-wrapper').hide();
            });
        });

        $('#inputCategory').change(function () {
            let $this = $(this);

            $('.loader-wrapper').show();

            $.ajax({
                method: "POST",
                url: "<?php echo base_url('users/ajax__get_sub_cats_by_category_id'); ?>",
                data: {cat_id: $($this).val()}
            }).done(function (data) {
                data = $.parseJSON(data);

                let html = "<option>Choose Subcategory</option>";

                $(data).each(function (i, e) {
                    html += "<option value='" + e.id + "' >" + e.name + "</option>";
                });

                $('#inputSubcategory').attr('disabled', false).empty().append(html);
                $('.loader-wrapper').hide();
            });
        });


        $('#inputSubcategory').change(function () {
            let $this = $(this);

            $('.loader-wrapper').show();
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('users/ajax__get_form_by_sub_cat'); ?>",
                data: {sub_cat_id: $($this).val(), country_id: $('#inputCountry').val() }
            }).done(function (data) {
                data = $.parseJSON(data);

                $('.integrate-form-data').empty().append(data);
                $('.loader-wrapper').hide();

                $('#currency_code').remove();
                //$('#currency_code option[value="<?php //echo volgo_get_current_currency_code(); ?>"]').attr('selected', 'selected');
                //console.log('<?php //echo volgo_get_current_currency_code(); ?>');

            });
        });
    });

    (function () {
        'use strict';
        window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////// bellow ajax calls ////////////////////////////////////////////////////////////////////


    /////////////////////////////////////////////////////////////////////
    // for state /////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////

    $(".country_select_child").change(function () { /* WHEN YOU CHANGE AND SELECT FROM THE SELECT FIELD */
		$('.search-loader').show();
        $(".state_selected").empty();
        var dataString = $(this).val(); /* GET THE VALUE OF THE SELECTED DATA */
        $.ajax({/* THEN THE AJAX CALL */
            type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
            dataType: "json",
            url: "<?php echo base_url('listing/get_state_ajax'); ?>", /* PAGE WHERE WE WILL PASS THE DATA */
            data: {country_id: dataString}, /* THE DATA WE WILL BE PASSING */
            success: function (result) { /* GET THE TO BE RETURNED DATA */
                $(".state_selected").append("<option value=''>Select State</option>");
                $.each(result, function (index) {

                    //alert(result[index].name);
                    $(".state_selected").append("<option value=" + JSON.stringify(result[index].id).replace(/^"(. * )"$/, '$1') + ">" + JSON.stringify(result[index].name).replace(/^"(.*)"$/, '$1') + "</option>");

                });
				$('.search-loader').hide();

            },
            error: function (request, status, error) {

                var val = request.responseText;
                console.log("error" + val);

				$('.search-loader').hide();
            }

        });

    });


    /////////////////////////////////////////////////////////////////////
    // for city /////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////

    $("#state_selected").change(function () { /* WHEN YOU CHANGE AND SELECT FROM THE SELECT FIELD */

		$('.search-loader').show();

        $("#city_selection").empty();
        var state_select = $(this).val(); /* GET THE VALUE OF THE SELECTED DATA */

        var dataString = state_select; /* STORE THAT TO A DATA STRING */

        $("#city_selection").append("<option value=''>---Select city---</option>");
        $.ajax({/* THEN THE AJAX CALL */
            type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
            dataType: "json",
            url: "<?php echo base_url('listing/get_city_ajax'); ?>", /* PAGE WHERE WE WILL PASS THE DATA */
            data: {state_id: dataString}, /* THE DATA WE WILL BE PASSING */
            success: function (result) { /* GET THE TO BE RETURNED DATA */

                $(".city_container").show();
                $.each(result, function (index) {


                    $("#city_selection").append("<option value=" + JSON.stringify(result[index].id).replace(/^"(. * )"$/, '$1') + ">" + JSON.stringify(result[index].name).replace(/^"(.*)"$/, '$1') + "</option>");
					$('.search-loader').hide();
                });

            }
        });

    });

    /////////////////////////////////////////////////////////////////////
    // for category /////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////

    $(".cat_select_child").change(function () { /* WHEN YOU CHANGE AND SELECT FROM THE SELECT FIELD */
		$('.search-loader').show();

        $(".show_child_cat").empty();
        var cat_select_child = $(this).val(); /* GET THE VALUE OF THE SELECTED DATA */

        var dataString = cat_select_child; /* STORE THAT TO A DATA STRING */

        $(".show_child_cat").append("<option value=''>---Select Sub Category---</option>");
        $.ajax({/* THEN THE AJAX CALL */
            type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
            dataType: "json",
            url: "<?php echo base_url('listing/get_subchild_ajax'); ?>", /* PAGE WHERE WE WILL PASS THE DATA */
            data: {parent_cat_id: dataString}, /* THE DATA WE WILL BE PASSING */
            success: function (result) { /* GET THE TO BE RETURNED DATA */

                $.each(result, function (index) {

                    //alert(result[index].name);
                    $(".show_child_cat").append("<option value=" + JSON.stringify(result[index].id).replace(/^"(. * )"$/, '$1') + ">" + JSON.stringify(result[index].name).replace(/^"(.*)"$/, '$1') + "</option>");

                });

				$('.search-loader').hide();

            }
        });


    });


    /////////////////////////////////////////////////////////////////////
    // for db from retrival /////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////


    $(".show_child_cat").change(function () { /* WHEN YOU CHANGE AND SELECT FROM THE SELECT FIELD */

		$('.search-loader').show();

        $(".made_append").empty();

        $.ajax({/* THEN THE AJAX CALL */
            type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
            dataType: "json",
            url: "<?php echo base_url('listing/get_formdb_ajax'); ?>", /* PAGE WHERE WE WILL PASS THE DATA */
            data: {subcat_id: $(this).val()}, /* THE DATA WE WILL BE PASSING */
            success: function (result) { /* GET THE TO BE RETURNED DATA */

            	if (result.length < 1){
					$('.search-loader').hide();
					return;
				}

                var all_form = result[0];

				// let return_result = JSON.parse(result);
                $(".made_append").append("<div class='htmlforms_appended'>" + all_form.meta_value + "</div>");

				$('.search-loader').hide();
            }
        });
    });


    $(".cat_select_child").change(function () {

        var country_select = $(this).val();


        $(".autoselected1 option").removeAttr('selected');
        $(".autoselected option").removeAttr('selected');


        $(".cat_select_child option[value='" + country_select + "']").prop('selected', 'selected');
        $(".cat_select_child option[value='" + country_select + "']").attr('selected', 'selected');


    });

    $(".show_child_cat").change(function () { /* WHEN YOU CHANGE AND SELECT FROM THE SELECT FIELD */


        var country_select = $(this).val(); /* GET THE VALUE OF THE SELECTED DATA */
        $(".show_child_cat option").removeAttr('selected');

        $(".show_child_cat option[value='" + country_select + "']").prop('selected', 'selected');
        $(".show_child_cat option[value='" + country_select + "']").attr('selected', 'selected');


    });


    $(".show_child_cat").change(function () { /* WHEN YOU CHANGE AND SELECT FROM THE SELECT FIELD */

        $(".made_append2").empty();

        var country_select = $(this).val(); /* GET THE VALUE OF THE SELECTED DATA */


        var dataString = country_select; /* STORE THAT TO A DATA STRING */


        $.ajax({/* THEN THE AJAX CALL */
            type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
            dataType: "json",
            url: "<?php echo base_url('listing/get_formdb_ajax2'); ?>", /* PAGE WHERE WE WILL PASS THE DATA */
            data: {subcat_id: dataString}, /* THE DATA WE WILL BE PASSING */
            success: function (result) { /* GET THE TO BE RETURNED DATA */

            	if (result.length < 1){

					return;
				}


                var all_form = result[0];
                // let return_result = JSON.parse(result);
                $(".made_append2").append("<div class='htmlforms_appended'>" + all_form.meta_value + "</div>");


            }
        });
    });

    function share_this(val) {

        var url = document.getElementById(val).getAttribute("data-url");
        var title = document.getElementById(val).getAttribute("data-title");
        var desc = document.getElementById(val).getAttribute("data-desc");

        var pop_url = '';
        if (val == 'share_fb_item') {
            share_fb_item
            pop_url = 'https://www.facebook.com/sharer/sharer.php?u=' + url;
        }
        if (val == 'share_tw_item') {

            pop_url = 'https://twitter.com/intent/tweet?text=' + title + '&url=' + url;
        }
        if (val == 'share_gp_item') {
            pop_url = 'https://plus.google.com/share?url=' + url;
        }
        if (val == 'share_ln_item') {
            pop_url = 'https://www.linkedin.com/shareArticle?url=' + url;
        }
        if (val == 'share_pt_item') {
            pop_url = 'https://pinterest.com/pin/create/button/?url=' + url;
        }
        window.open(pop_url, "PopupWindow", "width=500,height=500,scrollbars=yes,resizable=no");
    }

    $(".share_fb_item").click(function (e) {
        e.preventDefault();
        var $this = $(this);
        var title = $this.data('title');
        var url = $this.data('url');
        var pop_url = '';
        pop_url = 'https://www.facebook.com/sharer/sharer.php?u=' + url;
        window.open(pop_url, "PopupWindow", "width=500,height=500,scrollbars=yes,resizable=no");
    });
    $(".share_tw_item").click(function (e) {
        e.preventDefault();
        var $this = $(this);
        var url = $this.data('url');
        var title = $this.data('title');
        var pop_url = '';
        pop_url = 'https://twitter.com/intent/tweet?text=' + title + '&url=' + url;
        window.open(pop_url, "PopupWindow", "width=500,height=500,scrollbars=yes,resizable=no");
    });
    $(".share_pt_item").click(function (e) {
        e.preventDefault();
        var $this = $(this);
        var title = $this.data('title');
        var url = $this.data('url');
        var pop_url = '';
        pop_url = 'https://pinterest.com/pin/create/button/?url=' + url;
        window.open(pop_url, "PopupWindow", "width=500,height=500,scrollbars=yes,resizable=no");
    });

    //chat with seller model popup js start
    $("#myModal").modal({
        backdrop: 'static',
        keyboard: true,
        show: false
    });
    //chat with seller model popup js end

    $('.number').click(function () {
        var tel = $(this).data('last');
        $(this).find('span').html('<a href="tel:' + tel + '">' + tel + '</a>');
    });

    let listings_before_search = '';

    $('.ajax-listing-filters').find('input[type="checkbox"]').change(function () {

        let $this = $(this);

        if ($(this).attr('name') === 'price_only') {

            if ($(this).is(':checked')) {

                if ($($this).parent().find('.ajax_loader').length < 1)
                    $($this).parent().append('<i class="ajax_loader fa fa-spinner fa-spin"></i>');

                let path_arr = window.location.pathname.split("/");
                let cat_slug = path_arr[path_arr.length - 1];

                $.ajax({/* THEN THE AJAX CALL */
                    type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
                    url: "<?php echo base_url('users/additional_filters'); ?>", /* PAGE WHERE WE WILL PASS THE DATA */
                    data: {filter_name: ($this).val(), cat_slug: cat_slug}, /* THE DATA WE WILL BE PASSING */
                    success: function (result) { /* GET THE TO BE RETURNED DATA */

                        result = JSON.parse(result);

                        listings_before_search = $('.listings-container').html();
                        $('.listings-container').empty();
                        $('.listings-container').html(result);

                        $($this).parent().find('.ajax_loader').remove();
                    }
                });

            } else {
                $('.listings-container').html(listings_before_search);
            }


        } else if ($(this).attr('name') === 'photo_only') {

            let $this = $(this);

            if ($(this).is(':checked')) {

                if ($($this).parent().find('.ajax_loader').length < 1)
                    $($this).parent().append('<i class="ajax_loader fa fa-spinner fa-spin"></i>');

                let path_arr = window.location.pathname.split("/");
                let cat_slug = path_arr[path_arr.length - 1];


                $.ajax({/* THEN THE AJAX CALL */
                    type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
                    url: "<?php echo base_url('users/additional_filters'); ?>", /* PAGE WHERE WE WILL PASS THE DATA */
                    data: {
                        filter_name: ($this).val(),
                        cat_slug: cat_slug
                    }, /* THE DATA WE WILL BE PASSING */
                    success: function (result) { /* GET THE TO BE RETURNED DATA */

                        result = JSON.parse(result);

                        listings_before_search = $('.listings-container').html();
                        $('.listings-container').empty();
                        $('.listings-container').html(result);

                        $($this).parent().find('.ajax_loader').remove();
                    }
                });

            } else {
                $('.listings-container').html(listings_before_search);
            }

        }
    });

    // add favrouite and remove favrouite on listing and detail pages start
    // add favrouite and remove favrouite on listing and detail pages start
    // add favrouite and remove favrouite on listing and detail pages start

    $(".fav_add_listing").click(function (e) {
        e.preventDefault();

        var $this = $(this);
        $this.find(".fa-spinner").show();

        var listing_id = $this.data('lisitngid'); //getter
        var userid = $this.data("user_id");

        $.ajax({/* THEN THE AJAX CALL */
            type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
            dataType: "json",
            url: "<?php echo base_url('dashboard/fav_add'); ?>", /* PAGE WHERE WE WILL PASS THE DATA */
            data: {listing_id: listing_id, userid: userid}, /* THE DATA WE WILL BE PASSING */

            success: function (result) { /* GET THE TO BE RETURNED DATA */
                console.log(result);

                if (result == 'nolog') {
                    window.location.replace("<?php echo base_url('login?redirected_to=') . base_url() . uri_string(); ?>");
                }
                if (result == 'fav_added') {

                    $this.find(".fa-spinner").hide();


                }


            }
        });
    });

    $(".remove_fav_listing").click(function (e) {
        e.preventDefault();

        var $this = $(this);
        $this.find(".fa-spinner").show();

        var listing_id = $this.data('lisitngid'); //getter
        var userid = $this.data("user_id");

        $.ajax({/* THEN THE AJAX CALL */
            type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
            dataType: "json",
            url: "<?php echo base_url('dashboard/remove_fav'); ?>", /* PAGE WHERE WE WILL PASS THE DATA */
            data: {listing_id: listing_id, userid: userid}, /* THE DATA WE WILL BE PASSING */

            success: function (result) { /* GET THE TO BE RETURNED DATA */
                console.log(result);


                if (result == 'fav_removed') {


                    $this.find(".fa-spinner").hide();
                    $this.siblings().show();
                    $this.hide();

                }


            }
        });
    });

    // add favrouite and remove favrouite on listing and detail pages end

    // listing pages save search js start

    $(".save_search_add").click(function (e) {
        e.preventDefault();

        var $this = $(this);
        $this.find(".fa-spinner").show();

        var listing_id = $this.data('lisitngid'); //getter
        var userid = $this.data("user_id");

        $.ajax({/* THEN THE AJAX CALL */
            type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
            dataType: "json",
            url: "<?php echo base_url('dashboard/search_fav_add'); ?>", /* PAGE WHERE WE WILL PASS THE DATA */
            data: {listing_id: listing_id, userid: userid}, /* THE DATA WE WILL BE PASSING */

            success: function (result) { /* GET THE TO BE RETURNED DATA */
                console.log(result);

                if (result == 'nolog') {
                    window.location.replace("<?php echo base_url('login?redirected_to=') . base_url() . uri_string(); ?>");
                }
                if (result == 'fav_search_added') {

                    $this.find(".fa-spinner").hide();
                    $this.siblings().show();
                    $this.hide();


                }


            }
        });
    });

    $(".remove_save_search_add").click(function (e) {
        e.preventDefault();

        var $this = $(this);
        $this.find(".fa-spinner").show();

            var listing_id = $this.data('lisitngid'); //getter
        var userid = $this.data("user_id");

        $.ajax({/* THEN THE AJAX CALL */
            type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
            dataType: "json",
            url: "<?php echo base_url('dashboard/remove_search_fav_add'); ?>", /* PAGE WHERE WE WILL PASS THE DATA */
            data: {listing_id: listing_id, userid: userid}, /* THE DATA WE WILL BE PASSING */

            success: function (result) { /* GET THE TO BE RETURNED DATA */
                console.log(result);


                if (result == 'fav_save_search_removed') {


                    $this.find(".fa-spinner").hide();
                    $this.siblings().show();
                    $this.hide();

                }


            }
        });
    });

    // listing pages save search js end

    // follow and unfollow in detail pages start

    $(".follow_add_listing").click(function (e) {
        e.preventDefault();

        var $this = $(this);
        $this.find(".fa-spinner").show();

        var listing_id = $this.data('lisitngid'); //getter
        var userid = $this.data("user_id");

        $.ajax({/* THEN THE AJAX CALL */
            type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
            dataType: "json",
            url: "<?php echo base_url('dashboard/follow_add'); ?>", /* PAGE WHERE WE WILL PASS THE DATA */
            data: {listing_id: listing_id, userid: userid}, /* THE DATA WE WILL BE PASSING */

            success: function (result) { /* GET THE TO BE RETURNED DATA */
                console.log(result);

                if (result == 'nolog') {
                    window.location.replace("<?php echo base_url('login?redirected_to=') . base_url() . uri_string(); ?>");
                }
                if (result == 'follow_added') {

                    $this.find(".fa-spinner").hide();
                    $this.siblings().show();
                    $this.hide();

                }


            }
        });
    });

    $(".remove_follow_listing").click(function (e) {
        e.preventDefault();

        var $this = $(this);
        $this.find(".fa-spinner").show();
        var listing_id = $this.data('lisitngid'); //getter
        var userid = $this.data("user_id");

        $.ajax({/* THEN THE AJAX CALL */
            type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
            dataType: "json",
            url: "<?php echo base_url('dashboard/remove_follow'); ?>", /* PAGE WHERE WE WILL PASS THE DATA */
            data: {listing_id: listing_id, userid: userid}, /* THE DATA WE WILL BE PASSING */

            success: function (result) { /* GET THE TO BE RETURNED DATA */
                console.log(result);


                if (result == 'follow_removed') {


                    $this.find(".fa-spinner").hide();
                    $this.siblings().show();
                    $this.hide();

                }


            }
        });
    });

    // follow and unfollow in detail pages end


    if ($("#post-form").length > 0) {
        $("#post-form").submit(function (e) {
            var form = this;
            e.preventDefault(); //Stop the submit for now
            //Replace with your selector to find the file input in your form
            var fileInput = $(this).find("input[type=file]")[0],
                file = fileInput.files && fileInput.files[0];

            if (file) {
                var img = new Image();

                img.src = window.URL.createObjectURL(file);

                img.onload = function () {
                    var width = img.naturalWidth,
                        height = img.naturalHeight;


                    window.URL.revokeObjectURL(img.src);

                    if (width > 300 && height > 300) {
                        form.submit();
                    } else {
                        alert("Image Should Be Greater Than 300 x 300");
                    }
                };
            } else { //No file was input or browser doesn't support client side reading
                form.submit();
            }

        });
    }
    

    // trade show detail page listing detail style start
    if ($("#adListing").length > 0) {
        var totla_listings = document.getElementById("adListing").getElementsByTagName("li").length;
        var listings_all = document.getElementById("adListing").querySelectorAll("li");
        if (totla_listings === 3) {
            listings_all[0].style.width = "31%";
            listings_all[1].style.width = "31%";
            listings_all[2].style.width = "31%";
        } else if (totla_listings === 2) {
            listings_all[0].style.width = "47%";
            listings_all[1].style.width = "47%";
        } else if (totla_listings === 1) {
            listings_all[0].style.width = "100%";
        }
    }
    // trade show detail page listing detail style end

    //browse filters of listing pages js start
    $('.browse-filter i').click(function (e){

        $('.loader-wrapper').css('display', 'block');

        e.preventDefault();
        e.stopImmediatePropagation();

        window.location.href  = $(this).parent().attr('href');
        $(this).parents('li').remove();
        return true;
    });


	// categories value
//  $('.parent_cat_name_').val($('.parent_cat').data('parent'));
 if($('.child_cat').length > 0){
    $('.child_cat_name_').val($('.child_cat').data('parent'));
    $('.child_cat').attr('disabled',false);
 }
 

//  reset search
 $('.reset_search_').on('click',function(e){
	 e.preventDefault();
	 window.location.href= $(this).data('href'); 
 });
// sorting
$('.sorting_select').on('change',function(e){
	e.preventDefault();
	$('.sorting').val($(this).find(":selected").val());
	$('.sorting').attr('disabled',false)
	$('.sorting').closest('form').submit();
});

// Save search button
$(".save_search_").click(function (e) {
    e.preventDefault();
    var search_query = $(this).closest('form').find('input[name="search_query"]');
    var message = $('.msg');
    if(search_query.val() != ''){
        $.ajax({/* THEN THE AJAX CALL */
            type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
            dataType: "json",
            url: "<?php echo base_url('listing/savesearch'); ?>", /* PAGE WHERE WE WILL PASS THE DATA */
            data: {data: $(this).closest('form').serialize() }, /* THE DATA WE WILL BE PASSING */

            success: function (result) { /* GET THE TO BE RETURNED DATA */
                console.log(result);
                if(result.success == true){
                    message.hide().removeClass('error').removeClass('success').addClass('success').text(result.msg).fadeIn('slow').delay(5000).fadeOut('slow');
                }else if(result.success == false && result.redirect == 1){
                    window.location.replace("<?php echo base_url('login?redirected_to=') . base_url() . uri_string(); ?>");
                }else if(result.success == false){
                    message.hide().removeClass('error').removeClass('success').addClass('error').text(result.msg).fadeIn('slow').delay(5000).fadeOut('slow');
                }
            }
        });
    }else{
        search_query.css('border','1px solid red');
        message.hide().removeClass('error').removeClass('success').addClass('error').text('Please fill enter query').fadeIn('slow').delay(5000).fadeOut('slow');
    }
});
// user membership check
$(".show_leads_details").click(function (e) {
    e.preventDefault();
    var that = $(this);
    var message = $('.msg');
    var userid = $(this).data("user_id");
    if (userid == 0) {
        window.location.replace("<?php echo base_url('login?redirected_to=') . base_url() . uri_string(); ?>");
    } else {
        $.ajax({/* THEN THE AJAX CALL */
            type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
            dataType: "json",
            url: "<?php echo base_url('listing/user_membership_check'); ?>", /* PAGE WHERE WE WILL PASS THE DATA */
            data: {user_id: userid }, /* THE DATA WE WILL BE PASSING */

            success: function (result) { /* GET THE TO BE RETURNED DATA */
                if(result.success == true ){
                    $('.leads_block_d .user_details').slideDown();
                    that.hide();
                }else if(result.success == false && result.redirect == 1){
                    window.location.href = "payment-plans";
                }else if(result.success == 3){
                    message.hide().removeClass('error').removeClass('success').addClass('error').text(result.msg).fadeIn('slow').delay(5000).fadeOut('slow');
                }
            }
        });
    }
});


</script>

<script>
    // save search history start

    $(".save_search_history").click(function(e) {

        var $this = $(this);
        var userid = $this.data("user_id");
        $this.find(".fa-spinner").show();
        if (userid == 0) {
            window.location.replace("<?php echo base_url('login?redirected_to=') . base_url() . uri_string(); ?>");
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('dashboard/save_search_history'); ?>",
                success: function (msg) {
//                alert(msg);
                    var obj = JSON.parse(msg);
                    var resultArray = new Array();
                    for (var i in obj)
                        resultArray[i] = obj[i];

                    if (resultArray['insert_id']) {
                        alert('Search saved successfully');
                        $this.find(".fa-spinner").hide();
                        $('.removesrch').removeClass('hide');
                        $('.save_search_history').addClass('hide');
                    }
                }
            })
        }
    });

    //    $(".search-me").click(function() {
    //        $(".saveIt").css("background-color", "#fff");
    //        $(".saveIt").css("color", "#666");
    //        $("#saveSpan").html("");
    //        $("#saveSpan").html("Save");
    ////        $("#saveSpan").removeClass("removesrch");
    ////        $("#save_search_history").removeClass("save_search_history");
    //    });


    $(".removesrch").click(function() {
        var $this = $(this);
        $this.find(".fa-heart-o").hide();
        $this.find(".fa-spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('dashboard/remove_search_history'); ?>",
            success: function (msg) {
                alert('Removed history successfully');
                if (msg == "removed") {
                    $this.find(".fa-spinner").hide();
                    $('.removesrch').addClass('hide');
                    $('.save_search_history').removeClass('hide');
                }

            }
        })

    });


    $(".del_this_one").click(function() {
        var $this = $(this);
        var del_id = $this.data("id_data");
        $("#trash_"  + del_id).show();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('dashboard/delete_dashboard_search'); ?>",
            data: {
                del_id: del_id,
            },
            success: function (msg) {
                alert('Removed history successfully');
                if (msg == "removed") {
                    $('#del_this_one_' + del_id).hide();
                    $("#trash_"  + del_id).hide();
                }
            }
        })


    });
    // end save history



</script>
