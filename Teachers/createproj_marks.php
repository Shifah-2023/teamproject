<?php
session_start();
date_default_timezone_set('Africa/Kampala');
include '../includes/Operations.php';
$obj = new Operations();
$msg = ['error' => '', 'content' => ''];

// // //Checking if logined - implying username exists
if (!isset($_SESSION['username'])) {
  header('location: ../login.php');
}

// // //checking account type
if ($_SESSION['accType'] == 'SuperAdmin') {
  header('location: admin/index');
} elseif ($_SESSION['accType'] == 'Student') {
  header('location: student/index');
} elseif ($_SESSION['accType'] == 'Staff') {
  header('location: staff/index');
}

if (isset($_POST['submit'])) {
  $obj->pro_details_id = $_POST['pro_details_id'];
  $obj->marks = $_POST['marks'];
  $username = $_SESSION['username'];
  $obj->createdby =  $obj->getAdminIDByEmail($username);
  $obj->created = $obj->getDateandTime();
  echo $class = $obj->createProjectMarks();

  // // messages
  // if ($class == CLASS_CREATED) {
  //   $msg['error'] = false;
  //   $msg['content'] = 'Class created successfully';
  // } else {
  //   $msg['error'] = true;
  //   $msg['content'] = 'Class creation failed';
  // }
  // exit();
}
?>
<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from www.einfosoft.com/templates/admin/COMP TECH/source/light/auth-register.php by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 21 Dec 2022 15:03:37 GMT -->

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

<body>
  <?php include '../includes/sheader.php'; ?>
  <div class="main-content">
    <section class="section">
      <div class="container ">
        <div class="row">
          <div class="col-12">
            <div class="card card-success">
              <div class="card-header">
              </div>
              <h4 style="text-align: center;">ADD PROJECT MARKS</h4>
              <div class="card-body">
                <form method="POST">
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="frist_name">Marks</label>
                      <input type="text" class="form-control" name="marks" autofocus autocomplete="off">
                    </div>
                    <div class="form-group col-6">
                      <label for="frist_name">Project_details</label>
                      <input type="text" class="form-control" name="pro_details_id" autofocus autocomplete="off">
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-success btn-lg btn-block" name="submit">
                        ADD CLASS DETAILS
                      </button>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
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


<!-- Mirrored from www.einfosoft.com/templates/admin/COMP TECH/source/light/auth-register.php by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 21 Dec 2022 15:03:37 GMT -->

</html>