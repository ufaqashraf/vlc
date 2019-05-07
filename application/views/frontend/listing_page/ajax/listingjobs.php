    <?php if (isset($featured_listings, $featured_listings[0]) && !empty($featured_listings)) : ?>
        <div class="listViewCat jobListing">

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

                        if ($singlemeta['meta_key'] == 'jobtype') {

                            $jobtype = $singlemeta['meta_value'];

                        }


                        if ($singlemeta['meta_key'] == 'minimumexperience') {

                            $minimumexperience = $singlemeta['meta_value'];

                        }


                        if ($singlemeta['meta_key'] == 'salary') {

                            $salary = $singlemeta['meta_value'];

                        }

                        if ($singlemeta['meta_key'] == 'companyname') {

                            $company_name = $singlemeta['meta_value'];

                        }

                        if ($singlemeta['meta_key'] == 'phone') {

                            $phone = $singlemeta['meta_value'];

                        }


                        if ($singlemeta['meta_key'] == 'date') {

                            $date = $singlemeta['meta_value'];

                            $date = new DateTime($date);

                            $date = date_format($date, "M Y");

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


                    <!-- List View Column -->

                    <div class="col-md-12">

                        <div class="holder">

								<span class="jobDuration-tag"> <?php

                                    if (isset($jobtype) && $jobtype !== '') {
                                        echo $jobtype;
                                        unset($jobtype);
                                    } else {
                                        echo 'N/A';
                                    }

                                    ?> </span>

                            <div class="lisViewtJobHolder clearfix">
                                <div class="jobViewcatCol">
                                    <a href="<?php $sharelink = base_url() . $listing_by_category_single['listing_details']['slug'];
                                    $share_title = $listing_by_category_single['listing_details']['title'];
                                    echo base_url() . $listing_by_category_single['listing_details']['slug'];?>"
                                       class="jobViewLink">

                                        <img
                                                src="<?php echo $listing_image; ?>"
                                                alt="Car" class="img-fluid">
                                    </a>


                                    <a href="#" class="featuredAdLink"> <?php

                                        if (isset($listing_type) && $listing_type !== '') {
                                            echo $listing_type;
                                            unset($listing_type);
                                        } else {
                                            echo 'N/A';
                                        } ?> </a>

                                </div>

                                <div class="jobViewtCatDetail">

                                    <a href="<?php if (isset($sharelink) && $sharelink !== '') {
                                        echo $sharelink;
                                    } ?>"
                                       class="jobLink">

                                        <?php if (isset($listing_by_category_single['listing_details']['title']) && $listing_by_category_single['listing_details']['title'] !== '') {

                                            echo $listing_by_category_single['listing_details']['title'];

                                            unset($listing_by_category_single['listing_details']['title']);

                                        } else {
                                            echo 'N/A';
                                        } ?>

                                    </a>

                                    <ul class="jobsNav list-unstyled">

                                        <li>

												<span class="tilt">

														<?php if (isset($company_name) && $company_name !== '') {

                                                            echo $company_name;

                                                            unset($company_name);

                                                        } else {
                                                            echo 'N/A';
                                                        } ?>

												</span>

                                        </li>

                                        <li>

												<span class="blue-icon">

												  <i class="fa fa-map-marker" aria-hidden="true"></i>
												  Located :
                                                    <?php
                                                    if (isset($listing_by_category_single['listing_details']['country_name']) && $listing_by_category_single['listing_details']['country_name'] !== '') {
                                                        echo $listing_by_category_single['listing_details']['country_name'];
                                                        unset($listing_by_category_single['listing_details']['country_name']);

                                                    } else {
                                                        echo 'N/A';
                                                    } ?>
													,
												<?php
                                                if (isset($listing_by_category_single['listing_details']['city_name']) && $listing_by_category_single['listing_details']['city_name'] !== '') {
                                                    echo $listing_by_category_single['listing_details']['city_name'];
                                                    unset($listing_by_category_single['listing_details']['city_name']);
                                                } else {
                                                    echo 'N/A';
                                                } ?>
												</span>

                                        </li>

                                    </ul>

                                    <ul class="jobsNav list-unstyled fontSize14">
                                        <li>
                                            <a>
                                                <i class="fa faCalendar" aria-hidden="true"></i>
                                                Published
                                                <?php $date = new DateTime($listing_by_category_single['listing_details']['created_at']);
                                                $date = date_format($date, "M d, Y");
                                                if (isset($date)) {
                                                    echo $date;
                                                    unset($date);

                                                } else {
                                                    echo 'N/A';
                                                } ?>

                                            </a>
                                        </li>

                                        <li>
                                            <a>
                                                <i class="fa faExperience" aria-hidden="true"></i>
                                                <?php if (isset($minimumexperience) && $minimumexperience !== '') {
                                                    echo 'Experience ' . $minimumexperience;
                                                    unset($minimumexperience);
                                                } else {
                                                    echo 'N/A';
                                                } ?>
                                            </a>
                                        </li>

                                        <li>
                                            <a>
                                                <i class="fa faMoney" aria-hidden="true"></i>
                                                <?php if (isset($salary) && $salary !== '') {
                                                    echo $salary;
                                                    unset($salary);
                                                } else {
                                                    echo 'N/A';
                                                } ?>
                                            </a>

                                        </li>

                                    </ul>

                                    <div class="call-to-action-btns">

                                        <ul class="list-unstyled clearfix catActionBtns">

                                            <li>

                                                <a href="javascript:void(0)" class="reportNow">

                                                    <i class="fa fa-flag" aria-hidden="true"></i>


                                                    <span>Apply now</span>

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

                            </div>

                        </div>

                    </div>
                <?php


                endforeach;

                ?>

            </div>
        </div>
    <?php endif; ?>
<div class="pagination-class"></div>