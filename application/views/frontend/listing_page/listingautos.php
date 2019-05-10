<?php include_once realpath(__DIR__ . '/..') . '/includes/top_header.php'; ?>

<?php include_once realpath(__DIR__ . '/..') . '/includes/header.php'; ?>

<section class="main-section">

    <div class="container-fluid mainWrapper listingMain listing_autos">

        <div class="row">

            <div class="col-md-8 col-lg-9">

                <div class="row sellerHolder">

                    <div class="col-md-8">

						<span class="adTitle"><?php echo $total_add; ?> Ads for Used Cars in



						<?php


                        $country_name = volgo_get_user_location();

                        echo $country_name['country_name'];

                        ?>

						</span>

                        <em class="adTitleSub">Change country from Top Menu to See Ads of different countries.</em>

                    </div>
                    <div class="textField searchBtnsAction">
						<ul class="list-unstyled clearfix saveBtn">
							
							<li>
								<a class="saveli save_search_history" id="save_search_history"
								   data-user_id="<?php if(isset($user_id)){ echo $user_id;} ?>" >
									<i class="fa fa-spinner paddindIt" style="display: none"></i>
									<i class="fa fa-heart-o" aria-hidden="true"></i>
									<span id="saveSpan">Save</span>

								</a>
								<a class="removesrch hide" id="removesrch"
								   data-user_id="<?php if(isset($user_id)){ echo $user_id;} ?>">
									<i class="fa fa-spinner paddindIt" style="display: none"></i>
									<i class="fa fa-heart-o" aria-hidden="true"></i>
									<span id="removeSpan">Remove</span>

								</a>
							</li>
						</ul>
					</div>                
                    </div>


                <?php include_once realpath(__DIR__ . '/..') . '/includes/browse-result-filters.php'; ?>

                <?php if (isset($sub_childs_cats) && !empty($sub_childs_cats)) : ?>

                    <div class="categoryHolderMain">

                        <div class="holder">


                            <ul class="categoryHolder list-unstyled showmorehide clearfix expandible">

                                <?php


                                foreach ($sub_childs_cats as $single_child_category) {
                                    if (isset($single_child_category->slug)) {
                                        $linkof_cat = $single_child_category->slug;
                                    } else {
                                        $linkof_cat = '#';
                                    }
                                    ?>

                                    <li>
                                        <a href='<?php
                                        if ($linkof_cat === '#') {
                                            echo base_url('category/') . $cat_name . '#';
                                        } else {
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


                                        if ($singlemeta['meta_key'] == 'price' && !empty($singlemeta['meta_value'])) {

                                            $price = number_format(intval($singlemeta['meta_value']));

                                        }


                                        if ($singlemeta['meta_key'] === 'currency_code' && !empty($singlemeta['meta_value'])) {

                                            $currency_code = $singlemeta['meta_value'];

                                        } else {

                                            $currency_code = B2B_CURRENCY_UNIT;

                                        }


                                        if ($singlemeta['meta_key'] == 'kilometers' && !empty($singlemeta['meta_value'])) {

                                            $milage = number_format(intval($singlemeta['meta_value']));

                                        }


                                        if ($singlemeta['meta_key'] == 'date') {

                                            $date = $singlemeta['meta_value'];

                                            $date = new DateTime($date);

                                            $date = date_format($date, "M Y");

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
                                         if($listing_by_category_single['listing_details']['subcat_name'] === $cat_name) {
                                    ?>

                                     <div class="col-md-4">

                                                <div class="holder">

                                                    <a href="<?php echo base_url($listing_by_category_single['listing_details']['slug']); ?>"

                                                       class="catLink">

                                                        <img

                                                                src="<?php echo (empty($listing_image)) ? $listing_no_image : $listing_image; ?>"

                                                                class="img-fluid" alt="image">

                                                        <span class="catFilter"></span>

                                                    </a>

                                                    <a href="javascript:void(0)"

                                                       class="promotedStack">

                                                        <?php

                                                        if (isset($listing_type) && $listing_type !== '') {

                                                            echo $listing_type;

                                                            unset($listing_type);

                                                        } else {

                                                            echo "N/A";

                                                        } ?>

                                                    </a>

                                                    <a href="javascript:void(0)"

                                                       class="totalCat">

                                                        <?php
                                                        echo (empty($total_images)) ? 'N/A' : $total_images;
                                                        ?>

                                                        <i class="fa fa-camera" aria-hidden="true"></i>

                                                    </a>

                                                    <div class="catImgInfo">

                                                        <a href="<?php echo base_url($listing_by_category_single['listing_details']['slug']); ?>">

                                                            <?php if (isset($listing_by_category_single['listing_details']['title']) && $listing_by_category_single['listing_details']['title'] !== '') {

                                                                echo $listing_by_category_single['listing_details']['title'];

                                                                unset($listing_by_category_single['listing_details']['title']);

                                                            } else {

                                                                echo "N/A";

                                                            } ?></a>

                                                        <span class="priceTag">
                                                    <span class="currency-code">
                                                    <?php
                                                    if (isset($price) && !empty($price)){
                                                    echo (!empty($currency_code)) ? strtoupper($currency_code) : strtoupper(B2B_CURRENCY_UNIT); ?>
                                                    </span>
                                                    <span class="detail-price">
                                                        <?php echo $price;
                                                        } else {
                                                            echo 'N/A';
                                                        } ?>
                                                    </span>
                                                 </span>

                                                        <?php $date = new DateTime($listing_by_category_single['listing_details']['created_at']);

                                                        $date = date_format($date, "M Y"); ?>

                                                        <?php if (isset($date) && $date !== ''){ ?>

                                                        <div class="catDisc">

                                                            <span>Date:</span>

                                                            <em><?php echo $date; ?></em>

                                                            <?php unset($date);

                                                            } else {

                                                                echo "N/A";

                                                            } ?>

                                                        </div>


                                                        <?php if (isset($milage) && $milage !== '') { ?>

                                                            <div class="catDisc">

                                                                <span>Mileage:</span>

                                                                <em><?php echo $milage; ?></em>

                                                            </div>

                                                            <?php unset($milage);

                                                        } else {

                                                            echo "N/A";

                                                        } ?>

                                                        <a href="javascript:void(0)" class="catTypeSame"></a>

                                                    </div>

                                                </div>

                                            </div>

                                    <?php }else { ?>

                                    <div class="col-md-4">

                                            <div class="holder">

                                                <a href="<?php echo base_url($listing_by_category_single['listing_details']['slug']); ?>"

                                                   class="catLink">

                                                    <img

                                                            src="<?php echo (empty($listing_image)) ? $listing_no_image : $listing_image; ?>"

                                                            class="img-fluid" alt="image">

                                                    <span class="catFilter"></span>

                                                </a>

                                                <a href="javascript:void(0)"

                                                   class="promotedStack">

                                                    <?php

                                                    if (isset($listing_type) && $listing_type !== '') {

                                                        echo $listing_type;

                                                        unset($listing_type);

                                                    } else {

                                                        echo "N/A";

                                                    } ?>

                                                </a>

                                                <a href="javascript:void(0)"

                                                   class="totalCat">

                                                    <?php
                                                    echo (empty($total_images)) ? 'N/A' : $total_images;
                                                    ?>

                                                    <i class="fa fa-camera" aria-hidden="true"></i>

                                                </a>

                                                <div class="catImgInfo">

                                                    <a href="<?php echo base_url($listing_by_category_single['listing_details']['slug']); ?>">

                                                        <?php if (isset($listing_by_category_single['listing_details']['title']) && $listing_by_category_single['listing_details']['title'] !== '') {

                                                            echo $listing_by_category_single['listing_details']['title'];

                                                            unset($listing_by_category_single['listing_details']['title']);

                                                        } else {

                                                            echo "N/A";

                                                        } ?></a>

                                                    <span class="priceTag">
                                                    <span class="currency-code">
                                                    <?php
                                                    if (isset($price) && !empty($price)){
                                                    echo (!empty($currency_code)) ? strtoupper($currency_code) : strtoupper(B2B_CURRENCY_UNIT); ?>
                                                    </span>
                                                    <span class="detail-price">
                                                        <?php echo $price;
                                                        } else {
                                                            echo 'N/A';
                                                        } ?>
                                                    </span>
                                                 </span>

                                                    <?php $date = new DateTime($listing_by_category_single['listing_details']['created_at']);

                                                    $date = date_format($date, "M Y"); ?>

                                                    <?php if (isset($date) && $date !== ''){ ?>

                                                    <div class="catDisc">

                                                        <span>Date:</span>

                                                        <em><?php echo $date; ?></em>

                                                        <?php unset($date);

                                                        } else {

                                                            echo "N/A";

                                                        } ?>

                                                    </div>


                                                    <?php if (isset($milage) && $milage !== '') { ?>

                                                        <div class="catDisc">

                                                            <span>Mileage:</span>

                                                            <em><?php echo $milage; ?></em>

                                                        </div>

                                                        <?php unset($milage);

                                                    } else {

                                                        echo "N/A";

                                                    } ?>

                                                    <a href="javascript:void(0)" class="catTypeSame"></a>

                                                </div>

                                            </div>

                                        </div>

                                <?php } endforeach;  ?>

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


                                        if ($singlemeta['meta_key'] == 'price' && !empty($singlemeta['meta_value'])) {

                                            $price = number_format(intval($singlemeta['meta_value']));

                                        }


                                        if ($singlemeta['meta_key'] === 'currency_code' && !empty($singlemeta['meta_value'])) {

                                            $currency_code = $singlemeta['meta_value'];

                                        }


                                        if ($singlemeta['meta_key'] === 'kilometers' && !empty($singlemeta['meta_value'])) {


                                            $milage = number_format(intval($singlemeta['meta_value']));

                                        }


                                        if ($singlemeta['meta_key'] == 'date' && !empty($singlemeta['meta_value'])) {

                                            $date = $singlemeta['meta_value'];

                                            $date = new DateTime($date);

                                            $date = date_format($date, "M Y");

                                        }

                                        if ($singlemeta['meta_key'] === 'images_from') {

                                            $singleimage = $singlemeta['meta_value'];
                                            $unserialized_image = unserialize($singleimage);
                                            if (!empty($unserialized_image)) {
                                                $total_images = count($unserialized_image);
                                                $listing_image = isset($unserialized_image[0]) ? $unserialized_image[0] : '';
                                                $listing_image = UPLOADS_URL . '/listing_images/' . ($listing_image);
                                            } else
                                                $listing_no_image;
                                        }

                                        if ($singlemeta['meta_key'] == 'make' && !empty($singlemeta['meta_value'])) {

                                            $make = $singlemeta['meta_value'];

                                        }

                                        if ($singlemeta['meta_key'] == 'year' && !empty($singlemeta['meta_value'])) {

                                            $make_year = $singlemeta['meta_value'];

                                        }

                                        if ($singlemeta['meta_key'] == 'color' && !empty($singlemeta['meta_value'])) {

                                            $color = $singlemeta['meta_value'];

                                        }

                                        if ($singlemeta['meta_key'] == 'warranty' && !empty($singlemeta['meta_value'])) {

                                            $warrenty = $singlemeta['meta_value'];

                                        }

                                        if ($singlemeta['meta_key'] == 'phone' && !empty($singlemeta['meta_value'])) {

                                            $phone = $singlemeta['meta_value'];

                                        }


                                    endforeach;

                                    ?>

                                    <?php if($listing_by_category_single['listing_details']['subcat_name'] === $cat_name) { ?>
                                        <div class="col-md-12">

                                            <div class="holder">

                                                <a href="javascript:void(0)" class="promotedStack">

                                                    <?php

                                                    if (isset($listing_type) && $listing_type !== '') {

                                                        echo $listing_type;

                                                        unset($listing_type);

                                                    } ?>


                                                </a>

                                                <div class="row mb-2">

                                                    <div class="col-sm-9">

                                                        <a href="<?php $sharelink = base_url() . $listing_by_category_single['listing_details']['slug'];
                                                        $share_title = $listing_by_category_single['listing_details']['title'];
                                                        echo base_url() . $listing_by_category_single['listing_details']['slug']; ?>"

                                                           class="listViewLink">

                                                            <?php if (isset($listing_by_category_single['listing_details']['title']) && $listing_by_category_single['listing_details']['title'] !== '') {

                                                                echo $listing_by_category_single['listing_details']['title'];

                                                                $slugs = $listing_by_category_single['listing_details']['title'];

                                                                unset($listing_by_category_single['listing_details']['title']);

                                                            } ?>

                                                        </a>

                                                        <span

                                                                class="listViewDate">

														<?php $date = new DateTime($listing_by_category_single['listing_details']['created_at']);

                                                        $date = date_format($date, "M Y"); ?>

                                                        <?php if (isset($date) && $date !== '') {

                                                            echo $date;

                                                            unset($date);

                                                        } else {

                                                            echo 'N/A';

                                                        } ?>



													</span>

                                                    </div>

                                                    <div class="col-sm-3">
                                                <span class="priceTag">
                                                    <span class="currency-code">
                                                    <?php
                                                    if (isset($price) && !empty($price)){
                                                    echo (!empty($currency_code)) ? strtoupper($currency_code) : strtoupper(B2B_CURRENCY_UNIT); ?>
                                                    </span>
                                                    <span class="detail-price">
                                                        <?php echo $price;
                                                        } else {
                                                            echo 'N/A';
                                                        } ?>
                                                    </span>
                                                 </span>
                                                    </div>

                                                </div>

                                                <div class="lisViewtCatHolder clearfix">

                                                    <div class="lisViewtCatCol">

                                                        <a href="<?php if (isset($sharelink) && $sharelink !== '') {

                                                            echo $sharelink;

                                                        } else {

                                                            echo "#";

                                                        } ?>" class="lisViewtCatLink">

                                                            <img

                                                                    src="<?php echo (empty($listing_image)) ? $listing_no_image : $listing_image; ?>"

                                                                    alt="img">

                                                        </a>

                                                        <a href="javascript:void(0)" class="totalCat">

                                                            <?php
                                                            echo (empty($total_images)) ? 'N/A' : $total_images;
                                                            ?>

                                                            <i class="fa fa-camera" aria-hidden="true"></i>

                                                        </a>

                                                    </div>

                                                    <div class="lisViewtCatDetail">

                                                        <ul class="list-unstyled listBread clearfix">


                                                            <li>

                                                                <a href="<?php echo base_url($listing_by_category_single['listing_details']['slug']); ?>">

                                                                    <?php


                                                                    if (isset($listing_by_category_single['listing_details']['category_name']) && $listing_by_category_single['listing_details']['category_name'] !== '') {

                                                                        echo $listing_by_category_single['listing_details']['category_name'];

                                                                    } else {

                                                                        echo "N/A";

                                                                    }

                                                                    ?>

                                                                </a>

                                                            </li>

                                                            <li>

																<span>

																	<?php

                                                                    //print_r($listing_by_category_single['listing_details']);

                                                                    if (isset($listing_by_category_single['listing_details']['subcat_name']) && $listing_by_category_single['listing_details']['subcat_name'] !== '') {

                                                                        echo $listing_by_category_single['listing_details']['subcat_name'];

                                                                    } else {

                                                                        echo "N/A";

                                                                    }

                                                                    ?>

																</span>

                                                            </li>

                                                        </ul>

                                                        <div class="locationNav">

                                                            <a href="javascript:void(0)" class="locationLink">

                                                                <i class="fa fa-map-marker" aria-hidden="true"></i>

                                                                Location: </a>

                                                            <ul class="list-unstyled listBread clearfix">

                                                                <li>

																	<span>

																	<?php


                                                                    if (isset($listing_by_category_single['listing_details']['country_name']) && $listing_by_category_single['listing_details']['country_name'] !== '') {

                                                                        echo $listing_by_category_single['listing_details']['country_name'];

                                                                    } else {

                                                                        echo "N/A";

                                                                    }

                                                                    ?>





																	</span>

                                                                </li>

                                                                <li>

																	<span>

																		<?php


                                                                        if (isset($listing_by_category_single['listing_details']['state_name']) && $listing_by_category_single['listing_details']['state_name'] !== '') {

                                                                            echo $listing_by_category_single['listing_details']['state_name'];

                                                                        } else {

                                                                            echo "N/A";

                                                                        }

                                                                        ?>

																	</span>

                                                                </li>

                                                                <li>

																	<span>

																		<?php


                                                                        if (isset($listing_by_category_single['listing_details']['city_name']) && $listing_by_category_single['listing_details']['city_name'] !== '') {

                                                                            echo $listing_by_category_single['listing_details']['city_name'];

                                                                        } else {

                                                                            echo "N/A";

                                                                        }

                                                                        ?>

																	</span>

                                                                </li>

                                                            </ul>

                                                        </div>

                                                        <ul class="list-unstyled catDetail clearfix">

                                                            <li>

                                                                <span>Make</span>


                                                                <?php


                                                                if (isset($make) && $make !== '') {

                                                                    echo $make;

                                                                    unset($make);

                                                                } else {

                                                                    echo "N/A";

                                                                } ?>


                                                            </li>

                                                            <li>


                                                                <span>Mileage</span>


                                                                <?php if (isset($milage) && $milage !== '') {

                                                                    echo $milage;

                                                                    unset($milage);

                                                                } else {

                                                                    echo "N/A";

                                                                } ?>


                                                            </li>

                                                            <li>

                                                                <span>Year</span>


                                                                <?php if (isset($make_year) && $make_year !== '') {

                                                                    echo $make_year;

                                                                    unset($make_year);

                                                                } else {

                                                                    echo "N/A";

                                                                } ?>


                                                            </li>

                                                            <li>

                                                                <span>Color</span>


                                                                <?php if (isset($color) && $color !== '') {

                                                                    echo $color;

                                                                    unset($color);

                                                                } else {

                                                                    echo "N/A";

                                                                } ?>


                                                            </li>

                                                        </ul>


                                                        <div class="call-to-action-btns">

                                                            <ul class="list-unstyled clearfix catActionBtns">


                                                                <li>

															 <span class="number" data-last="

															 <?php if (isset($phone) && $phone !== '') {

                                                                 echo $phone;

                                                             } else {

                                                                 echo "### ";

                                                             } ?>">

															<span>

																<a target="_blank" class="see"><i class="fa fa-phone"

                                                                                                  aria-hidden="true"></i>

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
                                                                <li>
                                                                    <?php
                                                                    $user_id = volgo_get_logged_in_user_id();
                                                                    $data_listing_slug = $listing_by_category_single['listing_details']['slug'];
                                                                    ?>
                                                                    <a href="<?php echo base_url('flagreports/index/') . $user_id . '/' . $data_listing_slug; ?>"
                                                                       class="reportNow">

                                                                        <i class="fa fa-flag" aria-hidden="true"></i>

                                                                        <span> Report Now </span>

                                                                    </a>

                                                                </li>

                                                                <li class="auto">
                                                                    <a href="<?php
                                                                    $sharelink = base_url() . $listing_by_category_single['listing_details']['slug'];
                                                                    echo base_url() . $listing_by_category_single['listing_details']['slug']; ?>"
                                                                       class="shareNow"> share Now </a>
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

                                                    <a href="javascript:void(0)" class="catTypeSame"></a>

                                                </div>

                                                <ul class="list-unstyled clearfix catActionBtns catActionBtnChange">

                                                    <li>

                                                        <a href="<?php echo base_url($listing_by_category_single['listing_details']['slug']); ?>">

                                                            <i class="fa fa-report-icon" aria-hidden="true"></i>

                                                            Car Report </a>

                                                    </li>

                                                    <li>

													<span> <a
                                                                href="<?php echo base_url($listing_by_category_single['listing_details']['slug']); ?>">Negotiable</a></span>

                                                    </li>

                                                    <?php

                                                    if (isset($warrenty) && $warrenty === 'Yes') { ?>

                                                        <li>

                                                            <span>Warranty</span>

                                                        </li>

                                                    <?php } ?>

                                                </ul>


                                            </div>

                                        </div>
                                        <?php }else { ?>
                                        <div class="col-md-12">

                                            <div class="holder">

                                                <a href="javascript:void(0)" class="promotedStack">

                                                    <?php

                                                    if (isset($listing_type) && $listing_type !== '') {

                                                        echo $listing_type;

                                                        unset($listing_type);

                                                    } ?>


                                                </a>

                                                <div class="row mb-2">

                                                    <div class="col-sm-9">

                                                        <a href="<?php $sharelink = base_url() . $listing_by_category_single['listing_details']['slug'];
                                                        $share_title = $listing_by_category_single['listing_details']['title'];
                                                        echo base_url() . $listing_by_category_single['listing_details']['slug']; ?>"

                                                           class="listViewLink">

                                                            <?php if (isset($listing_by_category_single['listing_details']['title']) && $listing_by_category_single['listing_details']['title'] !== '') {

                                                                echo $listing_by_category_single['listing_details']['title'];

                                                                $slugs = $listing_by_category_single['listing_details']['title'];

                                                                unset($listing_by_category_single['listing_details']['title']);

                                                            } ?>

                                                        </a>

                                                        <span

                                                                class="listViewDate">

														<?php $date = new DateTime($listing_by_category_single['listing_details']['created_at']);

                                                        $date = date_format($date, "M Y"); ?>

                                                        <?php if (isset($date) && $date !== '') {

                                                            echo $date;

                                                            unset($date);

                                                        } else {

                                                            echo 'N/A';

                                                        } ?>



													</span>

                                                    </div>

                                                    <div class="col-sm-3">
                                                <span class="priceTag">
                                                    <span class="currency-code">
                                                    <?php
                                                    if (isset($price) && !empty($price)){
                                                    echo (!empty($currency_code)) ? strtoupper($currency_code) : strtoupper(B2B_CURRENCY_UNIT); ?>
                                                    </span>
                                                    <span class="detail-price">
                                                        <?php echo $price;
                                                        } else {
                                                            echo 'N/A';
                                                        } ?>
                                                    </span>
                                                 </span>
                                                    </div>

                                                </div>

                                                <div class="lisViewtCatHolder clearfix">

                                                    <div class="lisViewtCatCol">

                                                        <a href="<?php if (isset($sharelink) && $sharelink !== '') {

                                                            echo $sharelink;

                                                        } else {

                                                            echo "#";

                                                        } ?>" class="lisViewtCatLink">

                                                            <img

                                                                    src="<?php echo (empty($listing_image)) ? $listing_no_image : $listing_image; ?>"

                                                                    alt="img">

                                                        </a>

                                                        <a href="javascript:void(0)" class="totalCat">

                                                            <?php
                                                            echo (empty($total_images)) ? 'N/A' : $total_images;
                                                            ?>

                                                            <i class="fa fa-camera" aria-hidden="true"></i>

                                                        </a>

                                                    </div>

                                                    <div class="lisViewtCatDetail">

                                                        <ul class="list-unstyled listBread clearfix">


                                                            <li>

                                                                <a href="<?php echo base_url($listing_by_category_single['listing_details']['slug']); ?>">

                                                                    <?php


                                                                    if (isset($listing_by_category_single['listing_details']['category_name']) && $listing_by_category_single['listing_details']['category_name'] !== '') {

                                                                        echo $listing_by_category_single['listing_details']['category_name'];

                                                                    } else {

                                                                        echo "N/A";

                                                                    }

                                                                    ?>

                                                                </a>

                                                            </li>

                                                            <li>

																<span>

																	<?php

                                                                    //print_r($listing_by_category_single['listing_details']);

                                                                    if (isset($listing_by_category_single['listing_details']['subcat_name']) && $listing_by_category_single['listing_details']['subcat_name'] !== '') {

                                                                        echo $listing_by_category_single['listing_details']['subcat_name'];

                                                                    } else {

                                                                        echo "N/A";

                                                                    }

                                                                    ?>

																</span>

                                                            </li>

                                                        </ul>

                                                        <div class="locationNav">

                                                            <a href="javascript:void(0)" class="locationLink">

                                                                <i class="fa fa-map-marker" aria-hidden="true"></i>

                                                                Location: </a>

                                                            <ul class="list-unstyled listBread clearfix">

                                                                <li>

																	<span>

																	<?php


                                                                    if (isset($listing_by_category_single['listing_details']['country_name']) && $listing_by_category_single['listing_details']['country_name'] !== '') {

                                                                        echo $listing_by_category_single['listing_details']['country_name'];

                                                                    } else {

                                                                        echo "N/A";

                                                                    }

                                                                    ?>





																	</span>

                                                                </li>

                                                                <li>

																	<span>

																		<?php


                                                                        if (isset($listing_by_category_single['listing_details']['state_name']) && $listing_by_category_single['listing_details']['state_name'] !== '') {

                                                                            echo $listing_by_category_single['listing_details']['state_name'];

                                                                        } else {

                                                                            echo "N/A";

                                                                        }

                                                                        ?>

																	</span>

                                                                </li>

                                                                <li>

																	<span>

																		<?php


                                                                        if (isset($listing_by_category_single['listing_details']['city_name']) && $listing_by_category_single['listing_details']['city_name'] !== '') {

                                                                            echo $listing_by_category_single['listing_details']['city_name'];

                                                                        } else {

                                                                            echo "N/A";

                                                                        }

                                                                        ?>

																	</span>

                                                                </li>

                                                            </ul>

                                                        </div>

                                                        <ul class="list-unstyled catDetail clearfix">

                                                            <li>

                                                                <span>Make</span>


                                                                <?php


                                                                if (isset($make) && $make !== '') {

                                                                    echo $make;

                                                                    unset($make);

                                                                } else {

                                                                    echo "N/A";

                                                                } ?>


                                                            </li>

                                                            <li>


                                                                <span>Mileage</span>


                                                                <?php if (isset($milage) && $milage !== '') {

                                                                    echo $milage;

                                                                    unset($milage);

                                                                } else {

                                                                    echo "N/A";

                                                                } ?>


                                                            </li>

                                                            <li>

                                                                <span>Year</span>


                                                                <?php if (isset($make_year) && $make_year !== '') {

                                                                    echo $make_year;

                                                                    unset($make_year);

                                                                } else {

                                                                    echo "N/A";

                                                                } ?>


                                                            </li>

                                                            <li>

                                                                <span>Color</span>


                                                                <?php if (isset($color) && $color !== '') {

                                                                    echo $color;

                                                                    unset($color);

                                                                } else {

                                                                    echo "N/A";

                                                                } ?>


                                                            </li>

                                                        </ul>


                                                        <div class="call-to-action-btns">

                                                            <ul class="list-unstyled clearfix catActionBtns">


                                                                <li>

															 <span class="number" data-last="

															 <?php if (isset($phone) && $phone !== '') {

                                                                 echo $phone;

                                                             } else {

                                                                 echo "### ";

                                                             } ?>">

															<span>

																<a target="_blank" class="see"><i class="fa fa-phone"

                                                                                                  aria-hidden="true"></i>

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
                                                                <li>
                                                                    <?php
                                                                    $user_id = volgo_get_logged_in_user_id();
                                                                    $data_listing_slug = $listing_by_category_single['listing_details']['slug'];
                                                                    ?>
                                                                    <a href="<?php echo base_url('flagreports/index/') . $user_id . '/' . $data_listing_slug; ?>"
                                                                       class="reportNow">

                                                                        <i class="fa fa-flag" aria-hidden="true"></i>

                                                                        <span> Report Now </span>

                                                                    </a>

                                                                </li>

                                                                <li class="auto">
                                                                    <a href="<?php
                                                                    $sharelink = base_url() . $listing_by_category_single['listing_details']['slug'];
                                                                    echo base_url() . $listing_by_category_single['listing_details']['slug']; ?>"
                                                                       class="shareNow"> share Now </a>
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

                                                    <a href="javascript:void(0)" class="catTypeSame"></a>

                                                </div>

                                                <ul class="list-unstyled clearfix catActionBtns catActionBtnChange">

                                                    <li>

                                                        <a href="<?php echo base_url($listing_by_category_single['listing_details']['slug']); ?>">

                                                            <i class="fa fa-report-icon" aria-hidden="true"></i>

                                                            Car Report </a>

                                                    </li>

                                                    <li>

													<span> <a
                                                                href="<?php echo base_url($listing_by_category_single['listing_details']['slug']); ?>">Negotiable</a></span>

                                                    </li>

                                                    <?php

                                                    if (isset($warrenty) && $warrenty === 'Yes') { ?>

                                                        <li>

                                                            <span>Warranty</span>

                                                        </li>

                                                    <?php } ?>

                                                </ul>


                                            </div>

                                        </div>
                                        <?php  }

                                    endforeach;

                                    ?>


                            </div>

                        </div>

                    <?php endif; ?>

                </div>

                <div class="pagination-class">


                </div>


                <?php if (isset($links) && !empty($links)): ?>

                    <!-- Pagination -->

                    <div class="paginationHolder">


                        <?php foreach ($links as $link) {

                            echo $link;

                        } ?>


                    </div>

                <?php endif; ?>


                <!-- Featured Ads -->

                <?php include_once realpath(__DIR__ . '/..') . '/includes/listing_featured_adds.php'; ?>


                <!-- Sell Anything Section -->


                <?php include_once realpath(__DIR__ . '/..') . '/includes/listing_selling_anything.php'; ?>


                <!-- Post Free Ad button -->

                <div class="text-center postfreeHolder">

                    <a href="<?php echo base_url('ad-post'); ?>" class="postfreeButton"> post free ad </a>

                </div>

            </div>

            <!-- right side-bar search start -->
            <?php include_once realpath(__DIR__ . '/..') . '/includes/sidebar_filter_listing.php'; ?>
            <!-- right side-bar search end -->

        </div>

    </div>

</section>


<?php include_once realpath(__DIR__ . '/..') . '/includes/footer.php'; ?>



