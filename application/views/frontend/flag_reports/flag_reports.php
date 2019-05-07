<?php include_once realpath(__DIR__ . '/..') . '/includes/top_header.php'; ?>
<?php include_once realpath(__DIR__ . '/..') . '/includes/header.php'; ?>

<section class="grey-bg">
    <div class="mainWrapper text-center mx-auto">
        <div class="report mx-auto">
            <div class="head-title text-capitalize">

                <!-- <button class="btn btn-default mt-2 orange-bg">Back to Listings</button> -->

                Report this listing
                <a href="<?php echo base_url($listing_slug); ?>">

                    <i class="fa fa-long-arrow-left bk_btn"></i>
                </a>
            </div>
            <?php if (!empty($this->session->flashdata('validation_errors'))): ?>
                <div class="alert alert-danger">
                    <div><?php echo $this->session->flashdata('validation_errors'); ?></div>
                </div>
            <?php endif; ?>
            <?php if (!empty($this->session->flashdata('success_msg'))): ?>
                <div class="alert alert-success">
                    <div><?php echo $this->session->flashdata('success_msg'); ?></div>
                </div>
            <?php endif; ?>
            <form class="text-left" action="<?php echo base_url('Flagreports/insert_flagreport/').$user_id . '/' .$listing_slug ; ?>" method="post">
                <h4>Lorem ipsum dolor sit amet, consectetur </h4>
                <hr class="m-0 mt-2 mb-2">
                <div class="col-sm-12 px-0 mb-3">
                    <label for="reportSpam">Spam</label>
                    <input type="text" class="form-control" name="spam" id="spam" placeholder="What kind of spam is this?" required>
                </div>
                <div class="col-sm-12 px-0 mb-3">
                    <label for="reportFraud">Fraud</label>
                    <input type="text" class="form-control" name="fraud" id="fraud" placeholder="Please tell us why you believe this is a fraud?" required>
                </div>
                <div class="col-sm-12 px-0 mb-3">
                    <label for="reportMiscategory">Miscategorized</label>
                    <input type="text" class="form-control" name="miscategorized" id="miscategorized" placeholder="This add will be reviewed and recategorized accordingly." required>
                </div>
                <div class="form-group rpt">
                    <label for="reportRepetitive">Repetitive Listing</label>
                    <textarea class="form-control" name="repetitive" id="repetitive" rows="4" placeholder="You have chosen to report this as a repetitive listing." required></textarea>
                    <div class="text-center txtarea-btn">

                    </div>
                </div>

                <div class="text-left all-listing-btn">
                    <button class="btn btn-default mt-2 orange-bg" name="submit" type="submit">Report Repetitive</button>

                </div>
            </form>
        </div>
    </div>
</section>

<?php include_once realpath(__DIR__ . '/..') . '/includes/footer.php'; ?>

