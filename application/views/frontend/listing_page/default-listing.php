<?php include_once realpath(__DIR__ . '/..') . '/includes/top_header.php'; ?>
<?php include_once realpath(__DIR__ . '/..') . '/includes/header.php'; ?>

<section class="main-section">

	<div class="container-fluid mainWrapper listingMain default_listing">
		<div class="row">
			<div class="col-md-8 col-lg-9">
				<div class="row sellerHolder">
					<div class="col-md-8">
						<span class="adTitle"><?php echo $total_add ?> Ads for Selling in
                        <?php
						$country_name = volgo_get_user_location();
						echo $country_name['country_name'];
						?>
                        </span>
						<em class="adTitleSub">Change country from Top Menu to See Ads of different countries.</em>


					</div>
					<div class="col-md-4 searchBtnsAction">
						<!--						<ul class="saveSearch list-unstyled ">-->
						<ul class="saveBtn list-unstyled ">
							<li>
								<?php
								//                                $user_id = volgo_get_logged_in_user_id();

								//                                if (isset($user_id)) {
								//                                    $user_id = $user_id;
								//                                } else {
								//                                    $user_id = 0;
								//                                }
								//                                ?>
								<!---->
								<!--                                --><?php
								//                                $idoflisting = [];
								//
								//                                if (!empty($listing_save_search)) {
								//                                    foreach ($listing_save_search as $single_listing) {
								//                                        print_r($single_listing);
								//                                        exit;
								//                                        $idoflisting[] = $single_listing->meta_value;
								//                                        $user_id_retrived = $single_listing->user_id;
								//                                    }
								//                                }
								//                                if (isset($user_id_retrived)) {
								//                                    $user_id_retrived = $user_id_retrived;
								//                                } else {
								//                                    $user_id_retrived = "no fav search";
								//                                }
								//
								//
								//                                if ($user_id_retrived == $user_id):?>
								<!--                                --><?php //else: ?>
								<!--                                    <a class="saveNow save_search_add"-->
								<!--                                       data-user_id="--><?php //echo $user_id; ?><!--" href="#"-->
								<!--                                       style="" >-->
								<!--                                        <i class="fa fa-spinner"-->
								<!--                                           style="display: none"></i><i-->
								<!--                                                class="fa fa-heart"-->
								<!--                                                aria-hidden="true"></i>-->
								<!--                                        <span> Save Search </span>-->
								<!--                                    </a>-->
								<!--                                    <a class="saveNow remove_save_search_add"-->
								<!--                                       data-user_id="--><?php //echo $user_id; ?><!--" href="#"-->
								<!--                                       style="display: none;">-->
								<!--                                        <i class="fa fa-spinner"-->
								<!--                                           style="display: none"></i><i-->
								<!--                                                class="fa fa-heartbeat-o"-->
								<!--                                                aria-hidden="true"></i>-->
								<!--                                        <span> Save Search </span>-->
								<!--                                    </a>-->
							<li>
								<a class="saveIt save_search_history" id="save_search_history"
								   data-user_id="<?php if(isset($user_id)){ echo $user_id;} ?>" >
									<i class="fa fa-spinner paddindIt" style="display: none;"></i>
									<i class="fa fa-heart-o" aria-hidden="true"></i>
									<span id="saveSpan">Save</span>

								</a>
								<a class="removesrch hide" id="removesrch"
								   data-user_id="<?php if(isset($user_id)){ echo $user_id;} ?>">
									<i class="fa fa-spinner paddindIt" style="display: none;"></i>
									<i class="fa fa-heart-o" aria-hidden="true"></i>
									<span id="removeSpan">Remove</span>

								</a>
							</li>
							<!--                            --><?php //endif; ?>
							</li>
						</ul>
					</div>
				</div>
				<div class="stackHolder tags bgGrey">
					<a href="#" class="adImageLeft" target="_blank">
						<img src="<?php echo base_url('assets/images/adImg1.jpg'); ?>" alt="banner-Image">
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
									<?php if (!empty($cat_name)): ?>


										<li>
                    <span href="javascript:void(0)"><?php echo $cat_name; ?>
                      <i class="fa faClose-icon" aria-hidden="true"></i>
                    </span>
										</li>
									<?php endif; ?>
								</ul>
							</div>
						</div>
						<div class="col-md-5 col-lg-4 pr-sm-0 pl-lg-5">
							<div class="bestSeller-field">
								<span class="sortBy">Sort by:</span>
								<select class="form-control">
                                    <option>--Select--</option>
                                    <option>Newest to Oldest</option>
                                    <option>Oldest to Newest</option>
                                    <option>Price Highest to Lowest</option>
                                    <option>Price Lowest to Highest</option>
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

				<?php

				if (isset($listing_by_cat_featured['result'])) {
					echo '<div class="stackHolder nothingFound">
                    <div class="holder">
                    <span class="nothingFound-title">
                      <em class="exclamation-icon"></em>  
                      No listing Found !
                    </span> 
                    <span class="empty-result-title">Sorry we didn\'t find any results for \'keyword\' within Your Search</span>
                      <span class="tipsSearch"> Tips for your search</span>
                      <ul class="list-unstyled emptyList-help">
                        <li>Check the spelling of your keywords for mistakes</li>
                        <li>Try using less or more general keywords</li>
                        <li> Try browsing the categories</li>
                      </ul>
                  </div>
                  </div>';
				}

				if (isset($listing_by_cat_featured) && !empty($listing_by_cat_featured)) : ?>

					<div class="listViewCat">
						<div class="row">


							<?php
							////////////////// this is for full widht listing display php ///////////////////////
							?>

							<?php
							$count = 0;

                                foreach ($listing_by_cat_featured as $listing_by_category_single):

								$listing_image = volgo_get_no_image_url();
								if (isset($listing_by_category_single['metas'])):
									foreach ($listing_by_category_single['metas'] as $singlemeta):

										if ($singlemeta['meta_key'] == 'listing_type') {
											$listing_type = $singlemeta['meta_value'];

										}


										if ($singlemeta['meta_key'] == 'price' && !empty($singlemeta['meta_value'])) {
											$price = number_format(intval($singlemeta['meta_value']));
										}

										if ($singlemeta['meta_key'] === 'currency_code') {
											$currency_code = $singlemeta['meta_value'];
										}

										$milage = '';
										if ($singlemeta['meta_key'] == 'kilometer' && !empty($singlemeta['meta_value'])) {
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


											$total_images = count($unserialized_image);

											if (isset($unserialized_image[0]))
												$listing_image = UPLOADS_URL . '/listing_images/' . $unserialized_image[0];

										}
										if ($singlemeta['meta_key'] == 'make') {
											$make = $singlemeta['meta_value'];
										}
										if ($singlemeta['meta_key'] == 'year') {
											$make_year = $singlemeta['meta_value'];
										}
										if ($singlemeta['meta_key'] == 'color') {
											$color = $singlemeta['meta_value'];
										}
										if ($singlemeta['meta_key'] == 'warranty') {
											$warrenty = $singlemeta['meta_value'];
										}
										if ($singlemeta['meta_key'] == 'phone') {
											$phone = $singlemeta['meta_value'];
										}

									endforeach;
								endif;

								if (isset($listing_by_category_single['listing_details'])) :

									?>

									<?php $listing_by_category_single['listing_details'] ?>
									<div class="col-md-12">
										<div class="holder">
											<a href="javascript:void(0)" class="promotedStack">
												<?php
												if (isset($listing_type) && $listing_type !== '') {
													echo $listing_type;
													unset($listing_type);
												} else {
													echo 'N/A';
												} ?>

											</a>
											<div class="row mb-2">
												<div class="col-sm-9">
													<a href="<?php
													$sharelink = base_url() . $listing_by_category_single['listing_details']['slug'];
													$share_title = $listing_by_category_single['listing_details']['title'];
													echo base_url() . $listing_by_category_single['listing_details']['slug']; ?>"
													   class="listViewLink">
														<?php if (isset($listing_by_category_single['listing_details']['title']) && $listing_by_category_single['listing_details']['title'] !== '') {
															echo $listing_by_category_single['listing_details']['title'];
															unset($listing_by_category_single['listing_details']['title']);
														} else {
															echo 'N/A';
														} ?>
													</a>
													<span
														class="listViewDate">
													<?php $date = new DateTime($listing_by_category_single['listing_details']['created_at']);
													$date = date_format($date, "M Y");
													if (isset($date) && $date !== '') {
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
												</div>
											</div>
											<div class="lisViewtCatHolder clearfix">
												<div class="lisViewtCatCol">
													<a href="javascript:void(0)" class="lisViewtCatLink">
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
															<a href="javascript:void(0)">Search</a>
														</li>
														<li>
															<a href="javascript:void(0)">
																<?php

																if (isset($listing_by_category_single['listing_details']['parent_category']) && $listing_by_category_single['listing_details']['parent_category'] !== '') {
																	echo $listing_by_category_single['listing_details']['parent_category'];
																	unset($listing_by_category_single['listing_details']['parent_category']);
																} else {
																	echo 'N/A';
																}
																?>
															</a>
														</li>
														<li>
															<span>
																<?php

																if (isset($listing_by_category_single['listing_details']['sub_category']) && $listing_by_category_single['listing_details']['sub_category'] !== '') {
																	echo $listing_by_category_single['listing_details']['sub_category'];
																	unset($listing_by_category_single['listing_details']['sub_category']);
																} else {
																	echo 'N/A';
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

																if (isset($listing_by_category_single['listing_details']['country']) && $listing_by_category_single['listing_details']['country'] !== '') {
																	echo $listing_by_category_single['listing_details']['country'];
																	unset($listing_by_category_single['listing_details']['country']);
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
																		unset($listing_by_category_single['listing_details']['state_name']);
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
																		unset($listing_by_category_single['listing_details']['city_name']);
																	} else {
																		echo 'N/A';
																	}
																	?>
																</span>
															</li>
														</ul>
													</div>
													<ul class="list-unstyled catDetail clearfix">
														<li>
															<?php
															if (isset($listing_by_category_single['listing_details']['listing_description']) && $listing_by_category_single['listing_details']['listing_description'] !== '') {
																echo "Description :<p class='description_search'>  " . strip_tags(substr($listing_by_category_single['listing_details']['listing_description'], 0, 150)) . "</p>";
																unset($listing_by_category_single['listing_details']['listing_description']);
															}

															?>
														</li>
													</ul>

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

																	if (in_array($listing_by_category_single['listing_details']['listing_id'], $idoflisting)):

																		?>

																		<a class="saveNow remove_fav_listing"
																		   data-lisitngid="<?php echo $listing_by_category_single['listing_details']['listing_id'] ?>"
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
																		   data-lisitngid="<?php echo $listing_by_category_single['listing_details']['listing_id'] ?>"
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
																		   data-lisitngid="<?php echo $listing_by_category_single['listing_details']['listing_id'] ?>"
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
																		   data-lisitngid="<?php echo $listing_by_category_single['listing_details']['listing_id'] ?>"
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
																	   data-lisitngid="<?php echo $listing_by_category_single['listing_details']['listing_id'] ?>"
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
																	   data-lisitngid="<?php echo $listing_by_category_single['listing_details']['listing_id'] ?>"
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
																echo base_url() . $listing_by_category_single['listing_details']['slug']; ?>"
																   class="shareNow"> share
																	Now </a>

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

										</div>
									</div>

								<?php
								endif;
							endforeach; ?>

						</div>
					</div>

				<?php

				endif;


				?>

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
			<!-- testing -->

				<?php include_once realpath(__DIR__ . '/..') . '/includes/sidebar_filter_listing.php'; ?>

		</div>
	</div>
</section>


<?php include_once realpath(__DIR__ . '/..') . '/includes/footer.php'; ?>
<script>

//	$(".save_search").click(function (e) {
//		e.preventDefault();
//		var $this = $(this);
//		$this.find(".fa-heart-o").hide();
//		$this.find(".fa-spinner").show();
//
//		var listing_id = $this.data('lisitngid'); //getter
//		var userid = $this.data("user_id");
//
//		$.ajax({/* THEN THE AJAX CALL */
//			type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
//			dataType: "json",
//			url: "<?php //echo base_url('dashboard/remove_search_fav_add'); ?>//", /* PAGE WHERE WE WILL PASS THE DATA */
//			data: {listing_id: listing_id, userid: userid}, /* THE DATA WE WILL BE PASSING */
//
//			success: function (result) { /* GET THE TO BE RETURNED DATA */
//				console.log(result);
//
//
//				if (result == 'search_fav_removed') {
//
//
//					$this.find(".fa-spinner").hide();
//					$this.find(".fa-heart-o").show();
//					$this.siblings().show();
//					$this.hide();
//
//				}
//
//
//			}
//		});
//	});

</script>
