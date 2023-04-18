<?php
session_start();
date_default_timezone_set('Africa/Kampala');
include '../includes/Operations.php';
$obj = new Operations();
$msg = ['error' => '', 'content' => ''];

/// // //Checking if logined - implying username exists
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

$obj->ID = $_GET['id'];
$data = $obj->getSubjectById();

if (isset($_POST['update'])) {
  $obj->sub_name = $_POST['sub_name'];
  $username = $_SESSION['username'];
  $obj->modifiedby = $obj->getAdminIDByEmail($username);
  $obj->modified = $obj->getDateandTime();

  $test = $obj->updateSubject();
  // exit();
  // $data = $obj->getSubjectById();

  //  call function to update
  // $test = $obj->updateTest();
  // if ($test == TEST_UPDATED) {
  //   $msg['error'] = false;
  //   $msg['content'] = 'Student updated successfully';
  // } else {
  //   $msg['error'] = true;
  //   $msg['content'] = 'Student update failed';
  // }
  exit();
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

<body>
  <?php include '../includes/sheader.php'; ?>
  <!-- Main Content -->
  <div class="main-content">
    <!-- <div class="loader"></div> -->
    <div id="app">
      <div class="section-body">
        <section class="section">
          <div class="containers">
            <div class="row">
              <div class="col-12">
                <div class="card card-success">
                  <div class="card-header">
                    <h4>EDIT STUDENTS DETAILS</h4>
                  </div>
                  <div class="card-body">
                    <div class="card-body">
                      <form method="POST">
                        <div class="row">
                          <div class="form-group col-12">
                            <label for="frist_name">Subject Name</label>
                            <input type="text" class="form-control" name="sub_name" autofocus autocomplete="off" value="<?= $data['sub_name'] ?>">
                          </div>
                          <div class="form-group">
                            <button type="submit" class="btn btn-success btn-lg btn-block" name="update">
                              ADD
                            </button>
                          </div>
                      </form>
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

</html>