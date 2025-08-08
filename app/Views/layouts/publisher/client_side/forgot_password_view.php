<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/*" href="<?= LANDINGASSETS ?>images/fav/favicon.ico?v=1.2" />
    <title>Forgot Password | Adublisher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="<?php echo GeneralAssets . 'plugins/toast-master/css/jquery.toast.css'; ?>">
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?php echo NewLandingAssets . 'bulstyle.css'; ?>">
    <style>
        .jq-toast-wrap.top-right {
            right: 40px !important;
        }

        .jq-toast-wrap {
            width: 300px !important;
        }
    </style>
</head>

<body>
    <div class="container-fluid m-0 p-0 overflow-xx-hidden">
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-10 col-md-8 col-lg-5 mx-auto">
                <div class="forgot_password_container my-auto py-5 px-5 px-lg-0">
                    <div class="p-5 border rounded">
                        <div class="text-center">
                            <a href="<?php echo SITEURL . 'landing-page'; ?>">
                                <img src="<?php echo NewLandingAssets . 'images/logo.svg'; ?>" alt="">
                            </a>
                        </div>
                        <div class="text-wrapper">
                            <div class="text-center">
                                <h3>
                                    <strong>
                                        Forgot Password?
                                    </strong>
                                </h3>
                                <p class="text-muted para">To reset your password, simply enter your
                                    email address.</p>
                            </div>
                            <div class="signup__input__form">
                                <div class="field">
                                    <label for="text">Email</label>
                                    <input type="text" class="signup__input" name="email"
                                        placeholder="Enter your email address">
                                </div>
                                <button class="btn reset_btn">Reset Password</button>
                            </div>
                            <div class="text-center">
                                <p class="text-muted para">Remmeber password? <a class="text-dark"
                                        href="<?php echo SITEURL . 'login'; ?>">Back to Login</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/lenis@1.1.9/dist/lenis.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="<?php echo GeneralAssets . 'plugins/toast-master/js/jquery.toast.js'; ?>"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo NewLandingAssets . 'main.js'; ?>"></script>
    <script>
        function alertbox(heading, message, type) {
            $.toast({
                heading: heading,
                showHideTransition: 'slide',
                text: message,
                position: 'top-right',
                allowToastClose: true,
                icon: type,
                loader: true,
                hideAfter: 5000,
                stack: 1
            });
        }

        $(document).on('click', '.reset_btn', function () {
            $(this).attr('disabled', true);
            var dataObj = {
                "action": "uResetPass",
                "email": $('input[name="email"]').val(),
            }
            $.ajax({
                url: '<?php echo FRONTVIEW; ?>/controller.php',
                type: 'POST',
                data: dataObj,
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.type == 'error') {
                        $('.reset_btn').attr('disabled', false);
                        alertbox('Error', response.message, 'error');
                    }
                    else {
                        alertbox('Success', response.message, 'success');
                        setTimeout(function(){
                            window.location.href = "<?php echo SITEURL . 'login'; ?>";
                        }, 2000);
                    }
                }
            });
        });
    </script>
</body>

</html>