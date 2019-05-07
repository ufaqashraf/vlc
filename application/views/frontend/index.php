<?php include_once realpath(__DIR__) . '/includes/top_header.php'; ?>
<?php include_once realpath(__DIR__) . '/includes/header.php'; ?>

<style>
    .spinner-loader-wrapper {
        position: relative;
        min-height: 10px;
        text-align: center;
        display: none;
    }

    .dynamic-form-wrapper .spinner-loader {
        color: white;
        position: absolute;
        margin: 0 auto;
        text-align: center;
    }
</style>

<section class="main-section">
    <div class="container-fluid containerBanner mainWrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="bannerHolder">
                    <img src="<?php echo base_url('uploads/general/banner.jpg'); ?>" alt="Classified Banner"
                         class="img-fluid">
                    <?php if (isset($main_categories)): ?>
                        <div class="bannerInner">
                            <div class="tabsHolder">
                                <label class="searchIn">Search in:</label>
                                <nav>
                                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">

                                        <?php foreach ($main_categories as $main_category): ?>

                                            <a class="nav-item nav-link" data-toggle="tab"
                                               href="#nav-<?php echo volgo_make_slug(strtolower($main_category['parent']->name)); ?>"
                                               aria-controls="nav-auto">
                                                <i class="<?php echo $main_category['parent']->image_icon; ?>"
                                                   aria-hidden="true"></i><?php echo ucwords($main_category['parent']->name); ?>
                                            </a>

                                        <?php endforeach; ?>

                                    </div>
                                </nav>
                                <form action="<?php echo base_url('listing/search'); ?>" method="get">
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="searchHolder" id="searchHolder_single">
                                            <div class="form-group searchField">
                                                <input type="text" name="search_query" class="form-control"
                                                       placeholder="What you are looking for ?">
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-search">Submit</button>
                                        </div>
                                </form>
                                <?php foreach ($main_categories as $main_category): ?>

                                    <div class="tab-pane fade mx-2"
                                         id="nav-<?php echo volgo_make_slug(strtolower($main_category['parent']->name)); ?>">
                                        <a href="javascript:void(0)" class="closeTab">
                                            <i class="fa fa-close" aria-hidden="true"></i>
                                        </a>
                                        <form action="<?php echo base_url('listing/search/'); ?>" method="get">
                                            <div class="form-group">
                                                <div class="row m-0">
                                                    <div class="col-sm-6 place-cell">
                                                        <select name="select_state" class="select_state form-control">
                                                            <option value="">------Select State-------</option>
                                                            <?php foreach ((array)volgo_get_country_states_by_session_country_id() as $state): ?>
                                                                <option
                                                                        value="<?php echo $state->id; ?>"><?php echo $state->name; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6 place-cell">
                                                        <select name="parent_cat_select"
                                                                class="parent_cat_select form-control">
                                                            <option value="">------Select Category-------</option>

                                                            <?php foreach ($main_categories as $mp) : ?>

                                                                <option
                                                                        data-target_nav="#nav-<?php echo volgo_make_slug(strtolower($mp['parent']->name)); ?>" <?php echo ($main_category['parent']->id === $mp['parent']->id) ? 'selected' : ''; ?>
                                                                        value="<?php echo $mp['parent']->id; ?>"><?php echo ucwords($mp['parent']->name); ?></option>

                                                            <?php endforeach; ?>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row m-0">
                                                    <div class="col-sm-6 place-cell">
                                                        <select
                                                                data-parent_id="<?php echo $main_category['parent']->id; ?>"
                                                                name="child_cats" class="child_cats form-control">
                                                            <option value="">------Select Category-------</option>

                                                            <?php foreach ($main_category['childs'] as $child) : ?>

                                                                <option
                                                                        value="<?php echo $child->id; ?>"><?php echo ucwords($child->name); ?></option>

                                                            <?php endforeach; ?>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div
                                                    class="form-group dynamic-form-wrapper dynamic-header-form-wrapper-<?php echo $main_category['parent']->id; ?>">
                                                <!-- Form will populate here dynamically -->
                                                <div id="dynamic-header-form"></div>
                                                <div class="spinner-loader-wrapper">
                                                    <div class="spinner-loader fa fa-spinner fa-spin fa-2x fa-fw"></div>
                                                </div>
                                            </div>

                                            <div class="searchHolder" style="position:relative;">
                                                <div class="form-group searchField">
                                                    <input type="text" class="form-control" name="search_query"
                                                           placeholder="What you are looking for ?">
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-search">Submit</button>
                                            </div>

                                        </form>
                                    </div>

                                <?php endforeach; ?>

                            </div>

                        </div>
                    <?php endif; ?>
                    <!--<div class="searchHolder">
                      <div class="form-group searchField">
                        <input type="text" class="form-control" placeholder="What you are looking for ?">
                      </div>
                      <button type="submit" class="btn btn-primary btn-search">Submit</button>
                    </div>-->
                </div>
            </div>
            <div class="marqueeHolder">
                <span class="latest-offer">Latest Buy Offers</span>
                <marquee behavior="scroll" direction="left" scrollamount="5" onmouseover="this.stop();"
                         onmouseout="this.start();">
                    <ul class="marqueeNav list-unstyled">
                        <?php foreach ($new_listings as $new_listing): ?>
                            <li class="listing-item listing-item-<?php echo $new_listing->id; ?>">
                                <a href="<?php echo base_url($new_listing->slug); ?>"><?php echo $new_listing->title; ?>
                                    <em><?php echo date('M d, Y', strtotime($new_listing->created_at)); ?></em></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </marquee>
            </div>
        </div>
    </div>
    </div>
