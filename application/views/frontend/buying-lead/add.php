<?php include_once realpath(__DIR__ . '/..') . '/includes/top_header.php'; ?>
<?php include_once realpath(__DIR__ . '/..') . '/includes/header.php'; ?>

<section class="main-section form_main_wrapp">

	<div class="container-fluid mainWrapper listingMain buying_page">
		<div class="row">
			<!-- Form Mark will  goes here -->
			<!-- Form Html Start here -->

			<div class="post_form_wrapper">


				<div class="ad_title"><h3>Post Buying Lead on VolgoPoint</h3></div>

				<?php if (! empty($this->session->flashdata('success_msg'))): ?>
					<div class="form-row">
						<div class="col-md-12">
							<div class="success-wrapper alert alert-success">
								<p><?php echo $this->session->flashdata('success_msg'); ?></p>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<?php if (! empty($this->session->flashdata('warning_msg'))): ?>
					<div class="form-row">
						<div class="col-md-12">
							<div class="warning-wrapper alert alert-warning">
								<p><?php echo $this->session->flashdata('warning_msg'); ?></p>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<?php if (isset($validation_errors) && !empty($validation_errors)): ?>
						<div class="form-row">
							<div class="col-md-12">
								<div class="error-wrapper alert alert-danger">
									<p><?php echo $validation_errors; ?></p>
								</div>
							</div>
						</div>
				<?php endif; ?>


				<form action="<?php echo base_url('add-buying-lead'); ?>" method="POST" enctype="multipart/form-data">
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputTitle">Ad Title</label>
							<input type="text" name="input_title" class="form-group inputTitle" id="inputTitle"
								   value="<?php echo set_value('input_title'); ?>">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="input_description">Ad Description</label>
							<textarea class="form-control" name="input_description" id="input_description" cols="30"
									  rows="2"><?php echo set_value('input_description'); ?></textarea>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="input_images">Ad Images</label>
							<input multiple class="form-control" type="file" name="input_images[]" accept="image/*" />
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="inputCountry">Select Country</label>
							<select name="input_country" id="inputCountry" class="form-control">
								<option value="">Choose Country</option>
								<?php foreach ($countries as $country): ?>
									<option <?php echo (intval(volgo_get_country_id_from_session()) === intval($country->id)) ? 'selected' : ''; ?>
										value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="inputState">Select State</label>
							<select name="input_state" id="inputState" class="form-control">
								<option value=""> Choose State </option>
								<?php foreach ($states as $state): ?>
									<option <?php echo (intval(set_value('input_state')) === intval($state->id)) ? 'selected' : ''; ?> value="<?php echo $state->id; ?>" ><?php echo $state->name; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="inputCity">Select City</label>
							<select name="input_city" disabled id="inputCity" class="form-control">
								<option value="">Choose City</option>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputCategory">Select Category</label>
							<select name="input_category" id="inputCategory" class="form-control">
								<option value="">Choose Category</option>
								<?php foreach ($buying_lead_parent_cats as $category): ?>
									<option <?php echo (intval(set_value('input_category')) === intval($category->cat_id)) ? 'selected' : ''; ?>
										value="<?php echo $category->cat_id; ?>"><?php echo $category->cat_name; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group col-md-6">
							<label for="inputSubcategory">Select SubCategory</label>
							<select name="input_subcategory" disabled id="inputSubcategory" class="form-control">
								<option value="">Choose Subcategory</option>
							</select>
						</div>
						<div class="loader-wrapper" style="display: none;">
							<span class="fa fa-spinner fa-spin"></span>
						</div>
					</div>

					<hr/>

					<!-- Dynamically fill this form -->
					<div class="integrate-form-data"></div>


					<button type="submit" class="btn btn-large btn-sub">Submit Buying Lead</button>
				</form>

			</div>
			<!-- Form html end here -->
			<!-- https://getbootstrap.com/docs/4.0/components/forms/ -->

		</div>
	</div>
</section>


<?php include_once realpath(__DIR__ . '/..') . '/includes/footer.php'; ?>
