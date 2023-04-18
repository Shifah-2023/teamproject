<?php
session_start();
date_default_timezone_set('Africa/Kampala');
include '../includes/Operations.php';
$obj = new Operations();
$msg = ['error' => '', 'content' => ''];

// // //Checking if logined - implying username exists
// if (!isset($_SESSION['username'])) {
//   header('location: ../login.php');
// }

// // //checking account type
// if ($_SESSION['accType'] == 'SuperAdmin') {
//   header('location: admin/index');
// } elseif ($_SESSION['accType'] == 'Student') {
//   header('location: student/index');
// } elseif ($_SESSION['accType'] == 'Staff') {
//   header('location: staff/index');
// }

if (isset($_POST['submit'])) {
  $obj->sub_name = $_POST['sub_name'];
  $obj->createdby = $obj->getAdminIDByEmail($username);
  $obj->created = $obj->getDateandTime();

  echo $subjects = $obj->createSubjects();

  if ($school == SUBJECT_CREATED) {
    $msg['error'] = false;
    $msg['content'] = 'School created successfully';
  } else {
    $msg['error'] = true;
    $msg['content'] = 'School creation failed';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>School Management Information System</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/css/app.min.css">
  <link rel="stylesheet" href="assets/bundles/jquery-selectric/selectric.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='assets/img/logos.jpeg' />
</head>
<!-- hjhshshh -->

<body>
  <?php include '../includes/sheader.php'; ?>

  <!-- Main Content -->
  <div class="main-content">
    <!-- <div class="loader"></div> -->
    <div id="app">
      <section class="section">
        <div class="container ">
          <div class="row">
            <div class="col-12">
              <div class="card card-success">
                <div class="card-header">
                  <center>
                    <?php if ($msg['error'] != '') {
                      if ($msg['error'] == false) { ?>
                        <div class="alert alert-success alert-dicorsosible show fade">
                          <div class="alert-body">
                            <button class="close" data-dicorsos="alert">
                              <span>&times;</span>
                            </button>
                            <?= $msg['content'] ?>
                          </div>
                        </div>
                      <?php } else { ?>
                        <div class="alert alert-danger alert-dicorsosible show fade">
                          <div class="alert-body">
                            <button class="close" data-dicorsos="alert">
                              <span>&times;</span>
                            </button>
                            <?= $msg['content'] ?>
                          </div>
                        </div>
                    <?php }
                    } ?>
                  </center>
                </div>
                <h4 style="text-align: center;">ADD SUBJECT</h4>
                <div class="card-body">
                  <form method="POST">
                    <div class="row">
                      <div class="form-group col-12">
                        <label for="frist_name">Subject Name</label>
                        <input type="text" class="form-control" name="sub_name" autofocus autocomplete="off">
                      </div>
                      <div class="form-group">
                        <button type="submit" class="btn btn-success btn-lg btn-block" name="submit">
                          ADD
                        </button>
                      </div>
                  </form>
      </section>
    </div>
    <?php
    include '../includes/panelstyle.php';
    ?>
    <!-- General JS Scripts -->
    <script src="assets/js/app.min.js"></script>
    <!-- JS Libraies -->
    <script src="assets/bundles/jquery-pwstrength/jquery.pwstrength.min.js"></script>
    <script src="assets/bundles/jquery-selectric/jquery.selectric.min.js"></script>
    <!-- Page Specific JS File -->
    <script src="assets/js/page/auth-register.js"></script>
    <!-- Template JS File -->
    <script src="assets/js/scripts.js"></script>
    <!-- Custom JS File -->
    <script src="assets/js/custom.js"></script>
</body>

</html>