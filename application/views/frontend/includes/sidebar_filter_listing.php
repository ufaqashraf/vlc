<div class="col-md-4 col-lg-3">
	<div class="sidebarSearch">
		<div class="holder">
			<span class="searchTitle"> Search </span>

			<form method="get" action="<?php echo base_url('listingsearch/sidebar'); ?>">
				<fieldset>
					<div class="searchStack">
						<span class="sidebarTitle"> Select Location </span>
						<div class="iconHolder">
							<i class="fa fa-map-marker" aria-hidden="true"></i>
							<select class="form-control  country_select_child" name="country_search">
								<option value=''>Select Country</option>

								<?php

								if ($this->input->get('country_search') !== null && !empty($this->input->get('country_search'))){
									$current_country = $this->input->get('country_search');
								}else {
									$current_country = volgo_get_country_id_from_session();
								}

								if(!isset($all_cuntry) || empty($all_cuntry)){
									$all_cuntry = volgo_get_countries();
								}
								foreach ($all_cuntry as $single_cuntry): ?>

									<option
										value="<?php echo $single_cuntry->id; ?>"
										<?php echo (intval($current_country) === intval($single_cuntry->id)) ? 'selected' : '' ?>
										><?php echo $single_cuntry->name; ?></option>

								<?php endforeach; ?>
							</select>
						</div>
						<i class="fa fa-spinner fa-spin" style="font-size:24px; display: none"></i>
						<div class="iconHolder">
							<i class="fa fa-map-marker" aria-hidden="true"></i>
							<div class="col-sm-12 countryselect2 removespecial">


								<select name="select_state" id="state_selected"
										class="form-control state_selected select2_demo_3 form-control select2-hidden-accessible"
										tabindex="-1" aria-hidden="true">
									<option value=''>Select State</option>
									<?php
									$selected_state = '';
									if ($this->input->get('select_state') !== null && !empty($this->input->get('select_state'))){
										$selected_state = $this->input->get('select_state');
									}

									$all_states = volgo_get_states_by_country_id(volgo_get_country_id_from_session());


									foreach ($all_states as $single_state):
										?>
										<option <?php echo (intval($selected_state) === intval($single_state->id)) ? 'selected' : ''; ?>
											value="<?php echo $single_state->id ?>"><?php echo $single_state->name ?></option>
										<?php
									endforeach;
									?>
									<!-- appending through Ajax funciton of get_state_ajax -->

								</select>

							</div>
						</div>
						<?php
						if ($this->input->get('selected_city') !== null && !empty($this->input->get('selected_city'))):
							$selected_city = $this->input->get('selected_city');
							$cities = volgo_get_cities_by_state_id($selected_state);
							$extra_class = "";
						else:
							$extra_class = "collapse";
						endif;
						?>
						<div class="iconHolder <?php echo $extra_class; ?> city_container">
							<i class="fa fa-map-marker" aria-hidden="true"></i>
							<select id="city_selection" class="form-control selected_city "
									name="selected_city">
								<option value=''>Select City</option>
								<?php foreach ($cities as $city): ?>
									<option <?php echo (intval($selected_city) === intval($city->id)) ? 'selected' : ''; ?> value="<?php echo $city->id; ?>"><?php echo $city->name; ?></option>
								<?php endforeach; ?>


								<!-- appending through Ajax funciton of get_subchild_ajax -->
							</select>

						</div>
					</div>
					<div class="searchStack">
						<span class="sidebarTitle"> Select category </span>
						<div class="iconHolder">


							<i class="fa fa-tag" aria-hidden="true"></i>
							<select name="parent_cat_select" id="volgo_cats"
									class="form-control cat_select_child autoselected">
								<option value=''>Select Category</option>
								<?php
								if(!isset($all_cats) || empty($all_cats)){
									$all_cats = volgo_get_all_categories();
								}
								foreach ($all_cats as $single_cat): ?>

									<?php if ($single_cat->parent_ids === 'uncategorised'): ?>

										<option <?php echo (volgo_get_current_category_id() === $single_cat->id) ? 'selected' : ''; ?>
											value="<?php echo $single_cat->id; ?>"><?php echo $single_cat->name; ?></option>
									<?php endif; ?>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="iconHolder">
							<i class="fa fa-tag" aria-hidden="true"></i>
							<select id="show_child_cat" class="show_child_cat form-control get_from_db"
									name="child_cats">
								<option value=''>Select Sub-Category</option>
								<?php $subcats = volgo_get_sub_categories_by_parent_cat_id();
								$selected_sub_cat_id = volgo_get_current_sub_category_id();

								foreach ($subcats as $subcat): ?>

									<option <?php echo (intval($selected_sub_cat_id) === intval($subcat->id)) ? 'selected' : ''; ?> value="<?php echo $subcat->id; ?>"><?php echo $subcat->name;?></option>

								<?php endforeach; ?>
								<!-- appending through Ajax funciton of get_subchild_ajax -->
							</select>

						</div>

						<div class="made_append">

							<?php if (isset($selected_sub_cat_id) && !empty($selected_sub_cat_id)): ?>
								<?php

								$basic_form = volgo_get_sidebar_search_form($selected_sub_cat_id);

								if (isset($basic_form[0], $basic_form[0]->meta_value) && ! empty($basic_form))
									echo $basic_form[0]->meta_value;

								?>
							<?php endif; ?>

						</div>

					</div>

					<div class="search-loader" style="display: none;">
						<div class="spinner-loader fa fa-spinner fa-spin"></div>
					</div>

					<div class="searchStack">
						<div class="textField">
							<input type="text" name="search_query" class="form-control" placeholder="Type Keyword Here">
						</div>
						<div class="textField searchMe">
							<input class="search-me" type="submit" value="search Now">
						</div>
						<div class="textField searchBtnsAction">
							<ul class="list-unstyled clearfix saveBtn">

								<button class="btn" type="reset" value="Reset">
									<i class="fa cross-icon" aria-hidden="true"></i>
									Reset
								</button>
								<!--							<button class="btn" >-->
								<!--								<i class="fa fa-spinner" style="display: none"></i>-->
								<!--								<i class="fa fa-heart-o" aria-hidden="true"></i>-->
								<!--								save-->
								<!--							</button>-->
								<li>
									<a class="saveIt save_search_history" id="save_search_history"
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
					<div class="searchTitle"> advance search
						<a class="advSearchMore collapsed" href="javascript:void(0)"
						   data-target=".advanceSearchFilters" aria-expanded="false">
						</a>
						<a class="advSearchMore advSearchLess collapsed" href="javascript:void(0)"
						   data-target=".advanceSearchFilters" aria-expanded="false">
						</a>
					</div>
					<div class="advanceSearchdData advanceSearchFilters collapse" style="">
						<div class="searchStack">
							<!--	<span class="sidebarTitle"> Select category </span>
							<div class="iconHolder">
								<i class="fa fa-tag" aria-hidden="true"></i>
								<select name="parent_cat_select" id="volgo_cats"
										class="form-control cat_select_child autoselected1">
									<option value=''>Select Category</option>
									<?php

							if(!isset($all_cats) || empty($all_cats)){
								$all_cats = volgo_get_all_categories();
							}

							foreach ($all_cats as $single_cat): ?>
										<option
                                        value="<?php echo $single_cat->id; ?>"><?php echo $single_cat->name; ?></option>

									<?php endforeach; ?>
								</select>
							</div>
							<div class="iconHolder">
								<i class="fa fa-tag" aria-hidden="true"></i>
								<select id="show_child_cat" class="show_child_cat form-control get_from_db"
										name="child_cats">
									<option value=''>Select Sub-Category</option>
									appending through Ajax funciton of get_subchild_ajax
								</select>

							</div>


						</div>
