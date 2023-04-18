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
$data = $obj->getStudentWithId();

if (isset($_POST['update'])) {
  $obj->name = $_POST['name'];
  $obj->dob = $_POST['dob'];
  $obj->regno = $_POST['regno'];
  $obj->email = $_POST['email'];
  $obj->password = $_POST['pw'];
  $obj->districtID = $_POST['districtID'];
  $username = $_SESSION['username'];
  $obj->modifiedBy = $obj->getAdminIDByEmail($username);
  $obj->modified = $obj->getDateandTime();

  //  call function to update
  $record = $obj->updateStudent();
  if ($record == STUDENT_UPDATED) {
    $msg['error'] = false;
    $msg['content'] = 'Student updated successfully';
  } else {
    $msg['error'] = true;
    $msg['content'] = 'Student update failed';
  }
  // $myrecord = $obj->getStudentWithId();
  exit();
}

// exit();
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

                    <h4>EDIT STUDENTS DETAILS</h4>
                  </div>
                  <div class="card-body">
                    <form method="POST">
                      <div class="row">
                        <div class="form-group col-6">
                          <label for="frist_name">Students Name</label>
                          <input type="text" class="form-control" name="name" autofocus autocomplete="off" value="<?= $data['name'] ?>">
                        </div>
                        <div class="form-group col-6">
                          <label for="codescription">Date Of Birth</label>
                          <input id="codescription" type="date" class="form-control" name="dob" autocomplete="off" value="<?= $data['dob'] ?>">
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-6">
                          <label for="frist_name">Email</label>
                          <input id="frist_name" type="text" class="form-control" name="email" autofocus autocomplete="off" value="<?= $data['email'] ?>">
                        </div>
                        <div class="form-group col-6">
                          <label for="password">Password</label>
                          <input id="password" type="password" class="form-control" name="pw" autocomplete="off" value="<?= $data['password'] ?>">
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-6">
                          <label for="regno">REGNo</label>
                          <input id="regno" type="text" class="form-control" name="regno" autofocus autocomplete="off" value="<?= $data['regno'] ?>">
                        </div>
                        <div class="form-group col-6">
                          <label for="codescription">District ID</label>
                          <input id="codescription" type="text" class="form-control" name="districtID" autocomplete="off" value="<?= $data['districtID'] ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <button type="submit" class="btn btn-success btn-lg btn-block" name="update">
                          EDIT STUDENT
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