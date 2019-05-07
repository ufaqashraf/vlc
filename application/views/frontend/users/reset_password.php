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
                <h1>Forgot your password?</h1>
                <p class="custome-signupTxt">Enter your email and we'll send you a  <br>link to create a new password
                </p>
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
                <form class="needs-validation" action="<?php echo base_url('users/verify_reset_password/' . $token); ?>" method="post" novalidate>
                    <fieldset>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="textField"><label class="sidebarTitle" for="validationCustom04">New Password</label>
                                    <input id="validationCustom04" type="password" name="password" id="password" class="form-control" placeholder="Type here">
                                    <div class="invalid-feedback">Password is requied</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="textField"><label class="sidebarTitle" for="validationCustom04">Confirm New Password</label>
                                    <input id="validationCustom04" type="password" name="confirm-password" id="confirm-password" class="form-control" placeholder="Type here">
                                    <div class="invalid-feedback">Password is requied</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input class="signup-btn" type="submit" value="Reset Password">
                                <p class="custome-signupTxt">&nbsp;</p>
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
