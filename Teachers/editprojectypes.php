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
$data = $obj->getProjectTypeWithId();

if (isset($_POST['update'])) {
  $obj->project_types = $_POST['project_types'];
  $obj->groups = $_POST['group'];
  $obj->individual =  $_POST['individual'];
  $username = $_SESSION['username']; 
  $obj->modifiedby = $obj->getAdminIDByEmail($username);
  $obj->modified = $obj->getDateandTime();

  //  call function to update
  $record = $obj->updateProjectType();
  if ($record == PROJECTTYPE_UPDATED) {
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
                          <label for="frist_name">Project Type</label>
                          <input type="text" class="form-control" name="project_types" autofocus autocomplete="off" value="<?= $data['project_types'] ?>">
                        </div>
                        <div class="form-group col-6">
                          <label for="codescription">Group</label>
                          <input id="codescription" type="text" class="form-control" name="group" autocomplete="off" value="<?= $data['groups'] ?>">
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-12">
                          <label for="frist_name">Individual</label>
                          <input id="frist_name" type="text" class="form-control" name="individual" autofocus autocomplete="off" value="<?= $data['individual'] ?>">
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn btn-success btn-lg btn-block" name="update">
                            EDIT PROJECT TYPES
                          </button>
                        </div>
                    </form>
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