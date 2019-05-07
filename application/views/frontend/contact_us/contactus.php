
<?php include_once realpath(__DIR__ . '/..') . '/includes/top_header.php'; ?>
<?php include_once realpath(__DIR__ . '/..') . '/includes/header.php'; ?>

<section class="main-section">
    <div class="contact-map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d27224.080723031795!2d74.2590033!3d31.468908599999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391903d4d940f12b%3A0xdb8c83f6699d5226!2sEmporium+Mall+by+Nishat+Group!5e0!3m2!1sen!2s!4v1550667975635" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>
    <div class="container-fluid mainWrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="contact-title">
                    <h2>Contact Us</h2>
                </div>
                <div class="contact-information">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 contact-info">
                            <i class="fa fa-phone"></i>
                            <div class="box-content">
                                <p> <a href="tel:+92 321 333 333 22" target="_blank">+92 321 333 333 22</a></p>
                                <p> <a href="tel:+92 321 444 444 22" target="_blank">+92 321 444 444 22</a></p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 contact-info">
                            <i class="fa fa-map-marker"></i>
                            <div class="box-content">
                                <p>Testing Address Lahore,</p>
                                <p> Punjab Pakistan.</p>
                            </div>

                        </div>
                        <div class="col-lg-3 col-md-6 contact-info">
                            <i class="fa fa-envelope"></i>
                            <div class="box-content">
                                <p><a href="mailto:info@volgopoint.com">info@volgopoint.com</a></p>
                                <p><a href="mailto:info@volgopoint.com">info@volgopoint.com</a></p>
                            </div>

                        </div>
                        <div class="col-lg-3 col-md-6 contact-info">
                            <i class="fa fa-fax"></i>
                            <div class="box-content">
                                <p> <a href="tel:+92 321 555 555 66" target="_blank">+92 321 555 555 66</a></p>
                                <p> <a href="tel:+92 321 777 777 22" target="_blank">+92 321 777 777 22</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="contact-title">
                    <h2>Contact Form</h2>
                </div>
                <div class="contact-form">
                    <div class="row">
                        <div class="col-md-12 col-lg-9">
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
                            <form action="<?php echo base_url('contactus/create'); ?>" method="post" >
                                <div class="contactform-fileds row">
                                    <div class="col-sm-6 col-lg-6 col-md-6 form-group ">
                                        <label for="name">Name : </label>
                                        <div class="input-placeholder">
                                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter your Name." required/>
                                            <i class="fa fa-user"></i>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-6 col-md-6 form-group ">
                                        <label for="email">Email : </label>
                                        <div class="input-placeholder">
                                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter your Email." required/>
                                            <i class="fa fa-envelope"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12 form-group ">
                                        <label for="subject">Subject : </label>
                                        <div class="input-placeholder">
                                            <input type="text" id="subject" name="subject" class="form-control" placeholder="Enter your Subject." required/>
                                            <i class="fa fa-pencil-square-o"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12 form-group ">
                                        <label for="comments">Message : </label>
                                        <div class="input-placeholder">
                                            <textarea id="comments" name="comments" class="form-control" rows="8" placeholder="Enter your Message." required></textarea>
                                            <i class="fa fa-comment"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12"><input value="Submit" type="submit"></div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <ul class="contact-form-text">
                                <li>
                                    <h4>Send Us Message !!!</h4>
                                    <p>Lorem ipsum dolor sit amet, consectet adipiscing elit. Ut ac malesuada antes urabitur lacinia</p>
                                </li>
                                <li>
                                    <h4>Open Practices</h4>
                                    <p>Lorem ipsum dolor sit amet, consectet adipiscing elit. Ut ac malesuada antes urabitur lacinia</p>
                                    <time datetime="2008-02-14 20:00">Timings: <span>9:00am to 12:00pm</span></time>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once realpath(__DIR__ . '/..') . '/includes/footer.php'; ?>
