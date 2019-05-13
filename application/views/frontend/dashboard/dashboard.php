﻿<?php include_once realpath(__DIR__ . '/..') . '/includes/top_header.php'; ?>
<?php include_once realpath(__DIR__ . '/..') . '/includes/header.php'; ?>

<style>
	.date_pick {
		width: 100%;

	}

	.card.hovercard {

		width: 100%;

	}


</style>

<div class="main-section" style="background: #f2f2f2">
	<div class="container-fluid mainWrapper listingMain">
		<div class="row">
			<!-- tabs -->

			<?php if (!empty($this->session->flashdata('validation_errors'))): ?>
				<div class="alert alert-success">
					<div><?php echo $this->session->flashdata('validation_errors'); ?></div>
				</div>
			<?php endif; ?>
			<?php if (!empty($this->session->flashdata('success_msg'))): ?>
				<div class="alert alert-success">
					<div><?php echo $this->session->flashdata('success_msg'); ?></div>
				</div>
			<?php endif; ?>
			<div class="tabbable tabs-left">

				<div class="well">

					<div class="row">
						<div class="col-md-4 col-sm-12 col-xs-12 cv-form2">
							<div class="profile-card">
								<div class="img-usr">
									<a href="#" class="thumbnail">
										<img src="<?php echo base_url('assets/images/img-user.png'); ?>" alt=""></a>
								</div>
								<?php

								foreach ($user_detail

								as $single_detail): ?>
								<div class="col-md-12" style="padding-left: 0">
									<h2><?php echo ucwords($single_detail->firstname) . ' ' . ucwords($single_detail->lastname); ?></h2>
									<small>Free Membership</small>
									<h3><i class="fa fa-calendar"></i><b style="font-size: 14px;">Member Since:</b>
										<span style="color: #cbddf5">
										<?php
										$date = new DateTime($single_detail->created_at);
										$date = date_format($date, "d M Y");
										if (isset($date)) {
											echo $date;
										}
										?>
										</span>
									</h3>
									<a href="#"><i class="fa fa-link" style="transform: rotate(90deg);"></i> <span>copy link </span></a>
								</div>
							</div>

							<ul class="nav nav-tabs tabs-lt">
								<li class="active"><a href="#profile" data-toggle="tab"><img
											src="<?php echo base_url('assets/images/img1.png'); ?>" alt=""> My
										Profile</a></li>
								<li><a href="#myads" data-toggle="tab"><img
											src="<?php echo base_url('assets/images/img2.png'); ?>" alt=""> My Ads</a>
								</li>
								<li><a href="#favourite_ads" data-toggle="tab"><img
											src="<?php echo base_url('assets/images/img3.png'); ?>" alt=""> My favourite
										ads</a></li>
								<li><a href="#saved_searches" data-toggle="tab"><img
											src="<?php echo base_url('assets/images/img4.png'); ?>" alt=""> saved
										searches</a></li>
								<li><a href="<?php echo base_url('payment-plans') ?>"><img
											src="<?php echo base_url('assets/images/img5.png'); ?>" alt=""> Upgrade
										Membership</a></li>
								<li><a href="#followers" data-toggle="tab"><img
											src="<?php echo base_url('assets/images/img6.png'); ?>" alt="">Followers</a>
								</li>
								<li><a href="#following" data-toggle="tab"><img
											src="<?php echo base_url('assets/images/img7.png'); ?>" alt="">
										following</a></li>
								<li><a href="#settings" data-toggle="tab"><img
											src="<?php echo base_url('assets/images/img8.png'); ?>" alt=""> account
										settings</a></li>
								<li><a href="<?php echo base_url('users/logout'); ?>"><img
											src="<?php echo base_url('assets/images/img9.png'); ?>" alt=""> logout</a>
								</li>

							</ul>
						</div>


						<div class="col-md-8 col-sm-12 col-xs-12 cv-form1" style="background: #fff;">

							<div class="tab-content">
								<span
									class="wel">Wellcome <i><?php echo ucwords($single_detail->firstname) . ' ' . ucwords($single_detail->lastname); ?></i> to Volgo Point</span>
								<div id="profile" class="tab-pane fade in active">
									<form action="<?php echo base_url('dashboard/insert'); ?>" method="POST"
										  enctype="multipart/form-data">
										<div class="cv-form">

											<div class="col-md-12 padding-lr">


												<div class="row">
													<div class="col-md-6 col-sm-6 col-xs-12">

														<div class="form-group">
															<label>First Name</label>
															<input type="text"
																   value="<?php echo ucwords($single_detail->firstname); ?>"
																   class="text_label form-control"
																   name="firstname" contenteditable="true">


														</div>
														<div class="form-group">
															<label>Last Name</label>
															<input type="text"
																   value="<?php echo ucwords($single_detail->lastname); ?>"
																   class="text_label form-control "
																   name="lastname" contenteditable="true">


														</div>
														<?php foreach ($user_meta_detail as $metas):

															if ($metas->meta_key == 'nationality') {
																$nationality = $metas->meta_value;
															}
															if ($metas->meta_key == 'states') {
																$states_ret = $metas->meta_value;
															}
															if ($metas->meta_key == 'careerlevel') {
																$carrerlevel = $metas->meta_value;
															}
															if ($metas->meta_key == 'currentposition') {
																$current_positon = $metas->meta_value;
															}
															if ($metas->meta_key == 'salaryexpectations') {
																$sal_exp = $metas->meta_value;
															}
															if ($metas->meta_key == 'noticeperiod') {
																$notice_per = $metas->meta_value;
															}
															if ($metas->meta_key == 'gender') {
																$gender = $metas->meta_value;
															}
															if ($metas->meta_key == 'currentlocation') {
																$current_location = $metas->meta_value;
															}
															if ($metas->meta_key == 'currentcompany') {
																$current_compny = $metas->meta_value;
															}
															if ($metas->meta_key == 'commitment') {
																$commitment = $metas->meta_value;
															}
															if ($metas->meta_key == 'dateofbirth') {
																$dateofbirth = $metas->meta_value;
															}
															if ($metas->meta_key == 'hightstdegree') {
																$hightstdegree = $metas->meta_value;
															}
															if ($metas->meta_key == 'user_cv') {
																$user_cv = $metas->meta_value;
															}
															if ($metas->meta_key == 'summeryofcv') {
																$sum_cv = $metas->meta_value;
															}

														endforeach; ?>


														<div class="form-group">
															<label>Nationality</label>
															<select class="form-control counrty_selec"
																	name="nationality">
																<option>Choose Country</option>
																<?php
																foreach ($all_country as $single_country) :
																	?>

																	<option value='<?php echo $single_country->id ?>'
																		<?php
																		if (isset($nationality)) {
																			if ($single_country->id == $nationality) {
																				echo "selected='selected'";
																			}
																		}
																		?>
																		>
																		<?php echo $single_country->name ?>
																	</option>
																	<?php
																endforeach;
																?>
															</select>
														</div>

														<div class="form-group">
															<label>State</label>
															<select class="form-control state_selected" name="states">
																<?php

																if (isset($states_ret)) {
																	foreach ($states as $signle_state) {

																		?>
																		<option
																			value="<?php echo $signle_state->id ?>" <?php if ($states_ret == $signle_state->id) {
																			echo "selected='selected'";
																		} ?> >
																			<?php echo $signle_state->name; ?>
																		</option>
																		<?php

																	}
																}
																?>


															</select>
														</div>
														<div class="form-group">
															<label>Career Level</label>
															<select class="form-control" name="careerlevel">
																<?php if (isset($carrerlevel)) {
																	$carrerlevel = $carrerlevel;
																} else {
																	$carrerlevel = "0";
																} ?>
																<option
																	value="Experince" <?php if ($carrerlevel == 'Experince') {
																	echo "selected='selected'";
																} ?>>Experienced
																</option>
																<option
																	value="Mid level" <?php if ($carrerlevel == 'Mid level') {
																	echo "selected='selected'";
																} ?>>Mid Level
																</option>
																<option
																	value="Internee" <?php if ($carrerlevel == 'Internee') {
																	echo "selected='selected'";
																} ?>>Internee
																</option>
															</select>
														</div>
														<div class="form-group">
															<label>Current Position</label>
															<select class="form-control" name="currentposition">
																<?php if (isset($current_positon)) {
																	$current_positon = $current_positon;
																} else {
																	$current_positon = "0";
																} ?>
																<option
																	value="Web Developer" <?php if ($current_positon == 'Web Developer') {
																	echo "selected='selected'";
																} ?> >Web developer
																</option>
																<option
																	value="Web Desginer" <?php if ($current_positon == 'Web Desginer') {
																	echo "selected='selected'";
																} ?> >Web designer
																</option>
																<option
																	value="Graphic Desginer" <?php if ($current_positon == 'Graphic Desginer') {
																	echo "selected='selected'";
																} ?> >Graphic Designer
																</option>
															</select>
														</div>
														<div class="form-group">
															<label>Salary Expectations</label>
															<select class="form-control" name="salaryexpectations">
																<?php if (isset($sal_exp)) {
																	$sal_exp = $sal_exp;
																} else {
																	$sal_exp = "0";
																} ?>
																<option
																	value="20,000-30,000" <?php if ($sal_exp == '20,000-30,000') {
																	echo "selected='selected'";
																} ?> >20,000-30,000
																</option>
																<option
																	value="30,000-35,000" <?php if ($sal_exp == '30,000-35,000') {
																	echo "selected='selected'";
																} ?>>30,000-35,000
																</option>
																<option
																	value="35,000-40,000" <?php if ($sal_exp == '35,000-40,000') {
																	echo "selected='selected'";
																} ?>>35,000-40,000
																</option>
																<option
																	value="40,000-50,000" <?php if ($sal_exp == '40,000-50,000') {
																	echo "selected='selected'";
																} ?>>40,000-50,000
																</option>
															</select>
														</div>

														<div class="form-group">
															<label>Notice Period</label>
															<select class="form-control" name="noticeperiod">
																<?php if (isset($notice_per)) {
																	$notice_per = $notice_per;
																} else {
																	$notice_per = "0";
																} ?>
																<option value="none" <?php if ($notice_per == 'none') {
																	echo "selected='selected'";
																} ?>>None
																</option>
																<option
																	value="2 months" <?php if ($notice_per == '2 months') {
																	echo "selected='selected'";
																} ?>>2 Months
																</option>
																<option
																	value="1 month" <?php if ($notice_per == '1 month') {
																	echo "selected='selected'";
																} ?>>1 Month
																</option>
																<option
																	value="15 days" <?php if ($notice_per == '15 days') {
																	echo "selected='selected'";
																} ?>>15 days
																</option>

															</select>
														</div>

													</div>
													<div class="col-md-6 col-sm-6 col-xs-12">
														<h4>Gender</h4>
														<select class="form-control" name="gender">
															<?php if (isset($gender)) {
																$gender = $gender;
															} else {
																$gender = "0";
															} ?>
															<option value="male" <?php if ($gender == 'male') {
																echo "selected='selected'";
															} ?>>Male
															</option>
															<option value="female" <?php if ($gender == 'female') {
																echo "selected='selected'";
															} ?>>Female
															</option>
														</select>

														<div class="form-group dtob" style="margin-top:12px;">
															<label>Date of Birth</label>

															<div class="dob">

																<input type="date" id="" placeholder="dd/mm/yyy"
																	   class="date_pick form-control" name="dateofbirth"
																	   value="<?php if (isset($dateofbirth)) {
																		   echo $dateofbirth;
																	   } ?>">

															</div>
														</div>

														<div class="form-group">
															<label>Current location</label>
															<select class="form-control city_selected"
																	name="currentlocation">
																<?php
																if (isset($current_location)) {
																	foreach ($city as $single_city) {

																		?>
																		<option
																			value="<?php echo $single_city->id ?>" <?php if ($current_location == $single_city->id) {
																			echo "selected='selected'";
																		} ?> >
																			<?php echo $single_city->name; ?>
																		</option>
																		<?php

																	}
																}
																?>
															</select>
														</div>

														<div class="form-group">
															<label>Current Company</label>
															<input type="text" placeholder="current compnay"
																   class="form-control" name="currentcompany"
																   value="<?php if (isset($current_compny)) {
																	   echo $current_compny;
																   } ?>">
														</div>
														<div class="form-group">
															<label>Commitment</label>
															<select class="form-control" name="commitment">
																<?php if (isset($commitment)) {
																	$commitment = $commitment;
																} else {
																	$commitment = "0";
																} ?>
																<option
																	value="Full time" <?php if ($commitment == 'Full time') {
																	echo "selected='selected'";
																} ?>>Full Time
																</option>
																<option
																	value="Part Time" <?php if ($commitment == 'Part Time') {
																	echo "selected='selected'";
																} ?>>Part Time
																</option>
																<option
																	value="Contract" <?php if ($commitment == 'Contract') {
																	echo "selected='selected'";
																} ?>>Contract
																</option>
															</select>
														</div>
														<div class="form-group">
															<label>Highest Degree</label>
															<select class="form-control" name="hightstdegree">
																<?php if (isset($hightstdegree)) {
																	$hightstdegree = $hightstdegree;
																} else {
																	$hightstdegree = "0";
																} ?>
																<option
																	value="Masters" <?php if ($hightstdegree == 'Masters') {
																	echo "selected='selected'";
																} ?>>Masters
																</option>
																<option
																	value="bachlors" <?php if ($hightstdegree == 'bachlors') {
																	echo "selected='selected'";
																} ?>>Bachlors
																</option>
																<option
																	value="Intermediate" <?php if ($hightstdegree == 'Intermediate') {
																	echo "selected='selected'";
																} ?>>Intermediate
																</option>
															</select>
														</div>
													</div>
												</div>

											</div>
											<div class="your-c">
												<div class="col-md-12 row" style="margin: 0;">
													<h4 class="">Your CV</h4>
													<p>Your latest CV was uploaded some time ago.Your possible future
														employer would like to know
														all about the hard work you've done up until today. To stay
														current,
														please update and
														upload
														your latest CV. Good luck!</p>

													<input id="file-upload" type="file" name="cv">
													<br>
													<?php if (isset($user_cv)): ?>
														<div style="display: block; width: 100%;">Current CV</div>

														<a href="<?php echo base_url('/uploads/cv/') . $user_cv; ?>"><?php echo $user_cv; ?></a></h4>
													<?php endif; ?>

												</div>

												<div class="col-md-12">
													<div class="form-group">
														<label for="comment" class="mt-1 summ">Your CV Summary</label>
														<textarea name="summeryofcv" class="form-control" rows="5"
																  id="comment"
																  placeholder="Write the summary of the latest years of your career."><?php if (isset($sum_cv)) {
																echo $sum_cv;
															} ?></textarea>
														<button type="submit" class="btn btn-default to-up mt-3">Update
															Profile
														</button>
													</div>
												</div>
											</div>
										</div>

									</form>
								</div>
								<div id="myads" class="tab-pane fade">


									<div class="container">

										<div class="adds">

											<h4 class="">Your Ads list</h4>


											<?php
											if ($user_adds != "nolisitng"):
												foreach ($user_adds

														 as $single_listing): ?>
													<?php

													if (is_array($single_listing['metas']) && (!empty($single_listing['metas']))) {
														foreach ($single_listing['metas'] as $metas_fetch) {


															if ($metas_fetch->meta_key == 'images_from') {
																$singleimage = $metas_fetch->meta_value;
																$unserialized_image = unserialize($singleimage);
																$total_iamges = count($unserialized_image);
																$listing_image = $unserialized_image[0];
															}else{
																$listing_image = volgo_get_no_image_url();
															}

															if ($metas_fetch->meta_key == 'price') {
																$price = $metas_fetch->meta_value;
															}
															if ($metas_fetch->meta_key == 'currency_code') {
																$currnecy_code = $metas_fetch->meta_value;
															}
															if ($metas_fetch->meta_key == 'phone') {
																$phone = $metas_fetch->meta_value;
															}


														}
													}
													?>

													<div class="maindiv">
														<div class="col-md-12">
															<div class="holder sec-holder">
																<div class="lisViewtCatHolder fvt-add clearfix">


																	<div
																		class="lisViewtCatCol col-md-4 col-sm-6 col-xs-12">
																		<a href="#" class="lisViewtCatLink">
																			<img src="<?php
																			echo UPLOADS_URL . '/listing_images/' . $listing_image;
																			?>" alt="Car">
																		</a>
																		<a href="javascript:void(0)" class="totalCat">

																			<?php if (isset($total_iamges)) {
																				echo $total_iamges;

																			} ?>

																			<i class="fa fa-camera"
																			   aria-hidden="true"></i>
																		</a>
																	</div>
																	<div
																		class="lisViewtCatDetail col-md-8 col-sm-12 col-xs-12 myads">
																		<div class="row">
																			<h4 class="col-md-8 col-sm-6 col-xs-12">
																				<a href="<?php

																				if (isset($single_listing['title'])) {
																					echo base_url() . volgo_make_slug($single_listing['title']);
																				}

																				?>">
																					<?php if (isset($single_listing['title'])) {
																						echo $single_listing['title'];
																					} ?>
																				</a>
																			</h4>

																		</div>
																		<p class="text-muted">
																			<?php if (isset($single_listing['city_name'])) {
																				echo $single_listing['city_name'];
																			} ?>
																			,
																			<?php if (isset($single_listing['state_name'])) {
																				echo $single_listing['state_name'];
																			} ?>
																			,
																			<?php if (isset($single_listing['country_name'])) {
																				echo $single_listing['country_name'];
																			} ?>

																		</p>
																		<ul class="list-unstyled listBread clearfix">
																			<li>
																				<a href="
																				<?php if (isset($single_listing['cat_name'])) {
																					echo base_url('category/' . volgo_make_slug($single_listing['cat_name']));
																				} ?>
																			">
																					<?php if (isset($single_listing['cat_name'])) {
																						echo $single_listing['cat_name'];
																					} ?>

																				</a>
																			</li>
																			<li>
																				<a href="<?php if (isset($single_listing['sub_cat_name'])) {
																					echo base_url('category/' . volgo_make_slug($single_listing['sub_cat_name']));
																				} ?>">

																					<?php if (isset($single_listing['sub_cat_name'])) {
																						echo $single_listing['sub_cat_name'];
																					} ?>
																				</a>
																			</li>

																		</ul>
																		<h5 class="col-md-4 col-sm-6 col-xs-12 text-right">
																			<?php if (isset($price)) {
																				echo number_format(intval($price));

																			} ?>
																			<span>
																		<?php if (isset($currnecy_code)) {
																			echo $currnecy_code;

																		} ?>
																	</span></h5>

																	</div>
																</div>
															</div>
															<div class="status-bar">
																<ul class="status">
																	<li>Status : <span
																			style="color: #e2574c">
																	<?php
																	if (isset($single_listing['status'])) {

																		echo $single_listing['status'];
																	}

																	?>
																	</span></li>
																	<li style="font-weight: normal"><i
																			class="fa fa-calendar"></i>
																		<?php


																		if (isset($single_listing['created_at'])) {

																			$date = new DateTime($single_listing['created_at']);
																			$date = date_format($date, "d M Y");


																			echo $date;
																		}

																		?>
																	</li>
																</ul>

																<div class="edit1">
																	<ul class="pull-right">
																		<li><a href="#"><span>Edit</span> <i
																					class="fa fa-edit"></i></a>
																		</li>
																		<li><a href="<?php

																			if (isset($single_listing['title'])) {
																				echo base_url() . volgo_make_slug($single_listing['title']);
																			}

																			?>"><span>Share</span> <i
																					class="fa fa-share-alt"></i></a>
																		</li>
																		<li class="delete"><a href="<?php

																			if (isset($single_listing['id'])) {
																				echo base_url('Dashboard/del_listing/') . $single_listing['id'];
																			}

																			?>"><span>Delete</span>
																				<i
																					class="fa fa-trash"></i></a></li>
																	</ul>
																</div>
															</div>

														</div>
													</div>

													<?php
												endforeach;
											else:
												echo "No add Posted Yet";
											endif;
											?>


										</div>

									</div>
								</div>
								<div id="favourite_ads" class="tab-pane fade">

									<div class="col-md-12">

										<div class="adds">
											<h4 class="pull-left">Your Favourite ADs List</h4>

											<div class="pull-right">

												<!--												<span class="pull-left mr-2">select Catgory</span>-->
												<!--												<div class="form-group pull-left" style="width: 120px">-->
												<!--													<select class="form-control select_cat_dash">-->
												<!--														<option value=''>---Select category---</option>-->
												<!--														--><?php //foreach ($all_cats as $single_cat): ?>
												<!---->
												<!--															<option-->
												<!--																value="-->
												<?php //echo $single_cat->id; ?><!--">-->
												<?php //echo $single_cat->name; ?><!--</option>-->
												<!---->
												<!--														--><?php //endforeach; ?>
												<!--													</select>-->
												<!--												</div>-->
											</div>
										</div>
									</div>
									<div class="spinner-loader-wrapper" style="display: none;">
										<div class="spinner-loader fa fa-spinner fa-spin fa-2x fa-fw"></div>
									</div>
									<?php

									if ($fav_adds != "nolisitng"):
										foreach ($fav_adds as $single_listing): ?>
											<?php

											if (is_array($single_listing['metas']) && (!empty($single_listing['metas']))) {
												foreach ($single_listing['metas'] as $metas_fetch) {


													if ($metas_fetch->meta_key == 'images_from') {
														$singleimage = $metas_fetch->meta_value;
														$unserialized_image = unserialize($singleimage);
														$total_iamges = count($unserialized_image);
														$listing_image = $unserialized_image[0];
													}

													if ($metas_fetch->meta_key == 'price') {
														$price = $metas_fetch->meta_value;
													}
													if ($metas_fetch->meta_key == 'currency_code') {
														$currnecy_code = $metas_fetch->meta_value;
													}
													if ($metas_fetch->meta_key == 'phone') {
														$phone = $metas_fetch->meta_value;
													}


												}
											}
											?>

											<div class="maindiv">
												<div class="col-md-12">
													<div class="holder sec-holder">
														<div class="lisViewtCatHolder fvt-add clearfix">


															<div class="lisViewtCatCol col-md-4 col-sm-6 col-xs-12">
																<a href="#" class="lisViewtCatLink">
																	<img src="<?php
																	echo UPLOADS_URL . '/listing_images/' . $listing_image;
																	?>" alt="Car">
																</a>
																<a href="javascript:void(0)" class="totalCat">

																	<?php if (isset($total_iamges)) {
																		echo $total_iamges;

																	} ?>

																	<i class="fa fa-camera" aria-hidden="true"></i>
																</a>
															</div>
															<div
																class="lisViewtCatDetail col-md-8 col-sm-12 col-xs-12 myads">
																<div class="row">
																	<h4 class="col-md-8 col-sm-6 col-xs-12">
																		<a href="<?php

																		if (isset($single_listing['title'])) {
																			echo base_url() . volgo_make_slug($single_listing['title']);
																		}

																		?>">
																			<?php if (isset($single_listing['title'])) {
																				echo $single_listing['title'];
																			} ?>
																		</a>
																	</h4>
																	<h5 class="col-md-4 col-sm-6 col-xs-12 text-right">
																		<?php if (isset($price)) {
																			echo number_format($price);

																		} ?>
																		<span>
																		<?php if (isset($currnecy_code)) {
																			echo $currnecy_code;

																		} ?>
																	</span></h5>
																</div>
																<p class="text-muted">
																	<?php if (isset($single_listing['city_name'])) {
																		echo $single_listing['city_name'];
																	} ?>
																	,
																	<?php if (isset($single_listing['state_name'])) {
																		echo $single_listing['state_name'];
																	} ?>
																	,
																	<?php if (isset($single_listing['country_name'])) {
																		echo $single_listing['country_name'];
																	} ?>

																</p>
																<ul class="list-unstyled listBread clearfix">
																	<li>
																		<a href="javascript:void(0)">
																			<?php if (isset($single_listing['cat_name'])) {
																				echo $single_listing['cat_name'];
																			} ?>

																		</a>
																	</li>
																	<li>
																		<a href="javascript:void(0)">

																			<?php if (isset($single_listing['sub_cat_name'])) {
																				echo $single_listing['sub_cat_name'];
																			} ?>
																		</a>
																	</li>

																</ul>
																<ul class="edit1 call-now">

																	<li>
																<span class="number" data-last="
																<?php if (isset($phone)) {
																	echo $phone;

																} ?>
																?>">
																<span><a target="_blank" class="see"><i
																			class="fa fa-phone" aria-hidden="true"></i> <span
																			class="calls">Call Now </span> </a></span>
																</span>
																	</li>
																	<?php if (isset($single_listing['id'])) {
																		$id_of_lisiting = $single_listing['id'];
																	} else {
																		$id_of_lisiting = "";
																	} ?>
																	<?php if (isset($single_listing['title'])) {
																		$slug = volgo_make_slug($single_listing['title']);
																	} else {
																		$slug = "";
																	} ?>
																	<li>
																		<a href="<?php echo base_url('Dashboard/remove_fav_add/') . $id_of_lisiting . '/Dashboard' ?>"><i
																				class="fa fa-heart"></i><span
																				class="savit">remove</span>
																		</a></li>
																	<li class="rep"><a href="#"><i
																				class="fa fa-flag"></i><span
																				class="savit">Report Now</span> </a>
																	</li>
																</ul>
															</div>
														</div>
													</div>
												</div>
											</div>

											<?php
										endforeach;
									else:
										echo "No add Saved Yet";
									endif;
									?>


								</div>

								<div id="saved_searches" class="tab-pane fade">

									<div class="col-md-12 row">

										<div class="adds ">
											<h4 class="pull-left">Your Saved Search List</h4>

											<div class="pull-right">
												<span class="pull-left mr-2">select Category</span>
												<div class="form-group pull-left" style="width: 120px">
													<select class="form-control">
														<option>Property for sale</option>
														<option>Property for rent</option>
														<option>Property for sale</option>
														<option>Property for rent</option>
													</select>
												</div>
											</div>
										</div>


									</div>
									<?php
									foreach($saved_search as $searched_row):
										?>

										<div class="col-md-12" id="del_this_one_<?php echo $searched_row['id']; ?>">
											<small>
												<?php
												if($searched_row && $searched_row['time'])
													echo $searched_row['time'];
												else
													echo "";
												?>
											</small>
											<div class="holder sec-holder">

												<div class="lisViewtCatHolder fvt-add saved-searchs clearfix">
													<div class="row">
														<div class="col-md-6 col-sm-6 col-xs-12">
															<h3><a href="<?php
																if($searched_row && $searched_row['full_url'])
																	echo $searched_row['full_url'];
																else
																	echo "#";
																?>"><span style="text-transform: capitalize !important;">
																	<?php
																	if(!isset($searched_row['link']['cat_name'])){
																		echo $searched_row['link']['parent_cat_select'];
																		if(isset($searched_row['link']['child_cats']))
																			echo '|'.$searched_row['link']['child_cats'];
																	}else
																		echo $searched_row['link']['cat_name'];
																	?>
																		</span>
																</a></h3>
															<h4><?php
																if(isset($searched_row['link']['country_search']))
																{
																	echo $searched_row['link']['country_search'];
																}
																if(isset($searched_row['link']['select_state']))
																	echo '|'.$searched_row['link']['select_state'];
																if(isset($searched_row['link']['selected_city']))
																	echo '|'.$searched_row['link']['selected_city'];
																else echo "All Cities";
																?></h4>

															<ul>
																<li> <?php
																	if(isset($searched_row['link']['make']))
																		echo '|'.$searched_row['link']['make'];
																	else echo "";
																	?>
																	<?php
																	if(isset($searched_row['link']['model']))
																		echo '|'.$searched_row['link']['model'];
																	else echo "";
																	?>
																	<?php
																	if(isset($searched_row['link']['yearfrom']))
																		echo '|'.$searched_row['link']['yearfrom'].' - ';
																	if(isset($searched_row['link']['yearto']))
																		echo $searched_row['link']['yearto'].'|';
																	else echo" ";
																	?>
																	<?php
																	if(isset($searched_row['link']['condition']))
																		echo '|'.$searched_row['link']['condition'].'|';
																	else echo "";
																	?>

																</li>

																<!-- <li>Used</li> -->
															</ul>
														</div>
														<div class="col-md-6 col-sm-6 col-xs-12  emailalrt">

															<!-- <h3><i class="fa fa-envelope"></i> Email Alerts are ON</h3> -->
															<!-- <a class="tunon" href="#"> Turn OFF</a> -->
															<span id="trash_<?php echo $searched_row['id']; ?>" class="fa fa-spinner paddindIt" style="float:right;padding-left: 7px;display: none;"></span>
															<input data-id_data="<?php echo $searched_row['id']; ?>" id="del_this_one_<?php echo $searched_row['id']; ?>" type="button" class="delete del_this_one" value="Delete Search">

														</div>
													</div>

												</div>

											</div>

										</div>
										<?php
									endforeach;
									?>


								</div>

								<div id="membership" class="tab-pane fade">

								</div>

								<div id="followers" class="tab-pane fade">
									<div class="border no-border">
										<div class="row">
											<?php if (!empty($followers)): ?>
												<?php foreach ($followers as $single_follower): ?>
													<div class="col-lg-4 col-sm-6">

														<div class="card hovercard">


															<div class="avatar">
																<img src="images/img-m.jpg" alt="">
															</div>
															<div class="info">
																<div class="title follow">
																	<a target="_blank" href="#"><?php
																		echo $single_follower['name']; ?></a>
																	<p class="text-muted"><?php echo $single_follower['postcount']; ?>
																		Posts</p>
																</div>

															</div>
															<div class="bottom">
																<a href="<?php echo base_url('Dashboard/unfollow_dashboard/') . $single_follower['id'] ?>"
																   tabindex="0"
																   class="btn bg-blue-ui white read">Block</a>
															</div>


														</div>

													</div>
												<?php endforeach; ?>
											<?php endif; ?>
										</div>
									</div>


								</div>

								<div id="following" class="tab-pane fade">


									<div class="border no-border">
										<div class="row">
											<?php if (!empty($following)): ?>
												<?php foreach ($following as $single_follower): ?>
													<div class="col-lg-4 col-sm-6">

														<div class="card hovercard">


															<div class="avatar">
																<img src="images/img-m.jpg" alt="">
															</div>
															<div class="info">
																<div class="title follow">
																	<a target="_blank" href="#"><?php
																		echo $single_follower['name']; ?></a>
																	<p class="text-muted"><?php echo $single_follower['postcount']; ?>
																		Posts</p>
																</div>

															</div>
															<div class="bottom">
																<a href="<?php echo base_url('Dashboard/unfollowing_dashboard/') . $single_follower['id'] ?>"
																   tabindex="0"
																   class="btn bg-blue-ui white read">UNFollow</a>
															</div>


														</div>

													</div>
												<?php endforeach; ?>
											<?php endif; ?>


										</div>
									</div>

								</div>
								<div id="settings" class="tab-pane fade">
									<div class="row form-fill">
										<div class="row">
											<div class="col-md-6 col-sm-6 col-xs-12">
												<div class="row">
													<div class="col-md-12 col-sm-12 col-xs-12">
														<div class="form-group">
															<label>First Name</label>
															<input type="text"
																   value="<?php echo ucwords($single_detail->firstname); ?>"
																   class="text_label form-control"
																   name="firstname" contenteditable="true">


														</div>
														<div class="form-group">
															<label>Last Name</label>
															<input type="text"
																   value="<?php echo ucwords($single_detail->lastname); ?>"
																   class="text_label form-control "
																   name="lastname" contenteditable="true">


														</div>
														<div class="form-group">
															<label>Email</label>
															<input type="text"
																   value="<?php echo $single_detail->email; ?>"
																   class="text_label form-control "
																   name="lastname" contenteditable="true">


														</div>
													</div>
													<div class="col-md-12 col-sm-12 col-xs-12 clas-z">

													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<div class="row">

													<div class="col-md-12 col-sm-12 col-xs-12">
														<a class="btn btn-custom btn-lg btn-block"
														   href="<?php echo base_url('dashboard/deactivateacuton/') . $single_detail->id; ?>">
															Deactivate My Account</a>


													</div>
												</div>
											</div>
										</div>
									</div>


								</div>
							</div>

							<?php endforeach; ?>
						</div>
					</div>
				</div>
				<div class="add-baner text-center">
					<div class="container">
						<div class="row">
							<div class="col-md-9 text-center offset-md-1">
								<img class="img-responsive"
									 src="<?php echo base_url('assets/images/sell.jpg'); ?>" alt="">
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>


	<?php include_once realpath(__DIR__ . '/..') . '/includes/footer.php'; ?>
