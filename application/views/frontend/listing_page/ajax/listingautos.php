<?php if ( isset($recommended_listings, $recommended_listings[0]) && !empty($recommended_listings)) : ?>

	<div class="gridViewCat">
		<div class="row">
			<?php

			$count = 0;



			foreach ((array) $recommended_listings as $recommended_listing):

				if (! is_array($recommended_listing))
					continue;

				$listing_image = volgo_get_no_image_url();

				foreach ((array) $recommended_listing['metas'] as $singlemeta):


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
							$total_iamges = count($unserialized_image);
						else
							$total_iamges = "";

						if (isset($unserialized_image[0]))
							$listing_image = UPLOADS_URL . '/listing_images/' . $unserialized_image[0];

					}

				endforeach;

				?>

				<div class="col-md-4">
					<div class="holder">
						<a href="<?php echo base_url($recommended_listing['listing_details']['slug']); ?>"
						   class="catLink">
							<img
								src="<?php echo $listing_image; ?>"
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

							if (isset($total_iamges) && !empty($total_iamges)) {

								echo $total_iamges;

								//	unset($total_iamges);

							} else {

								echo "N/A";

							}

							?>

							<i class="fa fa-camera" aria-hidden="true"></i>

						</a>

						<div class="catImgInfo">

							<a href="<?php echo base_url($recommended_listing['listing_details']['slug']); ?>">

								<?php if (isset($recommended_listing['listing_details']['title']) && $recommended_listing['listing_details']['title'] !== '') {

									echo $recommended_listing['listing_details']['title'];

									unset($recommended_listing['listing_details']['title']);

								} else {

									echo "N/A";

								} ?></a>

							<span class="priceTag">
                                                <span class="currency-code">
                                                    <?php echo (!empty($currency_code)) ? strtoupper($currency_code) : strtoupper(B2B_CURRENCY_UNIT); ?>
                                                </span>
                                                <span class="detail-price">
                                                    <?php echo (!empty($price)) ? ($price) : 'N/A'; ?>
                                                </span>
                                            </span>

							<?php $date = new DateTime($recommended_listing['listing_details']['created_at']);

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

							<a href="javascript:void(0)" class="catTypeSame">

								<!--											<img-->

								<!--												src="-->

								<?php //echo base_url('assets/images/catBottom-icon.png');

								?><!--"-->

								<!--												alt="image">-->

							</a>

						</div>

					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

<?php endif; ?>

