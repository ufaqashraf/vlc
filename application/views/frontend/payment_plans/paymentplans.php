<?php include_once realpath(__DIR__ . '/..') . '/includes/top_header.php'; ?>
<?php include_once realpath(__DIR__ . '/..') . '/includes/header.php'; ?>

<section class="main-section">
	<div class="container-fluid mainWrapper">
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<div class="paymentPlanHolder">
					<div class="paymentPlans">
						<h2>Choose the plan that fits your needs</h2>
					</div>
					<div class="paymentPlansText">
						<p> Etiam sagittis velit nec lorem facilisis facilisis.
							Pellentesque habitant morbi tristique senectus et netus et
							malesuada fames ac turpis egestas. Nulla facilisi. Aenean
							enim nulla, vehicula ut bibendum sit amet, consectetur ac risus.
							In convallis metus ipsum </p>
					</div>
				</div>
			</div>
		</div>

		<!-- Plans Section -->
		<div class="plansection">

			<?php if (!empty($this->session->flashdata('success_message'))): ?>
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-success">
							<p><?php echo $this->session->flashdata('success_message'); ?></p>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if (!empty($this->session->flashdata('error_message'))): ?>
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-danger">
							<p><?php echo $this->session->flashdata('error_message'); ?></p>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<div class="row">
				<?php if (isset($packages)): ?>
					<?php foreach ($packages as $package): ?>
						<?php $is_featured = (intval($package['package_info']->is_featured) === 1) ? true : false; ?>

						<div class="col-md-4">
							<div class="plan <?php echo $is_featured ? 'featured' : ''; ?>">
								<?php if ($is_featured): ?>
									<div class="featuredtext">
										<span>Featured</span>
									</div>
								<?php endif; ?>
								<div class="planinformation">
									<div class="button"><?php echo strtoupper($package['package_info']->title); ?></div>
									<div class="price">
										<span class="currencysign"><?php echo strtoupper(B2B_CURRENCY_UNIT) ?></span>
										<?php echo $package['package_info']->amount; ?>
										<span
											class="duration">/<?php echo $package['package_info']->expiry_unit; ?></span>
									</div>
									<ul class="planfeatures">
										<?php foreach ($package['functionalities'] as $functionality): ?>
											<li><?php echo $functionality->title; ?></li>
										<?php endforeach; ?>
									</ul>

									<div class="pay_way">
										<div class="follow">
											<div class="icon_btn first"><a
													href="<?php echo base_url('purchase/' . $package['package_info']->id) . '/' . volgo_encrypt_message('paypal'); ?>"><img
														src="<?php echo base_url('assets/images/paypal_btn.png'); ?>"
														alt="paypal-charge-btn"></a></div>

											<div class="icon_btn last"><a
													href="<?php echo base_url('purchase/' . $package['package_info']->id) . '/' . volgo_encrypt_message('network'); ?>"><img
														src="<?php echo base_url('assets/images/network_btn.png'); ?>"
														alt="network-charge-btn"></a></div>
											<div class="label"><a href="javascript:void(0)" class="purchase">Purchase
													Now</a></div>
										</div>
									</div>
								</div>
							</div>
						</div>

					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>

		<!-- Sell Anything Section -->
		<div class="sellanythingSection">
			<div class="row">
				<div class="col-md-12">
					<span class="sellanythingTitle"> Sell Anything on VolgoPoint </span>
					<ul class="list-unstyled sellAdNav">
						<li>
							<a href="javascript:void(0)">
								<span class="icon propertyIcon"></span>
								Property </a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<span class="icon classifiedIcon"></span>
								Classified </a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<span class="icon jobIcon"></span>
								Jobs </a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<span class="icon servicesIcon"></span>
								Services </a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<span class="icon leadsIcon"></span>
								Leads </a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<span class="icon motorsIcon"></span>
								Motors </a>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<!-- Post Free Ad button -->
		<div class="text-center postfreeHolder">
			<a href="javascript:void(0)" class="postfreeButton"> post free ad </a>
		</div>
	</div>
</section>

<!--Creates the popup body-->
<div class="popup-overlay"></div>

<?php if (!empty($this->session->flashdata('paypal_payment_plan_error'))): ?>
	<!--Creates the popup content-->
	<div class="popup-content">
		<img src="<?php echo base_url('assets/images/warning_icon.png') ?>" alt="close-button-image">
		<div class="error-msg">
			<?php echo $this->session->flashdata('paypal_payment_plan_error'); ?>
		</div>
		<!--popup's close button-->
		<button class="btn btn-danger btn_close">Go Back</button>
	</div>
<?php endif; ?>

<?php if (!empty($this->session->flashdata('paypal_payment_plan_success'))): ?>
<!--Creates the popup content-->
<div class="popup-content popup2">
	<div class="icon-box">
		<i class="fa fa-check"></i>
	</div>
	<div class="error-msg">
		<?php echo $this->session->flashdata('paypal_payment_plan_success'); ?>
	</div>
	<!--popup's close button-->
	<button class="btn btn-success btn_close">Go Back</button>
</div>
<?php endif; ?>

<?php include_once realpath(__DIR__ . '/..') . '/includes/footer.php'; ?>
