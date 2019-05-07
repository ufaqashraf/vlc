    <?php if (isset($listing_by_cat_recommended) && !empty($listing_by_cat_recommended)) : ?>
        <div class="gridViewCat">
            <div class="row">


                <?php


                $count = 0;

                foreach ($listing_by_cat_recommended as $listing_by_category_single):
                    $listing_image = volgo_get_no_image_url();
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


                            $total_iamges = count($unserialized_image);

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
                                <img src="<?php echo UPLOADS_URL . '/listing_images/' . $listing_image; ?>"
                                     class="img-fluid">
                                <span class="catFilter"></span>
                            </a>
                            <a href="javascript:void(0)" class="promotedStack">Premium</a>
                            <a href="javascript:void(0)" class="totalCat">
                                <?php
                                if (isset($total_iamges) && $total_iamges !== '') {
                                    echo $total_iamges;
                                    //	unset($total_iamges);
                                } else {
                                    echo 'N/A';
                                }
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
                    $listing_image = volgo_get_no_image_url();
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
                            $room = number_format($singlemeta['meta_value']);
                        }
                        if ($singlemeta['meta_key'] == 'bathrooms') {
                            $bathroom = number_format($singlemeta['meta_value']);
                        }
                        if ($singlemeta['meta_key'] == 'size') {
                            $size = number_format(intval($singlemeta['meta_value']));
                        }

                        if ($singlemeta['meta_key'] == 'images_from') {

                            $singleimage = $singlemeta['meta_value'];

                            $unserialized_image = unserialize($singleimage);


                            $total_iamges = count($unserialized_image);

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
                                        <img src="<?php echo $listing_image; ?>" alt="Car">
                                    </a>
                                    <a href="javascript:void(0)" class="totalCat">
                                        <?php
                                        if (isset($total_iamges) && $total_iamges !== '') {
                                            echo $total_iamges;
                                            //unset($total_iamges);
                                        } else {
                                            echo 'N/A';
                                        }
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
                                                <ul class="socials-icons">
                                                    <li class="faceb">
                                                        <a class="share_fb_item"
                                                           data-url="<?php echo $sharelink; ?>" href="
                                                                                #" data-title="<?php echo $share_title; ?>"><i class="fa fa-facebook"></i> </a></li>
                                                    <li class="twt"><a

                                                                class="share_tw_item"
                                                                data-url="<?php echo $sharelink; ?>"
                                                                href="#" data-title="<?php echo $share_title; ?>"><i class="fa fa-twitter"></i> </a>
                                                    </li>

                                                    <li class="yot"><a

                                                                class="share_pt_item"
                                                                data-url="<?php echo $sharelink; ?>"
                                                                href="#" data-title="<?php echo $share_title; ?>"><i class="fa fa-pinterest "></i>
                                                        </a></li>
                                                    <?php unset($sharelink); ?>
                                                    <?php unset($share_title); ?>

                                                </ul>
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
<div class="pagination-class"></div>