<?php if (isset($featured_listings, $featured_listings[0]) && !empty($featured_listings)) : ?>

	<div class="listViewCat">

		<div class="row">


			<?php

			////////////////// this is for full widht listing display php ///////////////////////

			?>



			<?php

			$count = 0;

			foreach ($featured_listings as $featured_listing):

             $contry_id = $featured_listing['listing_details']['country_id'];

				if (! is_array($featured_listing))
					continue;

				$listing_image = volgo_get_no_image_url();

				foreach ((array) $featured_listing['metas'] as $singlemeta):

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
							$total_iamges = count($unserialized_image);
							$listing_image = isset($unserialized_image[0]) ? $unserialized_image[0] : '';
							$listing_image = UPLOADS_URL . '/listing_images/' . ($listing_image);
						} else
							$listing_image = volgo_get_no_image_url();
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

								<a href="<?php echo $link_currnet = base_url($featured_listing['listing_details']['slug']); ?>"

								   class="listViewLink">

									<?php if (isset($featured_listing['listing_details']['title']) && $featured_listing['listing_details']['title'] !== '') {

										echo $featured_listing['listing_details']['title'];

										$slugs = $featured_listing['listing_details']['title'];

										unset($featured_listing['listing_details']['title']);

									} ?>

								</a>

								<span

									class="listViewDate">

													<?php $date = new DateTime($featured_listing['listing_details']['created_at']);

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
                                                        <?php echo (!empty($currency_code)) ? strtoupper($currency_code) : strtoupper(B2B_CURRENCY_UNIT); ?>
                                                    </span>
                                                    <span class="detail-price">
                                                        <?php echo (!empty($price)) ? ($price) : 'N/A'; ?>
                                                    </span>
                                                 </span>
							</div>

						</div>

						<div class="lisViewtCatHolder clearfix">

							<div class="lisViewtCatCol">

								<a href="<?php if (isset($link_currnet) && $link_currnet !== '') {

									echo $link_currnet;

								} else {

									echo "#";

								} ?>" class="lisViewtCatLink">

									<img

										src="<?php echo $listing_image; ?>"

										alt="Car">

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

								<ul class="list-unstyled listBread clearfix">


									<li>

										<a href="<?php echo base_url($featured_listing['listing_details']['slug']); ?>">

											<?php

											if (isset($featured_listing['listing_details']['parent_category']) && $featured_listing['listing_details']['parent_category'] !== '') {

												echo $featured_listing['listing_details']['parent_category'];

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

																if (isset($featured_listing['listing_details']['sub_category']) && $featured_listing['listing_details']['sub_category'] !== '') {

																	echo $featured_listing['listing_details']['sub_category'];

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


																if (isset(volgo_get_country_name_by_id($contry_id)->name) && volgo_get_country_name_by_id($contry_id)->name !== '') {

																	echo volgo_get_country_name_by_id($contry_id)->name;

																} else {

																	echo "N/A";

																}

																?>





																</span>

										</li>

										<li>

																<span>

																	<?php


																	if (isset($featured_listing['listing_details']['state_name']) && $featured_listing['listing_details']['state_name'] !== '') {

																		echo $featured_listing['listing_details']['state_name'];

																	} else {

																		echo "N/A";

																	}

																	?>

																</span>

										</li>

										<li>

																<span>

																	<?php


																	if (isset($featured_listing['listing_details']['city_name']) && $featured_listing['listing_details']['city_name'] !== '') {

																		echo $featured_listing['listing_details']['city_name'];

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

											$listing_id = $featured_listing['listing_details']['listing_id'];

											if (!empty($loged_in_user_id)) {

												if (!empty($listing_fav)) {

													$idoffav = [];


													foreach ($listing_fav as $single_listing) {

														$idoffav[] = $single_listing->meta_value;

													}

													if (in_array($listing_id, $idoffav)) {

														?>

														<a href="<?php echo base_url('Dashboard/remove_search_fav_add/') . $listing_id . '/' . uri_string(); ?>"

														   class="saveNow">

															<i class="fa fa-heart"

															   aria-hidden="true"></i>

															<span> Remove Favourite </span>

														</a>

														<?php

													} else {

														?>


														<a href="<?php echo base_url('Dashboard/search_fav_add/') . $featured_listing['listing_details']['listing_id'] . '/' . uri_string(); ?>"

														   class="saveNow">

															<i class="fa fa-heart"

															   aria-hidden="true"></i>

															<span> Favourite </span>

														</a>


														<?php

													}

												} else {

													?>

													<a href="<?php echo base_url('Dashboard/search_fav_add/') . $featured_listing['listing_details']['listing_id'] . '/' . uri_string(); ?>"

													   class="saveNow">

														<i class="fa fa-heart"

														   aria-hidden="true"></i>

														<span> Favourite </span>

													</a>


													<?php

												}

											} else {

												?>

												<a href="<?php echo base_url('Dashboard/search_fav_add/') . $featured_listing['listing_details']['listing_id'] . '/' . uri_string(); ?>"

												   class="saveNow">

													<i class="fa fa-heart"

													   aria-hidden="true"></i>

													<span> Favourite </span>

												</a>


												<?php


											}

											?>


										</li>


										<li>
											<?php
											$user_id = volgo_get_logged_in_user_id();
											$data_listing_id = $featured_listing['listing_details']['listing_id'];
											?>
											<a href="<?php echo base_url('flagreports/index/') . $user_id . '/' . $data_listing_id; ?>"
											   class="reportNow">

												<i class="fa fa-flag" aria-hidden="true"></i>

												<span> Report Now </span>

											</a>

										</li>

										<li class="auto">

											<a href="<?php if (isset($link_currnet) && $link_currnet !== '') {

												echo $link_currnet;

											} else {

												echo "#";

											} ?>" class="shareNow"> share

												Now </a>

										</li>

									</ul>

								</div>


							</div>

							<a href="javascript:void(0)" class="catTypeSame">

								<!--											<img-->

								<!--												src="-->

								<?php //echo base_url('assets/images/catBottom-icon.png');

								?><!--"-->

								<!--												alt="image">-->

							</a>

						</div>

						<ul class="list-unstyled clearfix catActionBtns catActionBtnChange">

							<li>

								<a href="javascript:void(0)">

									<i class="fa fa-report-icon" aria-hidden="true"></i>

									Car Report </a>

							</li>

							<li>

								<span>Negotiable</span>

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


			<?php


			endforeach; ?>


		</div>

	</div>

<?php endif; ?>

<div class="pagination-class"></div>


