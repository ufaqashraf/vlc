<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>Home</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <!-- FontAwsome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <!-- Bootstrap Select CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css" rel="stylesheet">

    <!-- Open Sans Font CSS -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <!--All styles-->
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/css/style.css'; ?>">
    <!--Responsive styles-->
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/css/responsive.css'; ?>">
</head>
<body>
<div class="signup-wrapper">
    <div class="signup-header">
        <div class="signup-wrap">
            <div class="logo-signup"><a href="<?php echo base_url(); ?>"> <img src="<?php echo UPLOADS_URL . '/settings/' . HEADER_LOGO; ?>" alt="Logo"> </a></div>
        </div>
    </div>
    <div class="signup-container">
        <div class="signup-wrap">
            <div class="inner-signup">
                <h1>Login To Volgo Point</h1>
                <div class="row social-Btns"><div class="col-sm-6">
                            <a href="<?php echo $fb_login_url; ?>" class="btn btn-block btn-social btn-facebook">
                                <i class="fa fa-facebook"></i> Login with facebook
                            </a>
                        </div>
                    <div class="col-sm-6">
                        <a class="btn btn-block btn-social btn-google-plus">
                            <i class="fa fa-google-plus"></i> Login with Google
                        </a>
                    </div>
                </div>
                <p class="custome-signupTxt">Or Login with your email</p>
                <?php if (!empty($validation_errors)): ?>
                    <div class="alert alert-danger">
                        <?php echo $validation_errors; ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($this->session->flashdata('success_msg'))): ?>
                    <div class="alert alert-success">
                        <div><?php echo $this->session->flashdata('success_msg'); ?></div>
                    </div>
                <?php endif; ?>

				<?php

					$redirected_to = $this->input->get('redirected_to');
					$action_url = empty($redirected_to) ? base_url('users/user_login') : base_url('users/user_login?redirected_to=' . $redirected_to);


				?>

                <form class="needs-validation" action="<?php echo $action_url; ?>" method="post" novalidate>
                    <fieldset>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="textField"><label class="sidebarTitle" for="validationCustom03">Enter your Email</label>

                                    <input id="validationCustom03" type="email" name="user_email" id="user_email" class="form-control" placeholder="Type Email Here" required>
                                    <div class="invalid-feedback">Email is requied</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="textField"><label class="sidebarTitle" for="validationCustom04">Enter your Password</label>
                                    <input id="validationCustom04" type="password" name="user_password" id="user_password" class="form-control" placeholder="Type Password Here" required>
                                    <div class="invalid-feedback">Password is requied</div>
                                    <a id="forgotPassword" href="<?php echo base_url() . 'users/forget_password';?>">Forget Password?</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input class="signup-btn" type="submit" value="Login">
                                <p class="custome-signupTxt">Not registered yet?    <a href="<?php echo empty($redirected_to) ? base_url('signup') : base_url('signup?redirected_to=' . $redirected_to); ?>">Create account</a></p>
                            </div>
                        </div>
            </div>
            </fieldset>
            </form>
        </div>
    </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>

<!--custom JS -->

<script type="text/javascript" src="<?php echo base_url() . 'assets/js/TelInput.js';?>"></script>
<script>
    $("#mobile-number").intlTelInput();
</script>

<script>

    (function() {
        'use strict';
        window.addEventListener('load', function() {
// Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
// Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

</script>
</body>
</html>