</section>
<!--Js Masonry-->
<div class="container-fluid masonryHolder desktopHideOnMobile">
    <div class="container-fluid mainWrapper">
        <div class="row">
            <div class="col-md-8 positionStatic desktopHideOnMobile">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" data-toggle="tab" href="#nav-recomend"
                           aria-controls="nav-recomend">Recommended</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#nav-featured"
                           aria-controls="nav-featured">Featured Products</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-recomend">
                        <div class="masonry">
                            <?php if (!empty($listings) && isset($listings['recommended'])): ?>
                                <?php foreach ($listings['recommended'] as $recommended_listing) : ?>

                                    <?php


                                    $listing_price = 0;
                                    $listing_image = volgo_get_no_image_url();
                                    $currency_code = B2B_CURRENCY_UNIT;

                                    foreach ($recommended_listing['metas'] as $meta): ?>

                                        <!-- Listing Image -->
                                        <?php if ($meta['meta_key'] === 'images_from' && (!empty($meta['meta_value']))) {

                                            $images = (unserialize($meta['meta_value']));
                                            if (!empty($images) && isset($images[0])) {
                                                $listing_image = UPLOADS_URL . '/listing_images/' . $images[0];

                                                /*
                                                 * @todo: Taking too much time on load.
                                                 * if(! @getimagesize($listing_image)){
                                                    $listing_image = volgo_get_no_image_url();
                                                }*/
                                            } else
                                                $listing_image = volgo_get_no_image_url();
                                        }
                                        ?>

                                        <!-- Listing Price -->
                                        <?php if ($meta['meta_key'] === 'price' && (!empty($meta['meta_value']))) $listing_price = $meta['meta_value']; ?>

                                        <!-- Price Unit -->
                                        <?php if ($meta['meta_key'] === 'currency_code' && (!empty($meta['meta_value']))) $currency_code = $meta['meta_value']; ?>


                                    <?php endforeach;

                                    ?>

                                    <div
                                            class="item item-<?php echo $recommended_listing['listing_info']['listing_id']; ?>">
                                        <a href="<?php echo base_url() . $recommended_listing['listing_info']['listing_slug']; ?>"
                                           class="grid-item-link"><img
                                                    src="<?php echo $listing_image; ?>" alt="Image"
                                                    class="img-fluid"></a>
                                        <div class="detail-thumb">
                                            <a href="<?php echo base_url() . $recommended_listing['listing_info']['listing_slug']; ?>"
                                               class="grid-item-link"><span
                                                        class="mas-title"><?php echo $recommended_listing['listing_info']['listing_title']; ?></span></a>
                                            <a href="<?php echo base_url('category/') . strtolower(volgo_make_slug($recommended_listing['category_info']['category_name']));?>">
                                                <p class="mas-detail">Category: <?php echo $recommended_listing['category_info']['category_name']; ?></p>
                                            </a>
                                                <span class="detail-thumb-price">
                                                    <?php if(isset($listing_price) && !empty($listing_price)) {?>
                                                    <span class="currency-code">
                                                        <?php echo (!empty($currency_code)) ? strtoupper($currency_code) : 'AED'; ?>
                                                    </span>
                                                    <span class="detail-price">
                                                        <?php echo number_format(intval($listing_price)); ?>
                                                    </span>
                                                    <?php }else{
                                                        echo 'N/A';
                                                    }?>
                                                </span>
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-featured">
                        <div class="masonry">
                            <?php if (!empty($listings) && isset($listings['featured'])): ?>
                                <?php foreach ($listings['featured'] as $f_listing) : ?>

                                    <?php

                                    $listing_image = base_url() . 'uploads/general/no-image.jpg';
                                    $listing_price = 0;
                                    $currency_code = B2B_CURRENCY_UNIT;

                                    foreach ($f_listing['metas'] as $meta): ?>

                                        <!-- Listing Image -->
                                        <?php if ($meta['meta_key'] === 'images_from' && (!empty($meta['meta_value']))) {
                                            $lm = unserialize($meta['meta_value']);
                                            if (!empty($lm))
                                                $listing_image = UPLOADS_URL . '/listing_images/' . ($lm[0]);
                                        }

                                        ?>

                                        <!-- Listing Price -->
                                        <?php if (($meta['meta_key'] === 'price') && (!empty($meta['meta_value']))) $listing_price = $meta['meta_value']; ?>

                                        <!-- Price Unit -->
                                        <?php if ($meta['meta_key'] === 'currency_code' && (!empty($meta['meta_value']))) $currency_code = $meta['meta_value']; ?>


                                    <?php endforeach; ?>
                                    <div class="item item-<?php echo $f_listing['listing_info']['listing_id']; ?>">
                                        <a href="<?php echo base_url() . $f_listing['listing_info']['listing_slug']; ?>"
                                           class="grid-item-link"><img
                                                    src="<?php echo $listing_image; ?>" alt="Image"
                                                    class="img-fluid"></a>
                                        <div class="detail-thumb">
                                            <a href="<?php echo base_url() . $f_listing['listing_info']['listing_slug']; ?>">
											<span class="mas-title"><?php echo $f_listing['listing_info']['listing_title']; ?></span></a>
                                            <a href="<?php echo base_url('category/') . strtolower(volgo_make_slug($f_listing['category_info']['category_name']));?>">
                                                <p class="mas-detail"> Category: <?php echo $f_listing['category_info']['category_name']; ?></p>
                                            </a>
                                            <span class="detail-thumb-price">
                                                    <?php if(isset($listing_price) && !empty($listing_price)) {?>
                                                        <span class="currency-code">
                                                        <?php echo (!empty($currency_code)) ? strtoupper($currency_code) : 'AED'; ?>
                                                    </span>
                                                        <span class="detail-price">
                                                        <?php echo number_format(intval($listing_price)); ?>
                                                    </span>
                                                    <?php }else{
                                                        echo 'N/A';
                                                    }?>
                                                </span>

                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 desktopHideOnMobile">
                <div class="sidebarAds">
                    <div class="masonry masonry-sidebar">
                        <?php if (isset($buying_leads, $buying_leads['buying_lead'])): ?>
                            <?php foreach ($buying_leads['buying_lead'] as $lead) :

                                $listing_price = 0;
                                $listing_image = base_url() . 'uploads/general/no-image.jpg';
                                foreach ($lead['metas'] as $meta):
                                    if ($meta['meta_key'] === 'images_from' && (!empty($meta['meta_value']))) {
                                        $lm = unserialize($meta['meta_value']);
                                        if (!empty($lm))
                                            $listing_image = UPLOADS_URL . '/listing_images/' . ($lm[0]);
                                    }

                                    if ($meta['meta_key'] === 'listing_price' && (!empty($meta['meta_value']))) $listing_price = $meta['meta_value'];
                                endforeach;
                                ?>


                                <div class="item item-<?php echo $lead['listing_info']['listing_id']; ?> ">
                                    <a href="<?php echo base_url($lead['listing_info']['listing_slug']); ?>"
                                       class="grid-item-link"><img
                                                src="<?php echo $listing_image; ?>" alt="Image"
                                                class="img-fluid"></a>
                                    <div class="detail-thumb">
                                        <a href="<?php echo base_url() . $lead['listing_info']['listing_slug']; ?>">
                                            <span class="mas-title"><?php echo $lead['listing_info']['listing_title']; ?></span></a>
                                        <a href="<?php echo base_url('category/') . strtolower(volgo_make_slug($lead['category_info']['category_name']));?>">
                                            <p class="mas-detail"> Category: <?php echo $lead['category_info']['category_name']; ?></p>
                                        </a>
                                        <span class="detail-thumb-price"><?php echo (!empty($listing_price)) ? strtoupper(B2B_CURRENCY_UNIT) . ' ' . number_format($listing_price) : 'N/A'; ?></span>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($ad_banners)): ?>
                        <?php foreach ($ad_banners as $banner): ?>
                            <?php if ($banner->ad_type === 'image'): ?>
                                <div class="adBanner image-type">
                                    <a href="<?php echo $banner->url; ?>" class="d-block">
                                        <img alt="<?php echo $banner->title; ?>"
                                             src="<?php echo UPLOADS_URL . '/adbanners/' . $banner->ad_code_image; ?>"
                                             class="img-fluid">
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="adBanner code-type">
                                    <?php echo($banner->ad_code_image); ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mainWrapper mb-3 desktopHideOnMobile">
    <h2 class="styled-heading"> TRADE SHOWS
        <span class="heading-text-trad"> What’s happening in Trade World?</span>
    </h2>
    <div class="row mb-3">

        <?php
        $counter = 0;
        foreach ($metas_trade_show as $trade_show_single_meta):
            if ($counter >= 2)
                break;

            ?>


            <div class="col-lg-6">
                <div class="tradeHolder clearfix">

                    <div class="tradeHolderImg">
                        <img
                                src="<?php echo (empty($trade_show_single_meta['tradeshow_info']['featured_image'])) ? volgo_get_no_image_url() : UPLOADS_URL . '/tradeshows/' . unserialize($trade_show_single_meta['tradeshow_info']['featured_image']); ?>"
                                alt="Image" class="img-fluid">
                    </div>

                    <div class="tradebyDetail">

						<span
                                class="tradeTitle"><?php echo $trade_show_single_meta['tradeshow_info']['title'] ?> </span>
                        <em class="tradeTitleDetail"><?php echo $trade_show_single_meta['tradeshow_info']['content'] ?>
                        </em>
                        <div class="hr-dotted">&nbsp;</div>
                        <ul class="sec-text">
                            <?php foreach ($trade_show_single_meta['metas'] as $trade_show_meta): ?>

                                <?php

                                if ($trade_show_meta['meta_key'] === 'starting_date') {
                                    echo '<li>
							<strong>Start Date:</strong>
							<span>';
                                    echo $trade_show_meta['meta_value'];
                                    echo '</span>
						</li>';
                                }

                                ?>
                                <?php
                                if ($trade_show_meta['meta_key'] === 'ending_date') {
                                    echo '<li>
							<strong>End Date:</strong>
							<span>';
                                    echo $trade_show_meta['meta_value'];
                                    echo '</span>
						</li>';
                                }

                                ?>

                                <?php
                                if ($trade_show_meta['meta_key'] === 'ts_venue') {
                                    echo '<li>
							<strong>Venue: </strong>
							<span>';
                                    echo $trade_show_meta['meta_value'];
                                    echo '</span>
						</li>';
                                }

                                ?>

                            <?php endforeach; ?>
                        </ul>
                        <a href="<?php echo base_url('tradeshow/' . $trade_show_single_meta['tradeshow_info']['slug']); ?>"
                           class="btn btn-primary btn-event">Event Detail</a>
                    </div>
                </div>
            </div>

            <?php $counter++;
        endforeach; ?>

    </div>
    <div class="btn-center">
        <a href="<?php echo base_url('tradeshows'); ?>" class="btn btn-primary">View More</a>
    </div>