-->
							<div class="searchStack">
								<div class="made_append2">

									<?php

									$adv_form = volgo_get_advance_sidebar_search_form($selected_sub_cat_id);

									if (isset($adv_form[0], $adv_form[0]->meta_value) && ! empty($adv_form))
										echo $adv_form[0]->meta_value;

									?>

								</div>
							</div>


							<div class="textField searchMe">

								<input class="search-me" type="submit" value="search Now">
							</div>
						</div>
					</div>

			</form>
		</div>

	</div>

	<style>
		.saveBtn>li>a.saveIt {
			cursor: pointer;
			color: #007cdc;
			border: 1px solid #999;
			width: calc(50% - 5px);
			float: right;
			background: #fff;
			font-size: 15px;
			color: #666;
			box-shadow: none !important;
			text-transform: capitalize;
			padding-left: 5px;
			padding: 2px 1px 5px 4px;
		}

		.saveBtn>li>a.saveli {
			cursor: pointer;
			color: #007cdc;
			border: 1px solid #999;
			width: calc(160% - 5px);
			float: right;
			background: #fff;
			font-size: 15px;
			color: #666;
			box-shadow: none !important;
			text-transform: capitalize;
			padding-left: 5px;
			padding: 2px 1px 5px 4px;
		}
		.saveBtn>li>a.saveIt:hover {
			color: #666;
			background-color: #eee;
		}

		.saveBtn li a {
			color: #333333;
			text-decoration: none;
		}
		.saveIt:active {
			color: #fff;
			background-color: #007cdc;
		}
		.saveBtn>li>a.removesrch {
			background: #d3001a;
			color: #fff;
			cursor: pointer;
			border: 1px solid #999;
			width: calc(50% - 5px);
			float: right;
			font-size: 15px;
			box-shadow: none !important;
			text-transform: capitalize;
			/*padding: 6px -1px 9px 16px;*/
			padding-top: 2px;
			padding-bottom: 4px;
			padding-left: 4px;
		}
		.saveBtn>li>a.removesrch:hover {
			color: #666 !important;
			background-color: #eee;
		}
		.hide {
			display: none;
		}


		}
	</style>