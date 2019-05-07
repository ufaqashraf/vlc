<?php include_once realpath(__DIR__ . '/..') . '/includes/top_header.php'; ?>
<?php include_once realpath(__DIR__ . '/..') . '/includes/header.php'; ?>

<section class="grey-bg">

    <div class="mainWrapper text-center mx-auto">
        <div class="big-image-holder mr-auto"><img src="<?php echo base_url('assets/images/AdvertiseForm_03.png')?>" alt="" > </div>
        <div class="advertise ml-auto">
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
            <form class="text-left" action="<?php echo base_url('advertisewithus/create'); ?>" method="post">
                <h4>Send your requirements</h4>
                <div class="col-sm-12 px-0 mb-2">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Type here" required>
                </div>
                <div class="col-sm-12 px-0 mb-3">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Type here" required>
                </div>
                <div class="col-sm-12 px-0 mb-3">
                    <label for="phone">Phone:</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Type here" required>
                </div>
                <div class="form-group mb-4">
                    <label for="comments">Comments:</label>
                    <textarea class="form-control" id="message" rows="4" name="message" placeholder="Type here" required></textarea>
                </div>
<!--                <div class="form-group ">-->
<!--                    <label class="auto-generated-text" for="auto_generated_text">7cJs6</label>-->
<!--                    <input type="text" class="form-control" id="auto_generated_text" placeholder="Type the above text" required>-->
<!--                </div>-->
                <button class="btn btn-default mb-4 orange-bg" type="submit">Submit Now</button>
            </form>
        </div>
    </div>
</section>

<?php include_once realpath(__DIR__ . '/..') . '/includes/footer.php'; ?>
