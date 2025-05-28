<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Adublisher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo ASSETURL . 'plugins/toastr/toastr.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo ASSETURL . 'css/bulstyle.css'; ?>">
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
    <div class="container-fluid p-0 m-0 overflow-xx-hidden">
        <div class="row">
            <div class="col-12 col-lg-5 p-0 justify-self d-grid align-items-center p-4">
                <div class="signup__container">
                    <div class="signup__logo">
                        <a href="<?php echo SITEURL; ?>">
                            <img src="<?php echo ASSETURL . 'images/logo.svg'; ?>" alt="">
                        </a>
                    </div>
                    <div class="text-wrapper">
                        <h1>
                            Get Started
                        </h1>
                        <form action="" class="signup__input__form">
                            <div class="field">
                                <label for="text">Email</label>
                                <input type="text" class="signup__input" name="email" placeholder="Enter your email address">
                            </div>
                            <div class="field">
                                <label for="text">Password</label>
                                <input type="password" class="signup__input" name="password" placeholder="Atleast 8 characters">
                                <input type="hidden" name="gmt" id="gmt">
                            </div>
                            <button class="btn signup__btn">Sign Up</button>
                        </form>
                        <div class="signup__text__content">
                            <p>
                                Already have an account?
                                <a href="<?php echo SITEURL . 'login'; ?>"> Sign in</a>
                            </p>
                        </div>
                    </div>
                    <div class="signup__bottom">
                        <div class="text-wrapper">
                            <p class="small-desc p-0 m-0">
                                © 2015–2024 TRUE BREATHE MEDIA (SMC-PRIVATE) LIMITED <a href="../Privacy/Terms.html">Terms</a> and <a href="../Privacy/Privacy.html">Privacy</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-7 m-0 p-0 d-none d-lg-flex position-relative">
                <div class="dolottie">
                    <div class="sticky-content">
                        <img src="<?php echo ASSETURL . 'images/signuppage-Welcome.svg'; ?>" class="h-100 w-100">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/lenis@1.1.9/dist/lenis.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo ASSETURL . 'plugins/toastr/toastr.min.js'; ?>"></script>
    <script src="<?php echo ASSETURL . 'js/main.js'; ?>"></script>
    <script>
        $("#gmt").val(Intl.DateTimeFormat().resolvedOptions().timeZone);

        function alertbox(heading, message, type) {
            if (type == 'success') {
                toastr.success(message);
            }
            if (type == 'error') {
                toastr.error(message);
            }
            if (type == 'warning') {
                toastr.warning(message);
            }
        }

        $(document).on('click', '.signup__btn', function() {
            var dataObj = {
                "email": $('input[name="email"]').val(),
                "password": $('input[name="password"]').val(),
                "package_id": "",
                "gmt": $("#gmt").val(),
                "action": "register",
            }
            $(this).attr('disabled', true);
            $.ajax({
                url: '<?php echo FRONTVIEW; ?>/controller.php',
                type: 'POST',
                data: dataObj,
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.type == 'error') {
                        $('.signup__btn').attr('disabled', false);
                        alertbox('Error', response.message, 'error');
                    } else {
                        alertbox('Success', response.message, 'success');
                        setTimeout(function() {
                            window.location.href = response.redirect;
                        }, 2000); // 5000 milliseconds = 5 seconds
                    }
                }
            });
        });
    </script>
</body>

</html>