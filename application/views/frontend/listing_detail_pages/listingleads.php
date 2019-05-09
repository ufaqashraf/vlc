<?php include_once realpath(__DIR__ . '/..') . '/includes/top_header.php'; ?>
<?php include_once realpath(__DIR__ . '/..') . '/includes/header.php'; ?>

<section class="main-section">
	<div class="container-fluid mainWrapper leads_detail_page">
		<div class="row">
			<!-- Start Copy From here  -->
			<div class="col-md-8 col-lg-9">

                <div class="leads_b_block col-sm-12 no-padding">
                    <h1 class="leads-main-title">Premium Membership</h1>
                    <div class="col-md-12 leads_block_d">
                        <p>Your Inquiry Manager acts as your Watch List that helps you keep track of the Buy Requirements<br><br>

                            added by you, and<br>
                            matched by our Trade Research Team, on the buyer's request.<br>
                            Your Inquiry Manager will help you select and get only those Buy Requirements which are relevant to your business area.<br><br>

                            Select the Buy Requirement(s) you wish to get and press<br><br>

                            [Get the Selected Buy Requirements]. The Buy Requirements and the buyers' complete contact details will be emailed to you.</p>
                    </div>
                </div>
				<div class="leads_b_block col-sm-12 no-padding">
                    <h1 class="leads-main-title"><?php if($listing_detail['info'][0]){ echo $listing_detail['info'][0]->title;}?> </h1>
                    <div class="col-md-12 leads_block_d">
                        <?php 
                            $user_id = volgo_get_logged_in_user_id();
                            if(!empty(($listing_detail['info'][0]))):
                                echo $listing_detail['info'][0]->description;
                                echo '<p>Kindly contact us for further details</p>';
                                if(!empty($user_membership) && $user_membership[0]->available_connect != 0):
                                    echo '<ul class="user_details" style="display:none">';
                                    if($listing_detail['metas'][4]->meta_key == 'fname' && !empty($listing_detail['metas'][4]->meta_value)){
                                        echo '<li><span><i class="fa fa-user"></i>Contact: </span>'.$listing_detail['metas'][4]->meta_value.' '.$listing_detail['metas'][5]->meta_value.'</li>';
                                    }
                                    if($listing_detail['metas'][2]->meta_key == 'phone' && !empty($listing_detail['metas'][2]->meta_value)){
                                        echo '<li><span><i class="fa fa-phone"></i>Mobile Number: </span>'.$listing_detail['metas'][2]->meta_value.'</li>';
                                    }
                                    if($listing_detail['metas'][3]->meta_key == 'email' && !empty($listing_detail['metas'][3]->meta_value)){
                                        echo '<li><span><i class="fa fa-envelope"></i>Email: </span>'.$listing_detail['metas'][3]->meta_value.'</li>';
                                    }
                                    echo '</ul>';
                                endif;
                            endif;
                        ?>
                        <?php if($parent_cat_name == 'buying-leads'): ?>
                            <button type="button" class="btn leads_btn show_leads_details" data-user_id="<?php echo $user_id; ?>">Contact the buyer</button>
                        <?php else: ?>
                            <button type="button" class="btn leads_btn show_leads_details" data-user_id="<?php echo $user_id; ?>">Contact the seller</button>
                        <?php endif; ?>
                    </div>
                </div>
			</div>
			<!-- Search -->
            <!-- right side-bar search start -->
            <?php include_once realpath(__DIR__ . '/..') . '/includes/sidebar_filter_listing.php'; ?>
            <!-- right side-bar search end -->
		</div>
	</div>
</section>
<?php if(!empty($user_membership) && $user_membership[0]->available_connect == 0):?>
    <div id="renew_membership" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5>Your membership connects per day limits has been reached</h5>
                <a href="<?php echo base_url('payment-plans'); ?>" class="btn">Upgrade membership</a>
            </div>
        </div>
    </div>
<?php endif; ?>
<style>
#renew_membership .modal-content {
    padding: 30px;
    border-radius: 0;
}
#renew_membership .modal-content button.close {
    position: absolute;
    right: 4px;
    top: 0;
    z-index: 9999;
}
#renew_membership .modal-content a.btn {
    display: inline-block;
    background-image: linear-gradient(to bottom, #F16529, #E44D26);
    color: #fff;
    width: 178px;
    font-size: 14px;
    border-radius: 5px;
    margin: 0 auto;
}
#renew_membership .modal-content h5 {
    text-align: center;
    color: #000;
    font-size: 16px;
    line-height: 25px;
    margin: 0;
    margin-bottom: 20px;
}
button.btn.leads_btn {
    background-color: #f44336;
    color: #fff;
    border-radius: 5px;
    border-color: #f44336;
    margin-top: 30px;
    background-image: linear-gradient(to bottom, #F16529, #E44D26);
}
.leads_detail_page .leads_b_block:first-child h1.leads-main-title {
    background-image: linear-gradient(to bottom, #F16529, #E44D26);
    border-radius: 5px;
    text-align: center;
}
.leads_detail_page h1.leads-main-title {
    background-color: #007BDC;
    height: 50px;
    line-height: 50px;
    margin: 0;
    padding: 0 15px;
    border-radius: 5px 5px 0 0;
}
.leads_block_d {
    padding: 30px;
    border: 1px solid #eee;
    border-top: none;
    border-radius: 0 0 5px 5px;
}
.leads_block_d p {
    font-size: 14px;
}
.leads_block_d h6.user_name {
    color: #000;
    font-size: 14px;
    margin-bottom: 0;
}
.no-padding{
    padding:0;
}
.leads_detail_page {
    padding-top: 60px;
    padding-bottom: 60px;
}
.leads_detail_page .leads_b_block:not(:last-child) .leads_block_d {
    border: none;
    padding: 0;
    margin-bottom: 30px;
    padding-top: 30px;
}
</style>

<?php include_once realpath(__DIR__ . '/..') . '/includes/footer.php'; ?>
