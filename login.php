<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>System Tabulation</title>

    <link rel="shortcut icon" href="./dist/img/favicon.ico" type="image/x-icon">

    <link href="./dist/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="./dist/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="./dist/css/style.css" rel="stylesheet">

    <style>
        body {
            background-image: url("./dist/img/bg_2.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center align-items-center" style="height: 100vh">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block essu-logo border">
                                <!-- ESSU Logo -->
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user" action="javascript:void(0)" id="login_form">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="login_username" placeholder="Enter Username" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="login_password" placeholder="Enter Password" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="login_remember_me">
                                                <label class="custom-control-label" for="login_remember_me">Remember Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block" id="login_submit">Login</button>
                                        <hr>
                                        <a href="javascript:void(0)" class="btn btn-google btn-user btn-block under_maintenance">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="javascript:void(0)" class="btn btn-facebook btn-user btn-block under_maintenance">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small under_maintenance" href="javascript:void(0)">Forgot Password?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="./dist/vendor/jquery/jquery.min.js"></script>
    <script src="./dist/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./dist/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="./dist/js/sb-admin-2.min.js"></script>
    <script src="./plugins/sweetalert/sweetalert.js"></script>

    <script>
        $(document).ready(function() {
            var alert = <?= isset($_SESSION["alert"]) ? json_encode($_SESSION["alert"]) : json_encode(null) ?>;

            if (alert) {
                sweetalert(alert);
            }

            $(".under_maintenance").click(function() {
                Swal.fire({
                    title: "Under Maintenance",
                    text: "This feature is under maintenance!",
                    icon: "warning"
                });
            })

            $("#login_form").submit(function() {
                var username = $("#login_username").val();
                var password = $("#login_password").val();

                $("#login_submit").attr("disabled", true);
                $("#login_submit").text("Processing Request...");

                var formData = new FormData();

                formData.append('username', username);
                formData.append('password', password);
                formData.append('login', true);

                $.ajax({
                    url: 'server.php',
                    data: formData,
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        location.href = "./";
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            })

            function sweetalert(alert) {
                Swal.fire({
                    title: alert.title,
                    text: alert.message,
                    icon: alert.type
                });
            }
        })
    </script>
</body>

</html>

<?php unset($_SESSION["alert"]) ?>