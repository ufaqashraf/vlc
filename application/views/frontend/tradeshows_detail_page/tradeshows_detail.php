<?php include_once realpath(__DIR__ . '/..') . '/includes/top_header.php'; ?>
<?php include_once realpath(__DIR__ . '/..') . '/includes/header.php'; ?>

<section class="main-section">

    <?php
    foreach ($tradeshow_detail as $data) :
        foreach ($data['meta_info'] as $metas) :


        if ($metas['meta_key'] === 'ts_venue') {
            $venue = $metas['meta_value'];
        }
        if ($metas['meta_key'] === 'starting_date') {
            $date = new DateTime($metas['meta_value']);
            $starting_date = date_format($date, "F d, Y");
        }
        if ($metas['meta_key'] === 'ending_date') {
            $date = new DateTime($metas['meta_value']);
            $ending_date = date_format($date, "F d, Y");
        }

        endforeach;
    endforeach;

    ?>



    <div class="container-fluid mainWrapper listingMain">
        <div class="row">
            <div class="col-md-4 col-lg-3 cbg">
                <div class="side-bar-left">

                    <div class="trade-show job-trade">
                        <img class="img-ad img-responsive" src="<?php echo base_url('assets/images/adpost.png')?>" alt="img">
                            <?php if (!empty($related_tradeshows['info'])): ?>
                             <h5>Recent Trade Shows</h5>
                                <?php
                                foreach ($related_tradeshows['info'] as $single):

                                    foreach ($related_tradeshows['metas'] as $current_meta):

                                        foreach ($current_meta as $indiviualmeta):

                                            $check_id_for_related_post = $indiviualmeta->post_id;

                                            if ($indiviualmeta->meta_key === 'ts_venue' && $indiviualmeta->post_id == $single->id) {
                                                $venue_rel = $indiviualmeta->meta_value;
                                            }

                                            if ($indiviualmeta->meta_key === 'starting_date' && $indiviualmeta->post_id == $single->id) {
                                                $date = new DateTime($indiviualmeta->meta_value);
                                                $starting_date_rel = date_format($date, "d M Y");
                                            }

                                            if ($indiviualmeta->meta_key === 'ending_date' && $indiviualmeta->post_id == $single->id) {
                                                $date = new DateTime($indiviualmeta->meta_value);
                                                $ending_date_rel = date_format($date, "d M Y");
                                            }

                                        endforeach;
                                    endforeach;
                                    ?>
                        <div class="col-sm-12 spacing">
                            <div class="item-box">
                                <div class="position-relative d-flex">
                                    <div class="text-uppercase purple event-date">
                                        <?php
                                        if(isset($starting_date_rel) && $starting_date_rel !== ''){
                                            echo $starting_date_rel;
                                        }else{
                                            echo 'N/A';
                                        }
                                        ?>
                                    </div>
                                    <div class="home-img">
                                        <a href="<?php echo base_url('/tradeshow/') . $single->slug;?>">
                                            <img src="<?php echo (empty($single->featured_image)) ? volgo_get_no_image_url() : UPLOADS_URL . '/tradeshows/' . unserialize($single->featured_image); ?>" alt="img"></a>
                                    </div>
                                </div>
                                <div class="content">
                                    <h1 class="title"><a href="<?php echo base_url('/tradeshow/') . $single->slug;?>">
                                            <?php
                                            if(isset($single->title) && $single->title !== ''){
                                                echo $single->title;
                                            }else{
                                                echo 'N/A';
                                            }
                                            ?>
                                        </a></h1>
                                    <div class="date-venue">
                                        <span class="date">End Date: </span><span>
                                            <?php
                                            if(isset($ending_date_rel) && $ending_date_rel !== ''){
                                                echo $ending_date_rel;
                                            }else{
                                                echo 'N/A';
                                            }
                                            ?>
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php endforeach; endif; ?>
                    </div>

                    <?php include_once realpath(__DIR__ . '/..') . '/includes/detail_page_social_share_post.php'; ?>

                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="col-md-4 col-lg-6">
                <div class="detail-section">
                    <h1><?php echo $data['post_info']['title'];?></h1>
                    <div class="inner-detailBox">
                        <div class="single_box">
                            <img src="<?php echo (empty($data['post_info']['featured_image'])) ? volgo_get_no_image_url() : UPLOADS_URL . '/tradeshows/' . volgo_maybe_unserialize($data['post_info']['featured_image']); ?>" alt="img">
                        </div>

                        <div class="tradeshow-detail detailAd-section mt-2">

                            <h3>Details</h3>

                            <ul class="adListing add-trades" id="adListing">
                                <li>
                                    <div class="innerBox">

                                        <div class="circleBox"><span class="calnder-icon">START DATE</span></div>
                                        <div class="adInfo">
                                            <h4>START DATE</h4>
                                            <?php if (isset($starting_date) && $starting_date !== ''){ ?>
                                            <p><?php echo $starting_date; ?></p>
                                            <?php }else{
                                                echo 'N/A';
                                            }?>
                                        </div>

                                    </div>
                                </li>

                                <li>
                                    <div class="innerBox">

                                        <div class="circleBox"><span class="timetable-icon">END DATE</span></div>
                                        <div class="adInfo">
                                            <h4>END DATE</h4>
                                            <?php if (isset($ending_date) && $ending_date !== ''){ ?>
                                                <p><?php echo $ending_date; ?></p>
                                            <?php }else{
                                                echo 'N/A';
                                            }?>
                                        </div>

                                    </div>
                                </li>
                                <li>
                                    <div class="innerBox">

                                        <div class="circleBox venue-circle"><span class="venue-icon">Victory Club </span></div>
                                        <div class="adInfo">
                                            <h4>VENUE</h4>
                                            <?php if (isset($venue) && $venue !== ''){ ?>
                                                <p><?php echo $venue; ?></p>
                                            <?php }else{
                                                echo 'N/A';
                                            }?>
                                        </div>

                                    </div>
                                </li>
                            </ul>

                        </div>

                        <div class="descriptionSection venus">
                            <h3>Description</h3>
                            <ul>
                                <li><?php echo $data['post_info']['content'];?></li>
                            </ul>
                        </div>


                    </div>
                    <div class="page-pagination">
                        <?php

                        if(!empty($next_previous_trade)):
                            $counter = 0;
                            foreach ($next_previous_trade as $single):
                                if($counter === 0) {
                                    $class = 'left-page';
                                    $arrow_class = 'arrow-left';
                                    $text_class = 'Previous Post';
                                    $arrow_text = 'left';
                                }else {
                                    $class = 'right-page';
                                    $arrow_class = 'arrow-right';
                                    $text_class = 'Next Post';
                                    $arrow_text = 'right';
                                }

                                ?>

                                <div class="<?php echo $class; ?>">
                                    <p class="tp-1"><a href="<?php echo base_url('tradeshow/') . $single->slug ?>"><i class="<?php echo $arrow_class; ?>"><?php echo $arrow_text; ?></i> <?php echo $text_class; ?></a></p>
                                    <p><a href="<?php echo base_url('tradeshow/') . $single->slug ?>"><?php echo $single->title?></a></p>
                                </div>
                                <?php
                                $counter ++;
                            endforeach;
                        endif;

                        ?>
                    </div>

<!--                    --><?php //include_once realpath(__DIR__ . '/..') . '/includes/detail_page_comments.php'; ?>

                </div>
            </div>

            <?php include_once realpath(__DIR__ . '/..') . '/includes/sidebar_filter_listing.php'; ?>

        </div>
    </div>
</section>

<?php include_once realpath(__DIR__ . '/..') . '/includes/footer.php'; ?>

