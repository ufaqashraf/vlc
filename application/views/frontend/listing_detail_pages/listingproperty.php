<?php include_once realpath(__DIR__ . '/..') . '/includes/top_header.php'; ?>
<?php include_once realpath(__DIR__ . '/..') . '/includes/header.php'; ?>

<section class="main-section">
    <?php
    $listing_data = '';
    if (isset($listing_detail['info'][0])) {
        $listing_data = $listing_detail['info'][0];
    } else {
        $listing_data = $listing_detail['info'];
    }

    if ($listing_data->user_since) {
        $date = new DateTime($listing_data->user_since);
        $user_since = date_format($date, "d F Y");
    }

    foreach ($listing_detail['metas'] as $metas) :

        if ($metas->meta_key == 'propertylocation') {
            $propertylocation = $metas->meta_value;
        }
        if ($metas->meta_key == 'phone') {
            $phone = $metas->meta_value;
        }
        if ($metas->meta_key == 'condition') {
            $condition = $metas->meta_value;
        }

        if ($metas->meta_key === 'price') {
            $price = number_format(intval($metas->meta_value));
        }
        if ($metas->meta_key === 'currency_code') {
            $currency_code = $metas->meta_value;
        }
        if ($metas->meta_key === 'listed') {
            $listed = $metas->meta_value;
        }
        if ($metas->meta_key === 'size') {
            $size = $metas->meta_value;
        }
        if ($metas->meta_key === 'rooms') {
            $rooms = $metas->meta_value;
        }
        if ($metas->meta_key === 'bathrooms') {
            $bathrooms = $metas->meta_value;
        }
        if ($metas->meta_key === 'images_from') {
            $images_from = $metas->meta_value;
            $unserialized_images_from = unserialize($images_from);

        }

    endforeach;

    if (isset($listing_data->title) && $listing_data->title !== '') {
        $slug_for_dash = volgo_make_slug($listing_data->title);
    }
    $loged_in_user_id;

    if (!empty($listing_detail['followed_by'][0]->user_id)) {

        $logedinuserfollow = $listing_detail['followed_by'][0]->user_id;
    } else {
        $logedinuserfollow = 0;
    }
    ?>
    <!-- property filter -->
    <?php include_once realpath(__DIR__ . '/..') . '/includes/property_search_filter.php'; ?>
    <style>

.mainking{
    display: flex !important;
    transition-timing-function: ease;

    /* Also the same as */
    transition-timing-function: cubic-bezier(0.25, 0.1, 0.25, 1);
}