</div>
<div class="container-fluid mainWrapper mb-3 subscribeFormHolder desktopHideOnMobile">
    <div class="row">
        <div class="col-lg-8 mb-md-3">
            <a href="javascript:void(0)" class="postad-img">
                <img src="<?php echo base_url('uploads/general/post-ad-image.jpg'); ?>" alt="Image" class="img-fluid">
            </a>
        </div>
        <div class="col-lg-4">
            <?php if (!empty($this->session->flashdata('validation_errors'))): ?>
                <div class="alert alert-danger">
                    <div><?php echo $this->session->flashdata('validation_errors'); ?></div>
                </div>
            <?php endif; ?>
            <?php if (!empty($this->session->flashdata('success_msg'))): ?>
                <div class="alert alert-success">
                    <div><?php echo $this->session->flashdata('success_msg'); ?></div>
                </div>
            <?php endif; ?>
            <form action="<?php echo base_url('subscribers/create'); ?>" class="subscribeForm" method="post">
                <fieldset>
                    <span class="subTitle">CONNECTED WITH MILLIONS OF BUYERS AND SELLERS GLOBALLY</span>
                    <em class="subtTitleAction">SUBSCRIBE NOW</em>
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-subscribe-submit">Submit</button>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<div class="popup-overlay"></div>
<?php if (!empty($this->session->flashdata('subscriber_error'))): ?>
    <!--Creates the popup content-->
    <div class="popup-content">
        <img src="<?php echo base_url('assets/images/warning_icon.png') ?>" alt="close-button-image">
        <div class="error-msg">

            <?php echo $this->session->flashdata('subscriber_error'); ?>
        </div>
        <!--popup's close button-->
        <button class="btn btn-danger btn_close">Go Back</button>
    </div>
<?php endif; ?>

<?php if (!empty($this->session->flashdata('subscriber_success'))): ?>
    <!--Creates the popup content-->
    <div class="popup-content popup3">
        <div class="icon-box">
            <i class="fa fa-check"></i>
        </div>
        <div class="success-msg" style="margin: 90px 0 0 0;">
            <?php echo $this->session->flashdata('subscriber_success'); ?>
        </div>
        <!--popup's close button-->
        <button class="btn btn-success btn_close">Go Back</button>
    </div>
<?php endif; ?>

<?php include_once realpath(__DIR__) . '/includes/footer.php'; ?>
