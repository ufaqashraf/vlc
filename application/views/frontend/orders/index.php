<?php include_once realpath(__DIR__ . '/..') . '/includes/top_header.php'; ?>
<?php include_once realpath(__DIR__ . '/..') . '/includes/header.php'; ?>

<section class="main-section">
	<div class="container-fluid mainWrapper">
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<div class="paymentPlanHolder">
					<div class="paymentPlans">
						<h2>Orders</h2>
					</div>
					<div class="paymentPlansText">

					</div>
				</div>
			</div>
		</div>

		<!-- Plans Section -->
		<div class="plansection">

			<?php if (! empty($this->session->flashdata('error_message'))): ?>
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-danger">
							<p><?php echo $this->session->flashdata('error_message'); ?></p>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if (! empty($this->session->flashdata('success_message'))): ?>
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-success">
							<p><?php echo $this->session->flashdata('success_message'); ?></p>
						</div>
					</div>
				</div>
			<?php endif; ?>
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
<?php include_once realpath(__DIR__ . '/..') . '/includes/footer.php'; ?>
