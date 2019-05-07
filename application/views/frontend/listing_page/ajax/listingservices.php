    <?php if (isset($featured_listings, $featured_listings[0]) && !empty($featured_listings)) : ?>
        <div class="listViewCat">
        <div class="row">


        <?php
        ////////////////// this is for full widht listing display php ///////////////////////
        ?>

        <?php
        $count = 0;


        foreach ($listing_by_cat_featured

                 as $listing_by_category_single):
            $listing_image = volgo_get_no_image_url();
            foreach ($listing_by_category_single['metas'] as $singlemeta):

                if ($singlemeta['meta_key'] == 'listing_type') {
                    $listing_type = $singlemeta['meta_value'];

                }
                if ($singlemeta['meta_key'] == 'price') {
                    $price = number_format(intval($singlemeta['meta_value']));
                }
                if ($singlemeta['meta_key'] == 'mileage') {
                    $milage = number_format(intval($singlemeta['meta_value']));
                }
                if ($singlemeta['meta_key'] == 'date') {
                    $date = $singlemeta['meta_value'];
                    $date = new DateTime($date);
                    $date = date_format($date, "d M Y");
                }
                if ($singlemeta['meta_key'] == 'images_from') {

                    $singleimage = $singlemeta['meta_value'];

                    $unserialized_image = unserialize($singleimage);


                    $total_iamges = count($unserialized_image);

                    if (isset($unserialized_image[0]))
                        $listing_image = UPLOADS_URL . '/listing_images/' . $unserialized_image[0];

                }
                if ($singlemeta['meta_key'] == 'productage') {
                    $productage = $singlemeta['meta_value'];
                }
                if ($singlemeta['meta_key'] == 'usage') {
                    $usage = $singlemeta['meta_value'];
                }
                if ($singlemeta['meta_key'] == 'condition') {
                    $condition = $singlemeta['meta_value'];
                }
                if ($singlemeta['meta_key'] == 'phone') {
                    $phone = $singlemeta['meta_value'];
                }

            endforeach;

            ?>
            </div>
            </div>

            <div class="listViewCat classifiedPage">
            <div class="row">
            <!-- List View Column -->


            <!-- List View Column -->
            <div class="col-md-12">

                <div class="holder">
                    <div class="lisViewtJobHolder searchViewHolder clearfix">
                        <a href="javascript:void(0)" class="promotedStack">
                            <?php
                            if (isset($listing_type) && $listing_type !== '') {
                                echo $listing_type;
                                unset($listing_type);
                            } else {
                                echo 'N/A';
                            } ?></a>
                        <div class="jobViewcatCol">
                            <a href="<?php $sharelink = base_url() . $listing_by_category_single['listing_details']['slug'];
                            $share_title = $listing_by_category_single['listing_details']['title'];
                            echo base_url() . $listing_by_category_single['listing_details']['slug'];?>"
                               class="jobViewLink">
                                <img
                                        src="<?php echo $listing_image; ?>"
                                        alt="job">
                            </a>
                        </div>
                        <div class="jobViewtCatDetail">
                            <a href="<?php if (isset($sharelink) && $sharelink !== '') {
                                echo $sharelink;
                            }; ?>" class="jobLink">
                                <?php if (isset($listing_by_category_single['listing_details']['title'])) {
                                    echo $listing_by_category_single['listing_details']['title'];
                                    unset($listing_by_category_single['listing_details']['title']);
                                } ?>
                            </a>
                            <span class="searchDateTitle">
											<?php $date = new DateTime($listing_by_category_single['listing_details']['created_at']);
                                            $date = date_format($date, "d M Y");
                                            if (isset($date)) {
                                                echo $date;
                                                unset($date);
                                            } else {
                                                echo 'N/A';
                                            } ?>

										</span>
                            <ul class="list-unstyled listBread clearfix searchlistBread">
                                <li>
                                    <a href="<?php echo base_url('category/') . strtolower($listing_by_category_single['listing_details']['category_name']); ?>">
                                        <?php

                                        if (isset($listing_by_category_single['listing_details']['category_name']) && $listing_by_category_single['listing_details']['category_name'] !== '') {
                                            echo $listing_by_category_single['listing_details']['category_name'];
                                        } else {
                                            echo 'N/A';
                                        }
                                        ?>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <?php

                                        if (isset($listing_by_category_single['listing_details']['subcat_name']) && $listing_by_category_single['listing_details']['subcat_name'] !== '') {
                                            echo $listing_by_category_single['listing_details']['subcat_name'];
                                        } else {
                                            echo 'N/A';
                                        }
                                        ?></a>
                                </li>

                            </ul>
                            <div class="locationNav">
                                <a class="locationLink">
                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                    Location: </a>
                                <ul class="list-unstyled listBread clearfix">
                                    <li>
													<span>
															<?php

                                                            if (isset($listing_by_category_single['listing_details']['country_name']) && $listing_by_category_single['listing_details']['country_name'] !== '') {
                                                                echo $listing_by_category_single['listing_details']['country_name'];
                                                            } else {
                                                                echo 'N/A';
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
                                                            echo 'N/A';
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
                                                                echo 'N/A';
                                                            }
                                                            ?>
													</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="call-to-action-btns">
                                <ul class="list-unstyled clearfix catActionBtns">
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
                                    <li>
                                        <?php
                                        $user_id = volgo_get_logged_in_user_id();
                                        $data_listing_slug = $listing_by_category_single['listing_details']['slug'];
                                        ?>
                                        <a href="<?php echo base_url('flagreports/index/') . $user_id . '/' . $data_listing_slug; ?>" class="reportNow">
                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                            <span>Report Now</span>
                                        </a>
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
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
        </div>
    <?php endif; ?>
<div class="pagination-class"></div>