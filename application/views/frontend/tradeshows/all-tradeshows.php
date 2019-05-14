<?php include_once realpath(__DIR__ . '/..') . '/includes/top_header.php'; ?>
<?php include_once realpath(__DIR__ . '/..') . '/includes/header.php'; ?>


<section class="mainWrapper mx-auto">
	<div class="container trade-show">
		<h1 class="text-uppercase main-heading">Trade Shows</h1>
		<p class="sub-heading">What's happening in Trade World?</p>
		<div class="row">

			<?php if (isset($tradeshows) && !empty($tradeshows)): ?>
				<?php foreach ($tradeshows as $tradeshow) : ?>
					<div class="col-sm-6 spacing">
						<div class="item-box">
							<div class="position-relative d-flex tradeshow-<?php echo $tradeshow['post_info']['post_id']; ?>">
								<div class="text-uppercase purple event-date"><?php echo date('d M Y', strtotime($tradeshow['post_info']['create_date'])); ?></div>
								<img class="img-fluid event-img"
									 src="<?php
                                     $trade_image = $tradeshow['post_info']['featured_image'];
                                     echo (empty($tradeshow['post_info']['featured_image'])) ? volgo_get_no_image_url() : UPLOADS_URL . '/tradeshows/' . volgo_maybe_unserialize($trade_image);
                                     ?>" alt="trade-show">
							</div>
							<div class="content">
								<h1 class="title"><?php echo $tradeshow['post_info']['title']; ?></h1>
								<p class="post-by">By <a href="">George S.Henry</a></p>
								<p class="description"><?php echo $tradeshow['post_info']['content']; ?></p>
								<div class="date-venue">
									<?php foreach ($tradeshow['meta_info'] as $meta_info) : ?>

										<?php if ($meta_info['meta_key'] === 'starting_date') : ?>
											<span class="date start-date">Start Date: </span><span><?php echo date('d M Y', strtotime($meta_info['meta_value'])); ?></span>
										<?php endif; ?>

										<?php if ($meta_info['meta_key'] === 'ending_date') : ?>
											<span class="date end-date">End Date: </span><span><?php echo date('d M Y', strtotime($meta_info['meta_value'])); ?></span>
										<?php endif; ?>

										<?php if ($meta_info['meta_key'] === 'ts_venue') : ?>
											<span class="venue">Venue: </span><span><?php echo $meta_info['meta_value'] ?></span>
										<?php endif; ?>

									<?php endforeach; ?>
								</div>
								<a class="btn btn-default mt-3 orange-bg" href="<?php echo base_url( 'tradeshow/' . $tradeshow['post_info']['slug']); ?>" >View details</a>
							</div>
						</div>
					</div>

				<?php endforeach; ?>
			<?php endif; ?>
			<!--<a class="btn load_more orange-bg" href="#">Load More</a>-->
		</div>
	</div>
</section>
<?php include_once realpath(__DIR__ . '/..') . '/includes/footer.php'; ?>
