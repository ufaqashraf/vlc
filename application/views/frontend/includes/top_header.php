<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php

	$last = $this->uri->total_segments();
	$record_num = $this->uri->segment($last);
	$type = $this->uri->segment(1);

	$slug_data=get_slug($record_num);
	if(!empty($slug_data)):
	?>
	<?php if(!empty($slug_data->seo_description)): ?>
    <meta name="description" content="<?php echo $slug_data->seo_description;?>">
	<?php endif; if(!empty($slug_data->firstname)): ?>
    <meta name="author" content="<?php echo $slug_data->firstname.' '.$slug_data->lastname;?>">
		<?php endif; if(!empty($slug_data->seo_keywords)):  ?>
    <meta name="keywords" content="<?php echo $slug_data->seo_keywords;?>">
	<?php endif; endif;
	$slug_dataa=get_slug_post($record_num);
	if(!empty($slug_dataa)):
	?>
	<?php if(!empty($slug_dataa->seo_description)): ?>
	<meta name="description" content="<?php echo $slug_dataa->seo_description;?>">
	<?php endif; if(!empty($slug_dataa->firstname)): ?>
	<meta name="author" content="<?php echo $slug_dataa->firstname.' '.$slug_dataa->lastname;?>">
	<?php endif; if(!empty($slug_dataa->seo_title)): ?>
		<meta name="DC.title" content="<?php echo $slug_dataa->seo_title;?>">
	<?php endif; endif; ?>
    <title><?php echo SITE_NAME; ?></title>

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700">
	<!-- Jquery UI CSS -->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/css/jquery-ui.css'; ?>">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/css/bootstrap.min.css'; ?>">
	<!-- FontAwsome CSS -->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/css/font-awesome.css'; ?>">
	<!-- Bootstrap Select CSS -->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/css/bootstrap-select.min.css'; ?>">
    <!--msdropdown styles-->
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/css/dd.css'; ?>" />
    <!--All styles-->
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/css/style.css'; ?>">
    <!--Responsive styles-->
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/css/responsive.css'; ?>">
	<!-- PHP Team Styles-->
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/css/php-team.css'; ?>">

<style>
	.remove_fav_listing {
		background: #d3001a;
		color: #fff !important;
	}

</style>
</head>
<body>
<header>
    <div class="header-holder desktopHideOnMobile">
        <div class="container-fluid mainWrapper">
            <div class="row">
                <div class="col-md-4 responsiveOrder-2">
                    <ul class="list-unstyled socialIcons">
                        <?php if (!empty(B2B_FACEBOOK)): ?>
                            <li>
                                <a href=" <?php echo B2B_FACEBOOK; ?>" target="_blank">
                                    <i aria-hidden="true" class="fa fa-facebook"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (!empty(B2B_TWITTER)): ?>
                            <li>
                                <a href="<?php echo B2B_TWITTER; ?>" target="_blank">
                                    <i aria-hidden="true" class="fa fa-twitter"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (!empty(B2B_GOOGLE_PLUS)): ?>
                            <li>
                                <a href="<?php echo B2B_GOOGLE_PLUS; ?>" target="_blank">
                                    <i aria-hidden="true" class="fa fa-google-plus"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (!empty(B2B_INSTAGRAM)): ?>
                            <li>
                                <a href="<?php echo B2B_INSTAGRAM; ?>" target="_blank">
                                    <i aria-hidden="true" class="fa fa-instagram"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (!empty(B2B_PINTEREST)): ?>
                            <li>
                                <a href="<?php echo B2B_PINTEREST; ?>" target="_blank">
                                    <i aria-hidden="true" class="fa fa-pinterest"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (!empty(B2B_YOUTUBE)): ?>
                            <li>
                                <a href="<?php echo B2B_YOUTUBE; ?>" target="_blank">
                                    <i aria-hidden="true" class="fa fa-youtube"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="col-md-8 responsiveOrder-1">
                    <div class="d-flex responsive-country justify-content-end">
                        <div class="languangeSelect">
                            <i class="fa fa-language" aria-hidden="true"></i>
                            <select class="form-control selectpicker selectClassic">
                                <option value="">Select Languange</option>
                                <option value="">English</option>
                                <option value="">Arabic</option>
                                <option value="">Russian</option>
                                <option value="">Chines</option>
                            </select>
                        </div>
                        
                        

                        <div class="countrySelect">

                        
                            <i class="fa fa-globe" aria-hidden="true"></i>


                            <select name="topheader_user_country" id="topheader_user_country" class="topheader_user_country form-control selectClassic">
                                <?php foreach ((array)volgo_get_countries() as $country): ?>
									<option <?php echo ( intval(((volgo_get_user_location())['country_id'])) === intval($country->id) ) ? 'selected="selected"' : ''; ?> value="<?php echo $country->id; ?>"><?php echo ucwords($country->name); ?></option>
								<?php endforeach; ?>
                            </select>




							<div class="top-header-loader" style="display: none;">
								<span class="spinner-loader fa fa-spinner fa-spin" style="left: 95px; top: 6px;"></span>
							</div>
                        </div>



                        <?php if (volgo_front_is_logged_in()): ?>
                        <a href="<?php echo base_url('users/logout'); ?>" class="btn btn-login-signup">
                            <i class="fa fa-key" aria-hidden="true"></i>
                            Logout</a>
                        <?php else: ?>
                            <a href="<?php echo base_url() . 'login'; ?>" class="btn btn-login-signup">
                                <i class="fa fa-key" aria-hidden="true"></i>
                                LogIn or SignUp </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