</style>
    <div class="container-fluid mainWrapper listingMain">
        <div class="row">
            <div class="col-md-4 col-lg-3 cbg">
                <div class="side-bar-left">
                    <div class="sidebar-priceBox">
                        <p>
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
                        </p>
                        <span class="loc-point"><?php if (isset($listing_data->city_name) && $listing_data->city_name !== '') {
                                echo $listing_data->city_name . ',';
                            } ?>
                            <?php if (isset($listing_data->country_name) && $listing_data->country_name !== '') {
                                echo $listing_data->country_name;
                            } ?></span>


                    </div>
                    <div class="grey-outer-box">
                        <div class="user-box">
                            <?php if (isset($user_img) && $user_img !== '') { ?>
                                <img src="<?php echo UPLOADS_URL . '/user_profile/' . $user_img; ?>"
                                     class="img-thumbnail" alt="tumb">
                            <?php } else { ?>
                                <img src="<?php echo base_url('assets/images/user_thumb1.png'); ?>" alt="tumb">
                            <?php } ?>
                            <ul class="user-info">
                                <li>
                                    <h3><?php
                                        if (isset($listing_data->first_name) && $listing_data->first_name !== '') {
                                            echo ucfirst($listing_data->first_name) . ' ';
                                        }
                                        if (isset($listing_data->last_name) && $listing_data->last_name !== '') {
                                            echo ucfirst($listing_data->last_name);
                                        }
                                        ?></h3>
                                </li>
                                <li class="on"><span> </span>Online</li>
                                <?php if (isset($user_since) && $user_since !== '') { ?>
                                    <li>Member: <?php echo $user_since; ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="chat_box">
                            <button class="btn btn-primary btn-lg shadow-sm btn-chat" type="button" data-toggle="modal" data-target="#myModal">
                                <img src="<?php echo base_url('assets/images/chat.png'); ?>" alt="chat">
                                Chat With Seller
                                <i class="fas fa-chat pl-1"></i>
                            </button>
                            <?php if (isset($chat_validation_errors) && !empty($chat_validation_errors)) : ?>
                                <div class="alert alert-danger">
                                    <p><?php echo $chat_validation_errors; ?></p>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($chat_success_msg) && !empty($chat_success_msg)) : ?>
                                <div class="alert alert-success">
                                    <p><?php echo $chat_success_msg; ?></p>
                                </div>

                            <?php endif; ?>
                            <?php if (!empty($this->session->flashdata('chat_success_msg'))): ?>
                                <div class="alert alert-success">
                                    <div><?php echo $this->session->flashdata('chat_success_msg'); ?></div>
                                </div>
                            <?php endif; ?>
                            <button class="btn btn-primary btn-lg shadow-sm btn-apply" onclick="displayNumber()">
                                <img src="<?php echo base_url() . 'assets/images/mail_box.png'?>" alt="chat">
                                <span class="number"
                                      data-last="<?php if (isset($phone) && $phone !== '') {
                                          echo $phone;
                                      } else {
                                          echo "### ";
                                      } ?>">
                                    <span>
                                        <a target="_blank" class="see">
                                            <span class="cln" >Show Number</span>
                                        </a>
                                    </span>
                                </span>
                            </button>

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

                            if (!empty($listing_follow)) {
                                foreach ($listing_follow as $single_listing) {
                                    $idoflisting[] = $single_listing->meta_value;
                                    $user_follow_id_retrived = $single_listing->user_id;
                                }
                            }
                            if (isset($user_follow_id_retrived)) {
                                $user_follow_id_retrived = $user_follow_id_retrived;
                            } else {
                                $user_follow_id_retrived = "no follow";
                            }

                            if ($user_follow_id_retrived == $user_id):?>
                                <?php
                                if (in_array($listing_data->listing_id, $idoflisting)):

                                    ?>

                                    <a class="btn btn-follow remove_follow_listing" style=""
                                       data-lisitngid="<?php echo $listing_data->listing_id; ?>"
                                       data-user_id="<?php echo $user_id; ?>" href="#" style="...">
                                        <i class="fa fa-spinner"
                                           style="display: none;"></i><i
                                                class="fa fa-chat"
                                                aria-hidden="true"></i>
                                        <span> UNFollow Seller </span>
                                    </a>
                                    <a class="btn btn-follow follow_add_listing"
                                       data-lisitngid="<?php echo $listing_data->listing_id; ?>"
                                       data-user_id="<?php echo $user_id; ?>" href="#" style="display: none">
                                        <i class="fa fa-spinner"
                                           style="display: none;"></i><i
                                                class="fa fa-chat"
                                                aria-hidden="true"></i>
                                        <span> Follow Seller </span>
                                    </a>

                                <?php else: ?>

                                    <a class="btn btn-follow follow_add_listing"
                                       data-lisitngid="<?php echo $listing_data->listing_id; ?>"
                                       data-user_id="<?php echo $user_id; ?>" href="#" style="">
                                        <i class="fa fa-spinner"
                                           style="display: none;"></i><i
                                                class="fa fa-chat"
                                                aria-hidden="true"></i>
                                        <span> Follow Seller </span>
                                    </a>
                                    <a class="btn btn-follow remove_follow_listing" style="display: none"
                                       data-lisitngid="<?php echo $listing_data->listing_id; ?>"
                                       data-user_id="<?php echo $user_id; ?>" href="#" style="">
                                        <i class="fa fa-spinner"
                                           style="display: none;"   ></i><i
                                                class="fa fa-chat"
                                                aria-hidden="true"></i>
                                        <span> UNFollow Seller </span>
                                    </a>
                                <?php endif; ?>
                            <?php else: ?>
                                <a class="btn btn-follow follow_add_listing"
                                   data-lisitngid="<?php echo $listing_data->listing_id; ?>"
                                   data-user_id="<?php echo $user_id; ?>" href="#" style="">
                                    <i class="fa fa-spinner"
                                       style="display: none;"></i><i
                                            class="fa fa-chat"
                                            aria-hidden="true"></i>
                                    <span> Follow Seller </span>
                                </a>
                                <a class="btn btn-follow remove_follow_listing" style="display: none"
                                   data-lisitngid="<?php echo $listing_data->listing_id; ?>"
                                   data-user_id="<?php echo $user_id; ?>" href="#" style="">
                                    <i class="fa fa-spinner"
                                       style="display: none;"></i><i
                                            class="fa fa-chat"
                                            aria-hidden="true"></i>
                                    <span> UNFollow Seller </span>
                                </a>
                            <?php endif; ?>

                        </div>
                    </div>


                    <!-- Buyer Contact form start here -->
                    <div class="modal" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Chat With Seller</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <form method="post" action="<?php echo base_url('Listing/chat_with_seller/' . $listing_detail['info'][0]->user_id . '/' . $listing_detail['info'][0]->slug) ;?>" >
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email: </label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                   aria-describedby="emailHelp" placeholder="Enter Email" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Name: </label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   placeholder="Enter Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Message:</label>
                                            <textarea class="form-control" id="message" name="message" rows="3"
                                                      placeholder="Enter Message here" required></textarea>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-default btn-block snd">Send Now</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="abcMain grey">
                        <div class="contact_form1 collapse clearfix">
                            <!-- https://getbootstrap.com/docs/4.0/components/forms/ -->
                            <?php if (isset($validation_errors) && !empty($validation_errors)) : ?>
                                <div class="alert alert-danger">
                                    <p><?php echo $validation_errors; ?></p>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($success_msg) && !empty($success_msg)) : ?>
                                <div class="alert alert-success">
                                    <p><?php echo $success_msg; ?></p>
                                </div>

                            <?php endif; ?>
                            <?php if (!empty($this->session->flashdata('success_msg'))): ?>
                                <div class="alert alert-success">
                                    <div><?php echo $this->session->flashdata('success_msg'); ?></div>
                                </div>
                            <?php endif; ?>
                            <h5> Send Reply To Buyer</h5>

                            <form method="post" action="<?php echo base_url('Listing/send_reply/' . $listing_detail['info'][0]->user_id . '/' . $listing_detail['info'][0]->slug) ;?>" >
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email: </label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           aria-describedby="emailHelp" placeholder="Enter Email" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputName1">Name: </label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           placeholder="Enter Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Message:</label>
                                    <textarea class="form-control" id="message" name="message" rows="3"
                                              placeholder="Enter Message here" required></textarea>
                                </div>
                                <button type="submit" name="submit" class="btn btn-default btn-block snd">Send Now</button>
                            </form>
                        </div>


                        <div class="text-center">
                            <a href="javascript:void(0)" class="sh" data-toggle="collapse" data-target=".contact_form1">
                                <i class="fa categoryArrowDown" aria-hidden="true"></i>
                            </a>
                            <a href="javascript:void(0)" class="sho" data-toggle="collapse"
                               data-target=".contact_form1">
                                <i class="fa categoryArrowUp" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>


                    <!-- Buyer Contact form start here -->


                    <?php include_once realpath(__DIR__ . '/..') . '/includes/detail_page_social_share_post.php'; ?>

                    <h5>Posted In </h5>

                    <?php
                    $geocode_stats = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=india&sensor=false&key=AIzaSyC3T7l5LWQesjcV3xeeQOTmy3VL1Awko7w");

                    $output_deals = json_decode($geocode_stats);
                    ?>

                    <div class="post_map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2406.2340796678136!2d74.25984527008465!3d31.47114279947925!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3919022c4aea8931%3A0xb0d8d78296b500e4!2sMughal+Eye+Hospital!5e0!3m2!1sen!2s!4v1552559477941"
                                width="265" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                    <?php if (isset($listing_data->listing_id) && !empty($listing_data->listing_id)) { ?>
                        <p>AD ID <?php echo $listing_data->listing_id; ?> </p>
                    <?php } ?>
                    <?php
                    if(!empty($related_listing['info'])): ?>
                        <h5>Related Posts</h5>
                        <ul class="post_rel">
                            <?php
                            foreach ($related_listing['info'] as $single):

                                foreach ($related_listing['metas'] as $current_meta):


                                    foreach ($current_meta as $indiviualmeta):

                                        $check_id_for_related_post = $indiviualmeta->listings_id;

                                        if ($indiviualmeta->meta_key === 'price' && $indiviualmeta->listings_id == $single->id ) {
                                            $price_rel = number_format(intval($indiviualmeta->meta_value));
                                        }

                                        if ($indiviualmeta->meta_key === 'images_from' && $indiviualmeta->listings_id == $single->id) {
                                            $images_from = $indiviualmeta->meta_value;
                                            $unserialized_images_from_related = unserialize($images_from);
                                        }

                                    endforeach;
                                endforeach;
                                ?>
                                <li><a href="<?php echo base_url() . $single->slug;?>"  title="classified"> <img
                                    src="<?php
                                    echo (empty($unserialized_images_from_related[0])) ? volgo_get_no_image_url() : UPLOADS_URL . '/listing_images/' .$unserialized_images_from_related[0];
                                    ?>"
                                    alt="img"/>

                                        <h4> <?php echo $single->title ?> </h4>
                                        <span class="relatedPrice">
                                            <span class="currency-code">
                                                <?php
                                                if(isset($price_rel) && !empty($price_rel)){
                                                echo (!empty($currency_code)) ? strtoupper($currency_code) : strtoupper(B2B_CURRENCY_UNIT); ?>
                                                </span>
                                                <span class="detail-price">
                                                    <?php echo $price_rel;
                                                    }else{
                                                        echo 'N/A';
                                                    }?>
                                                </span>
                                         </span>
                                    </a></li>

                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="col-md-4 col-lg-6">
                <div class="detail-section">
                    <?php if (!empty($this->session->flashdata('flag_success_msg'))): ?>
                        <div class="alert alert-success">
                            <div><?php echo $this->session->flashdata('flag_success_msg'); ?></div>
                        </div>
                    <?php endif; ?>
                    <h1><?php if (isset($listing_data->title) && $listing_data->title !== '') {
                            echo $listing_data->title;
                        } ?></h1>
                    <ul class="list-unstyled listBread clearfix">
                        <?php if (isset($listing_data->country_name) && $listing_data->country_name !== '') { ?>
                            <li>
                                <a href="javascript:void(0)"><?php echo $listing_data->country_name; ?></a>
                            </li>
                        <?php } ?>
                        <?php if (isset($listing_data->category_name) && $listing_data->category_name !== '') { ?>
                            <li>
                                <a href="<?php echo base_url('category/') . $listing_data->category_slug; ?>"><?php echo $listing_data->category_name; ?></a>
                            </li>
                        <?php } ?>
                    </ul>

                    <div class="inner-detailBox">

                        <div id="slider" class="flexslider">
                            <div id="preloder">

                                <div class="loader"></div>
                            </div>
                            <ul class="slides">
                                <?php if((empty($unserialized_images_from))){?>
                                    <li><img src="<?php echo volgo_get_no_image_url(); ?>" alt="img"/></li>
                                <?php }else{ foreach ((array)$unserialized_images_from as $key => $value): ?>
                                        <li><img src="<?php echo (empty($value)) ? volgo_get_no_image_url() : UPLOADS_URL . '/listing_images/' . $value; ?>" alt="img"/></li>
                                <?php  endforeach; } ?>
                            </ul>
                        </div>

                        <div id="carousel" class="flexslider">
                            <ul class="slides">
                                <?php if((empty($unserialized_images_from))){?>
                                    <li><img src="<?php echo volgo_get_no_image_url(); ?>" alt="img"/></li>
                                <?php }else{ foreach ((array)$unserialized_images_from as $key => $value): ?>
                                    <li><img src="<?php echo (empty($value)) ? volgo_get_no_image_url() : UPLOADS_URL . '/listing_images/' . $value; ?>" alt="img"/></li>
                                <?php  endforeach; } ?>
                            </ul>
                        </div>

                        <div class="call-to-action-btns">
                            <ul class="list-unstyled clearfix catActionBtns">
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
                                            $user_fav_id_retrived = $single_listing->user_id;
                                        }
                                    }
                                    if (isset($user_fav_id_retrived)) {
                                        $user_fav_id_retrived = $user_fav_id_retrived;
                                    } else {
                                        $user_fav_id_retrived = "no fav";
                                    }

                                    if ($user_fav_id_retrived == $user_id):?>
                                        <?php
                                        if (in_array($listing_data->listing_id, $idoflisting)):

                                            ?>

                                            <a class="saveNow remove_fav_listing"
                                               data-lisitngid="<?php echo $listing_data->listing_id; ?>"
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
                                               data-lisitngid="<?php echo $listing_data->listing_id; ?>"
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
                                               data-lisitngid="<?php echo $listing_data->listing_id; ?>"
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
                                               data-lisitngid="<?php echo $listing_data->listing_id; ?>"
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
                                           data-lisitngid="<?php echo $listing_data->listing_id; ?>"
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
                                           data-lisitngid="<?php echo $listing_data->listing_id; ?>"
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
                                    ?>
                                    <a href="<?php echo base_url('flagreports/index/') . $user_id . '/' . volgo_make_slug($listing_data->title); ?>"
                                       class="reportNow">
                                        <i class="fa fa-flag" aria-hidden="true"></i>
                                        <span> Report AD </span>
                                    </a>
                                </li>


                            </ul>
                        </div>
                        <div class="detailAd-section">

                            <h3>Details</h3>

                            <ul class="adListing">
                                <li>
                                    <div class="innerBox">

                                        <div class="circleBox"><span class="calnder-icon">calnder</span></div>
                                        <div class="adInfo">
                                            <h4>Posted Date</h4>
                                            <p>N/A</p>
                                        </div>

                                    </div>
                                </li>

                                <li>
                                    <div class="innerBox">

                                        <div class="circleBox"><span class="bed-icon">Bedrooms</span></div>
                                        <div class="adInfo">
                                            <h4>Bedrooms</h4>
                                            <p><?php if (isset($rooms) && $rooms !== '') {
                                                    echo $rooms;
                                                } else {
                                                    echo 'N/A';
                                                } ?></p>
                                        </div>

                                    </div>
                                </li>

                                <li>
                                    <div class="innerBox">

                                        <div class="circleBox"><span class="bath-icon">Bathrooms</span></div>
                                        <div class="adInfo">
                                            <h4>Bathrooms</h4>
                                            <p><?php if (isset($bathrooms) && $bathrooms !== '') {
                                                    echo $bathrooms;
                                                } else {
                                                    echo 'N/A';
                                                } ?></p>
                                        </div>

                                    </div>
                                </li>

                                <li>
                                    <div class="innerBox">

                                        <div class="circleBox"><span class="scale-icon">Size</span></div>
                                        <div class="adInfo">
                                            <h4>Size</h4>
                                            <p><?php if (isset($size) && $size !== '') {
                                                    echo $size;
                                                } else {
                                                    echo 'N/A';
                                                } ?></p>
                                        </div>

                                    </div>
                                </li>

                                <li>
                                    <div class="innerBox">

                                        <div class="circleBox"><span class="price-icon">Price</span></div>
                                        <div class="adInfo">
                                            <h4>Price / sqft</h4>
                                            <p><?php if (isset($price) && $price !== '') {
                                                    echo $price . ' ' . $currency_code;
                                                } else {
                                                    echo 'N/A';
                                                } ?></p>
                                        </div>

                                    </div>
                                </li>

                                <li>
                                    <div class="innerBox">

                                        <div class="circleBox"><span class="time-icon">Rental</span></div>
                                        <div class="adInfo">
                                            <h4>Rental period</h4>
                                            <p>N/A</p>
                                        </div>

                                    </div>
                                </li>

                                <li>
                                    <div class="innerBox">

                                        <div class="circleBox"><span class="clock-icon">Age</span></div>
                                        <div class="adInfo">
                                            <h4>Age</h4>
                                            <p>N/A</p>
                                        </div>

                                    </div>
                                </li>

                                <li>
                                    <div class="innerBox">

                                        <div class="circleBox"><span class="hotel-icon">Floor</span></div>
                                        <div class="adInfo">
                                            <h4>Floor</h4>
                                            <p>N/A</p>
                                        </div>

                                    </div>
                                </li>
                            </ul>


                        </div>


                        <div class="descriptionSection">
                            <h3>Description</h3>
                            <ul>
                                <li><?php if (isset($listing_data->description) && $listing_data->description !== '') {
                                        echo $listing_data->description;
                                    } ?></li>
                            </ul>
                        </div>


                    </div>
                    <div class="page-pagination">
                        <?php

                        if (!empty($next_previous_listing)):
                            $counter = 0;
                            foreach ($next_previous_listing as $single):
                                if ($counter === 0) {
                                    $class = 'left-page';
                                    $arrow_class = 'arrow-left';
                                    $text_class = 'Previous Post';
                                    $arrow_text = 'left';
                                } else {
                                    $class = 'right-page';
                                    $arrow_class = 'arrow-right';
                                    $text_class = 'Next Post';
                                    $arrow_text = 'right';
                                }

                                ?>

                                <div class="<?php echo $class; ?>">
                                    <p class="tp-1"><a href="<?php echo base_url() . $single->slug ?>"><i
                                                    class="<?php echo $arrow_class; ?>"><?php echo $arrow_text; ?></i> <?php echo $text_class; ?>
                                        </a></p>
                                    <p>
                                        <a href="<?php echo base_url() . $single->slug ?>"><?php echo $single->title ?></a>
                                    </p>
                                </div>
                                <?php
                                $counter++;
                            endforeach;
                        endif;

                        ?>
                    </div>

                    <!--                    --><?php //include_once realpath(__DIR__ . '/..') . '/includes/detail_page_comments.php'; ?>

                </div>
            </div>

            <?php include_once realpath(__DIR__ . '/..') . '/includes/property_sidebar.php'; ?>
        </div>
    </div>
</section>

<?php include_once realpath(__DIR__ . '/..') . '/includes/footer.php'; ?>

