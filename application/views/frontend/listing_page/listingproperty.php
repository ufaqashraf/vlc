<?php include_once realpath(__DIR__ . '/..') . '/includes/top_header.php'; ?>
<?php include_once realpath(__DIR__ . '/..') . '/includes/header.php'; ?>
<style>

    .mainking{
        display: flex !important;
        transition-timing-function: ease;

        /* Also the same as */
        transition-timing-function: cubic-bezier(0.25, 0.1, 0.25, 1);
    }

</style>
<section class="main-section">
    <!-- property filter -->
    <?php include_once realpath(__DIR__ . '/..') . '/includes/property_search_filter.php'; ?>

	<div class="container-fluid mainWrapper listingMain listing_prop_sale">
		<div class="row">
			<div class="col-md-8 col-lg-9">
				<div class="row sellerHolder">
					<div class="col-md-8">
						<span class="adTitle"><?php echo $total_add ?> Ads for Property in
                        <?php
						$country_name = volgo_get_user_location();
						echo $country_name['country_name'];
						?>
						</span>
						</span>
						<em class="adTitleSub">Change country from Top Menu to See Ads of different countries.</em>
					</div>
				</div>
				<div class="stackHolder tags bgGrey">
					<a href="javascipt:void(0)" class="adImageLeft">
                        <?php foreach (volgo_get_left_sidebar_ad_banners() as $value): ?>
                            <?php if ($value->ad_type === 'image'): ?>
                                <img src="<?php echo UPLOADS_URL . '/adbanners/' . $value->ad_code_image; ?>" alt="Image">
                            <?php else: ?>
                                <div class="adBanner code-type">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php echo $value->ad_code_image; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach ?>
					</a>
					<div class="row m-0">
						<div class="col-md-7 col-lg-8 pl-sm-0">
							<div class="breadcrumbHolder">
								<span>Browse result in:</span>
                                <ul class="breadcrumbNav list-unstyled">
                                    <li>
                                        <span href="javascript:void(0)"><?php
                                            $country_name = volgo_get_user_location();
                                            echo $country_name['country_name'];
                                            ?>
                                        </span>
                                    </li>
                                    <?php if (!empty($parent_cat_name)): ?>
                                        <li>
                                        <span href="javascript:void(0)" class="parent_cat" data-parent="<?php echo $parent_cat_name ?>">
                                            <?php echo $parent_cat_name ?>
                                        </span>
                                        </li>
                                        <li class="child_cat" data-parent="<?php echo $cat_name ?>">
                                            <a href="<?php echo base_url() . 'category/' . $parent_cat_name ?> ">
                                                <?php echo $cat_name; ?>
                                                <i class="fa faClose-icon" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    <?php else: ?>
                                        <li class="parent_cat" data-parent="<?php echo $cat_name ?>">
                                            <a href="<?php echo base_url()  . 'category/' . $cat_name ?>  ">
                                                <?php echo $cat_name; ?>
                                                <!-- <i class="fa faClose-icon" aria-hidden="true"></i> -->
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
							</div>
						</div>
						<div class="col-md-5 col-lg-4 pr-sm-0 pl-lg-5">
							<div class="bestSeller-field">
								<span class="sortBy">Sort by:</span>
								<select class="form-control selectpicker sorting_select" name="sorting" >
                                    <option <?php if(!empty($_GET['sorting']) && $_GET['sorting'] == 'desc'){echo 'selected';} ?> value="desc">Newest to Oldest</option>
                                    <option <?php if(!empty($_GET['sorting']) && $_GET['sorting'] == 'asc'){echo 'selected';} ?> value="asc">Oldest to Newest</option>
                                    <option <?php if(!empty($_GET['sorting']) && $_GET['sorting'] == 'price-desc'){echo 'selected';} ?> value="price-desc">Price Highest to Lowest</option>
                                    <option <?php if(!empty($_GET['sorting']) && $_GET['sorting'] == 'price-asc'){echo 'selected';} ?> value="price-asc">Price Lowest to Highest</option>
								</select>
							</div>
						</div>
					</div>
				</div>
                <?php if (isset($sub_childs_cats) && !empty($sub_childs_cats)) : ?>
				<div class="categoryHolderMain">
					<div class="holder">
						<ul class="categoryHolder list-unstyled showmorehide clearfix expandible">

							<?php


							foreach ($sub_childs_cats as $single_child_category) {
								if(isset($single_child_category->slug)){
									$linkof_cat = $single_child_category->slug;
								}else{
									$linkof_cat = '#';
								}
								?>

								<li>

                                    <a href='<?php
                                    if($linkof_cat === '#'){
                                        echo base_url('category/') . $cat_name . '#';
                                    }else {
                                        echo base_url('category/' . $linkof_cat);
                                    }
                                    ?>'>
                                        <?php echo $single_child_category->name; ?>
                                    </a>

									<em><?php

										echo $single_child_category->total;

										?>

									</em>

								</li>
								<?php


							}


							?>


						</ul>
						<div class="text-center">
							<a href="javascript:void(0)" class="showMore" data-toggle="collapse"
							   data-target=""> Show More
								<i class="fa categoryArrowDown" aria-hidden="true"></i>
							</a>
							<a href="javascript:void(0)" class="showMore showLess" data-toggle="collapse"
							   data-target=""> Show Less
								<i class="fa categoryArrowUp" aria-hidden="true"></i>
							</a>
						</div>
					</div>
				</div>
                <?php endif; ?>
                <div class="stackHolder bgGrey">
                    <div class="checkboxHolder ajax-listing-filters">
                        <label class="checkboxStyle"> Listing with Photo
                            <input type="checkbox" id="photo_only" value="photo_only" class="photo_only"
                                   name="photo_only">
                            <span class="checkmark"></span>
                        </label>
                        <label class="checkboxStyle"> Listing with Price
                            <input type="checkbox" id="price_only" value="price_only" class="price_only"
                                   name="price_only">
                            <span class="checkmark"></span>
                        </label>
                    </div>

                </div>
                <div class="listings-container">
                    <?php if (isset($listing_by_cat_recommended) && !empty($listing_by_cat_recommended)) : ?>
                    <div class="gridViewCat">
                        <div class="row">


                            <?php


                            $count = 0;

                            foreach ($listing_by_cat_recommended as $listing_by_category_single):
                                $listing_no_image = volgo_get_no_image_url();
                                foreach ($listing_by_category_single['metas'] as $singlemeta):

                                    if ($singlemeta['meta_key'] == 'listing_type') {
                                        $listing_type = $singlemeta['meta_value'];

                                    }
                                    if ($singlemeta['meta_key'] == 'price') {
                                        $price = number_format(intval($singlemeta['meta_value']));
                                    }
                                    if ($singlemeta['meta_key'] == 'rooms') {
                                        $room = number_format(intval($singlemeta['meta_value']));
                                    }
                                    if ($singlemeta['meta_key'] == 'bathrooms') {
                                        $bathroom = number_format(intval($singlemeta['meta_value']));
                                    }
                                    if ($singlemeta['meta_key'] == 'size') {
                                        $size = number_format(intval($singlemeta['meta_value']));
                                    }

                                    if ($singlemeta['meta_key'] === 'currency_code') {
                                        $currency_code = $singlemeta['meta_value'];
                                    }

                                    if ($singlemeta['meta_key'] == 'images_from') {

                                        $singleimage = $singlemeta['meta_value'];

                                        $unserialized_image = unserialize($singleimage);


                                        if (is_array($unserialized_image))
                                            $total_images = count($unserialized_image);
                                        else
                                            $total_images = "";

                                        if (isset($unserialized_image[0]))
                                            $listing_image = UPLOADS_URL . '/listing_images/' . $unserialized_image[0];

                                    }
                                endforeach;


                                ?>
                                <div class="col-md-6">

                                    <div class="holder">
                                        <a href="<?php $sharelink = base_url() . $listing_by_category_single['listing_details']['slug'];
                                        $share_title = $listing_by_category_single['listing_details']['title'];
                                        echo base_url() . $listing_by_category_single['listing_details']['slug'];?>"
                                           class="catLink">
                                            <img src="<?php echo (empty($listing_image)) ? $listing_no_image : $listing_image; ?>"
                                                 class="img-fluid" alt="img">
                                            <span class="catFilter"></span>
                                        </a>
                                        <a href="javascript:void(0)" class="promotedStack">Premium</a>
                                        <a href="javascript:void(0)" class="totalCat">
                                            <?php
                                            echo (empty($total_images)) ? 'N/A' : $total_images;
                                            ?>

                                            <i class="fa fa-camera" aria-hidden="true"></i>
                                        </a>
                                        <div class="catImgInfo">
                                            <a href="<?php if (isset($sharelink) && $sharelink !== '') {
                                                echo $sharelink;
                                            } ?>">
                                                <?php if (isset($listing_by_category_single['listing_details']['title']) && $listing_by_category_single['listing_details']['title'] !== '') {
                                                    echo $listing_by_category_single['listing_details']['title'];
                                                    unset($listing_by_category_single['listing_details']['title']);
                                                } else {
                                                    echo 'N/A';
                                                } ?>
                                            </a>

                                            <p class="loc-point"><i class="fa fa-map-marker" aria-hidden="true"></i>
                                                <?php if (isset($listing_by_category_single['listing_details']['country_name']) && $listing_by_category_single['listing_details']['country_name'] !== '') {
                                                    echo $listing_by_category_single['listing_details']['country_name'];
                                                    unset($listing_by_category_single['listing_details']['country_name']);
                                                } else {
                                                    echo 'N/A';
                                                } ?> ,
                                                <?php if (isset($listing_by_category_single['listing_details']['city_name']) && $listing_by_category_single['listing_details']['city_name'] !== '') {
                                                    echo $listing_by_category_single['listing_details']['city_name'];
                                                    unset($listing_by_category_single['listing_details']['city_name']);
                                                } else {
                                                    echo 'N/A';
                                                } ?> ,
                                                <?php if (isset($listing_by_category_single['listing_details']['state_name']) && $listing_by_category_single['listing_details']['state_name'] !== '') {
                                                    echo $listing_by_category_single['listing_details']['state_name'];
                                                    unset($listing_by_category_single['listing_details']['state_name']);
                                                } else {
                                                    echo 'N/A';
                                                } ?>


                                            </p>
                                            <span class="priceTag">
                                                <?php if(isset($price) && !empty($price)){ ?>
                                                    <span class="currency-code">
                                                    <?php echo (!empty($currency_code)) ? strtoupper($currency_code) : strtoupper(B2B_CURRENCY_UNIT); ?>
                                                </span>
                                                    <span class="detail-price">
                                                    <?php echo $price; ?>
                                                </span>
                                                <?php }else{ echo 'N/A';} ?>
                                            </span>

                                            <div class="propIcons">
                                                <p><span>
                                                        <?php
                                                        if (isset($room) && $room !== '') {
                                                            echo $room;
                                                            unset($room);
                                                        } else {
                                                            echo 'N/A';
                                                        }
                                                        ?>
                                                        <em class="fabed">Bed</em></span>
                                                    <span>
                                                        <?php
                                                        if (isset($bathroom) && $bathroom !== '') {
                                                            echo $bathroom;
                                                            unset($bathroom);
                                                        } else {
                                                            echo 'N/A';
                                                        }
                                                        ?>
                                                        <em class="fabath">bath</em></span>

                                                    <span>
                                                        <?php
                                                        if (isset($size) && $size !== '') {
                                                            echo $size;
                                                            unset($size);
                                                        } else {
                                                            echo 'N/A';
                                                        }
                                                        ?>
                                                         Sqft</span>
                                                </p>
                                            </div>
                                            <a href="javascript:void(0)" class="catTypeSame"></a>
                                        </div>
                                    </div>
                                </div>

                            <?php
                            endforeach;
                            ?>


                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (isset($listing_by_cat_featured) && !empty($listing_by_cat_featured)) : ?>
                    <div class="listViewCat">
                        <div class="row">


                            <?php
                            ////////////////// this is for full widht listing display php ///////////////////////
                            ?>

                            <?php
                            $count = 0;

                            
                            foreach ($listing_by_cat_featured as $listing_by_category_single):
                                $listing_no_image = volgo_get_no_image_url();
                                foreach ($listing_by_category_single['metas'] as $singlemeta):


                                    if ($singlemeta['meta_key'] == 'listing_type') {
                                        $listing_type = $singlemeta['meta_value'];
                                    }
                                    if ($singlemeta['meta_key'] == 'phone') {
                                        $phone = $singlemeta['meta_value'];
                                    }
                                    if ($singlemeta['meta_key'] == 'propertylocation') {
                                        $location = $singlemeta['meta_value'];
                                    }
                                    if ($singlemeta['meta_key'] === 'currency_code') {
                                        $currency_code = $singlemeta['meta_value'];
                                    }
                                    if ($singlemeta['meta_key'] == 'price') {
                                        $price = number_format(intval($singlemeta['meta_value']));
                                    }
                                    if ($singlemeta['meta_key'] == 'rooms') {
                                        $room = number_format(intval($singlemeta['meta_value']));
                                    }
                                    if ($singlemeta['meta_key'] == 'bathrooms') {
                                        $bathroom = number_format(intval($singlemeta['meta_value']));
                                    }
                                    if ($singlemeta['meta_key'] == 'size') {
                                        $size = number_format(intval($singlemeta['meta_value']));
                                    }

                                    if ($singlemeta['meta_key'] == 'images_from') {

                                        $singleimage = $singlemeta['meta_value'];

                                        $unserialized_image = unserialize($singleimage);


                                        if (is_array($unserialized_image))
                                            $total_images = count($unserialized_image);
                                        else
                                            $total_images = "";

                                        if (isset($unserialized_image[0]))
                                            $listing_image = UPLOADS_URL . '/listing_images/' . $unserialized_image[0];

                                    }

                                endforeach;

                                ?>
                                <div class="col-md-12">


                                    <div class="holder">


                                        <div class="lisViewtCatHolder clearfix">
                                            <div class="lisViewtCatCol"><a href="javascript:void(0)" class="promotedStack">
                                                    <?php
                                                    if (isset($listing_type) && $listing_type !== '') {
                                                        echo $listing_type;
                                                        unset($listing_type);
                                                    } else {
                                                        echo 'N/A';
                                                    } ?>

                                                </a>

                                                <a href="<?php $sharelink = base_url() . $listing_by_category_single['listing_details']['slug'];
                                                $share_title = $listing_by_category_single['listing_details']['title'];
                                                echo base_url() . $listing_by_category_single['listing_details']['slug'];?>"
                                                   class=" lisViewtCatLink">
                                                    <img src="<?php echo (empty($listing_image)) ? $listing_no_image : $listing_image; ?>" alt="img">
                                                </a>
                                                <a href="javascript:void(0)" class="totalCat">
                                                    <?php
                                                    echo (empty($total_images)) ? 'N/A' : $total_images;
                                                    ?>
                                                    <i class="fa fa-camera" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                            <div class="lisViewtCatDetail">
                                                <h3>
                                                    <?php if (isset($listing_by_category_single['listing_details']['title']) && $listing_by_category_single['listing_details']['title'] !== '') {
                                                        echo $listing_by_category_single['listing_details']['title'];
                                                        unset($listing_by_category_single['listing_details']['title']);
                                                    } else {
                                                        echo 'N/A';
                                                    } ?>

                                                </h3>
                                                <p class="loc-point"><i class="fa fa-map-marker" aria-hidden="true"></i>
                                                    <?php if (isset($listing_by_category_single['listing_details']['country_name']) && $listing_by_category_single['listing_details']['country_name'] !== '') {
                                                        echo $listing_by_category_single['listing_details']['country_name'];
                                                        unset($listing_by_category_single['listing_details']['country_name']);
                                                    } else {
                                                        echo 'N/A';
                                                    } ?> ,
                                                    <?php if (isset($listing_by_category_single['listing_details']['city_name']) && $listing_by_category_single['listing_details']['city_name'] !== '') {
                                                        echo $listing_by_category_single['listing_details']['city_name'];
                                                        unset($listing_by_category_single['listing_details']['city_name']);
                                                    } else {
                                                        echo 'N/A';
                                                    } ?> ,
                                                    <?php if (isset($listing_by_category_single['listing_details']['state_name']) && $listing_by_category_single['listing_details']['state_name'] !== '') {
                                                        echo $listing_by_category_single['listing_details']['state_name'];
                                                        unset($listing_by_category_single['listing_details']['state_name']);
                                                    } else {
                                                        echo 'N/A';
                                                    } ?> ,
                                                    <?php
                                                    if (isset($location) && $location !== '') {
                                                        echo $location;
                                                        unset($location);
                                                    } else {
                                                        echo 'N/A';
                                                    }
                                                    ?>

                                                </p>

                                                <span class="priceTag">
                                                    <span class="currency-code">
                                                    <?php
                                                    if(isset($price) && !empty($price)){
                                                    echo (!empty($currency_code)) ? strtoupper($currency_code) : strtoupper(B2B_CURRENCY_UNIT); ?>
                                                    </span>
                                                    <span class="detail-price">
                                                        <?php echo $price;
                                                        }else{
                                                            echo 'N/A';
                                                        }?>
                                                    </span>
                                                </span>

                                                <div class="propIcons">
                                                    <p><span><a href="#">
                                                            <?php
                                                            if (isset($room) && $room !== '') {
                                                                echo $room;
                                                                unset($room);
                                                            } else {
                                                                echo 'N/A';
                                                            }
                                                            ?>
                                                            <em class="fabed">Bed</em></a></span>


                                                        <span><a href="#">
                                                            <?php
                                                            if (isset($bathroom) && $bathroom !== '') {
                                                                echo $bathroom;
                                                                unset($bathroom);
                                                            } else {
                                                                echo 'N/A';
                                                            }
                                                            ?> <em class="fabath">bath</em></a></span>

                                                        <span><a href="#"><?php
                                                                if (isset($size) && $size !== '') {
                                                                    echo $size;
                                                                    unset($size);
                                                                } else {
                                                                    echo 'N/A';
                                                                }
                                                                ?> Sqft</a></span>
                                                    </p>
                                                </div>

                                                <div class="call-to-action-btns">
                                                    <ul class="list-unstyled clearfix catActionBtns">
                                                        <li>
                                                            <a href="mailto:support@volgopoint.com" class="reportNow">
                                                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                                                <span> Email Now </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                             <span class="number"
                                                                   data-last="<?php if (isset($phone) && $phone !== '') {
                                                                       echo $phone;
                                                                   } else {
                                                                       echo "### ";
                                                                   } ?>">
                                                            <span>
                                                                <a target="_blank" class="see">
                                                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                                                    <span class="calls">Call Now </span>
                                                                </a>
                                                            </span>
                                                            </span>
                                                        </li>
                                                        <li>
                                                            <?php
                                                            $user_id = volgo_get_logged_in_user_id();

                                                            if (isset($user_id)) {
                                                                $user_id = $user_id;
                                                            } else {
                                                                $user_id = 0;
                                                            }
                                                            ?>

                                                            <?php
                                                            $idoflisting = [];

                                                            if (!empty($listing_fav)) {
                                                                foreach ($listing_fav as $single_listing) {
                                                                    $idoflisting[] = $single_listing->meta_value;
                                                                    $user_id_retrived = $single_listing->user_id;
                                                                }
                                                            }
                                                            if (isset($user_id_retrived)) {
                                                                $user_id_retrived = $user_id_retrived;
                                                            } else {
                                                                $user_id_retrived = "no fav";
                                                            }


                                                            if ($user_id_retrived == $user_id):?>
                                                                <?php
                                                                if (in_array($listing_by_category_single['listing_details']['id'], $idoflisting)):

                                                                    ?>

                                                                    <a class="saveNow remove_fav_listing"
                                                                       data-lisitngid="<?php echo $listing_by_category_single['listing_details']['id']; ?>"
                                                                       data-user_id="<?php echo $user_id; ?>"
                                                                       href="#"
                                                                       style=" color: #fff;"
                                                                    >
                                                                        <i class="fa fa-spinner"
                                                                           style="display: none"></i><i
                                                                                class="fa fa-heart"
                                                                                aria-hidden="true"></i>
                                                                        <span> Favourite </span>
                                                                    </a>
                                                                    <a class="saveNow fav_add_listing"
                                                                       data-lisitngid="<?php echo $listing_by_category_single['listing_details']['id']; ?>"
                                                                       data-user_id="<?php echo $user_id; ?>"
                                                                       href="#" style="display: none;"
                                                                    >
                                                                        <i class="fa fa-spinner"
                                                                           style="display: none"></i><i
                                                                                class="fa fa fa-heart-o"
                                                                                aria-hidden="true"></i>
                                                                        <span> Favourite </span>
                                                                    </a>

                                                                <?php else: ?>

                                                                    <a class="saveNow fav_add_listing"
                                                                       data-lisitngid="<?php echo $listing_by_category_single['listing_details']['id']; ?>"
                                                                       data-user_id="<?php echo $user_id; ?>"
                                                                       href="#"
                                                                    >
                                                                        <i class="fa fa-spinner"
                                                                           style="display: none"></i><i
                                                                                class="fa fa-heart-o"
                                                                                aria-hidden="true"></i>
                                                                        <span> Favourite </span>
                                                                    </a>
                                                                    <a class="saveNow remove_fav_listing"
                                                                       data-lisitngid="<?php echo $listing_by_category_single['listing_details']['id']; ?>"
                                                                       data-user_id="<?php echo $user_id; ?>"
                                                                       href="#"
                                                                       style="display: none; ">
                                                                        <i class="fa fa-spinner"
                                                                           style="display: none"></i><i
                                                                                class="fa fa-heart"
                                                                                aria-hidden="true"></i>
                                                                        <span> Favourite </span>
                                                                    </a>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <a class="saveNow fav_add_listing"
                                                                   data-lisitngid="<?php echo $listing_by_category_single['listing_details']['id']; ?>"
                                                                   data-user_id="<?php echo $user_id; ?>" href="#"
                                                                   style=""
                                                                >
                                                                    <i class="fa fa-spinner"
                                                                       style="display: none"></i><i
                                                                            class="fa fa-heart"
                                                                            aria-hidden="true"></i>
                                                                    <span> Favourite </span>
                                                                </a>
                                                                <a class="saveNow remove_fav_listing"
                                                                   data-lisitngid="<?php echo $listing_by_category_single['listing_details']['id']; ?>"
                                                                   data-user_id="<?php echo $user_id; ?>" href="#"
                                                                   style="display: none;">
                                                                    <i class="fa fa-spinner"
                                                                       style="display: none"></i><i
                                                                            class="fa fa-heartbeat-o"
                                                                            aria-hidden="true"></i>
                                                                    <span> Favourite </span>
                                                                </a>
                                                            <?php endif; ?>
                                                        </li>

                                                        <li class="auto">
                                                            <?php
                                                            $user_id = volgo_get_logged_in_user_id();
                                                            $data_listing_slug = $listing_by_category_single['listing_details']['slug'];
                                                            ?>
                                                            <a href="<?php echo base_url('flagreports/index/') . $user_id . '/' . $data_listing_slug; ?>"
                                                               class="flagIcon"> Flag </a>
                                                        </li>
                                                        <li class="auto">
                                                            <a href="<?php
                                                            $sharelink = base_url() . $listing_by_category_single['listing_details']['slug'];
                                                            echo base_url() . $listing_by_category_single['listing_details']['slug']; ?>" class="shareNow"> share Now </a>
                                                            <a class="share_tw_item social-icon" data-url="<?php echo $sharelink; ?>" href="#" data-title="<?php echo $share_title; ?>">
															<i class="fa fa-twitter" aria-hidden="true"></i>
															</a>
															<a class="share_fb_item social-icon" data-url="<?php echo $sharelink; ?>" href="#" data-title="<?php echo $share_title; ?>">
															<i class="fa fa-facebook" aria-hidden="true"></i>
															</a>
															<a class="share_pt_item social-icon" data-url="<?php echo $sharelink; ?>" href="#" data-title="<?php echo $share_title; ?>">
															<i class="fa fa-pinterest" aria-hidden="true"></i>
															</a>
															<div class="share-blink-fix"></div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <a href="javascript:void(0)" class="shortLogo">

                                            </a>
                                        </div>

                                    </div>
                                </div>

                            <?php

                            endforeach; ?>

                        </div>
                    </div>
                    <?php endif; ?>
                </div>
				<div class="pagination-class"></div>
				<!-- Pagination -->
				<?php if (isset($links) && $links !== '') { ?>
					<div class="paginationHolder">
						<?php
						foreach ($links as $link) {
							echo $link;
						}
						?>
					</div>
				<?php } ?>

				<!-- Featured Ads -->
				<?php include_once realpath(__DIR__ . '/..') . '/includes/listing_featured_adds.php'; ?>

				<!-- Sell Anything Section -->
				<?php include_once realpath(__DIR__ . '/..') . '/includes/listing_selling_anything.php'; ?>

				<!-- Post Free Ad button -->
				<div class="text-center postfreeHolder">
					<a href="<?php echo base_url('ad-post'); ?>" class="postfreeButton"> post free ad </a>
				</div>
			</div>

			<?php // include_once realpath(__DIR__ . '/..') . '/includes/sidebar_filter_listing.php'; ?>

			<?php include_once realpath(__DIR__ . '/..') . '/includes/property_sidebar.php'; ?>
		</div>
	</div>
</section>

<?php include_once realpath(__DIR__ . '/..') . '/includes/footer.php'; ?>



