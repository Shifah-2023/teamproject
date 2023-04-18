<?php
session_start();
include './includes\Operations.php';
$obj = new Operations();
$msg = ['error' => '', 'content' => ''];
// $_SESSION['username'] = 'Eunice';
// $_SESSION['accType'] = 'Staff';

//check login (accType, username)
if (isset($_SESSION['username'])) {
  if ($_SESSION['accType'] == 'SuperAdmin') {
    header('location: admin/index.php');
  } elseif ($_SESSION['accType'] == 'Student') {
    header('location: student/index.php');
  } elseif ($_SESSION['accType'] == 'Staff') {
    header('location: staff/index.php');
  }
}

if (isset($_POST['login'])) {
  $obj->email = $_POST['us'];
  $obj->password = $_POST['pw'];

  if ($obj->slogin() == SCHOOL_ADMIN_AUTHENTICATED) {
    $_SESSION['username'] = $obj->email;
    $_SESSION['password'] = $obj->password;
    $_SESSION['accType'] = 'Teachers';
    header('location: Teachers/index.php');
  } else {
    $msg['error'] = true;
    $msg['content'] = 'Invalid Login Credentials';
  }
}

?>
<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from www.einfosoft.com/templates/admin/otika/source/light/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 21 Dec 2022 15:00:26 GMT -->

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>School Information Management System</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="./schadmin/assets/css/app.min.css">
  <link rel="stylesheet" href="./schadmin/bundles/bootstrap-social/bootstrap-social.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="./schadmin/assets/css/style.css">
  <link rel="stylesheet" href="./schadmin/assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="./schadmin/assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='assets/img/favicon.ico' />
</head>

<body>
  <div></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-6 col-sm-8 offset-sm-2 col-xl-4 offset-xl-4">
            <div class="card card-success">
              <div class="card-header">
                <h4>20% MANAGEMENT SYSTEM</h4>
              </div>
              <div class="card-body">
                <?php if ($msg['error'] == true) { ?>
                  <div class="alert alert-danger alert-dicorsosible show fade">
                    <div class="alert-body">
                      <button class="close" data-dicorsos="alert">
                        <span>&times;</span>
                      </button>
                      <?= $msg['content'] ?>
                    </div>
                  </div>

                <?php } ?>
                <form method="POST" action="#" class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="email">Username</label>
                    <input id="email" type="email" class="form-control" name="us" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Please fill in your email
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                      <div class="float-right">
                        <a href="auth-forgot-password.html" class="text-small">
                          Forgot Password?
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="pw" tabindex="2" required>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="login" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js/custom.js"></script>
</body>


<!-- Mirrored from www.einfosoft.com/templates/admin/otika/source/light/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 21 Dec 2022 15:00:26 GMT -->

</html>