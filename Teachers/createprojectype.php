<?php
session_start();
date_default_timezone_set('Africa/Kampala');
include '../includes/Operations.php';
$obj = new Operations();
$msg = ['error' => '', 'content' => ''];


// $_SESSION['username'] = 'Eunice';
// $_SESSION['accType'] = 'Staff';
// check login (accType, username)
if (!isset($_SESSION['username'])) {
  header('location: ../login.php');
}

//checking account type
if ($_SESSION['accType'] == 'SuperAdmin') {
  header('location: admin/index');
} elseif ($_SESSION['accType'] == 'Student') {
  header('location: student/index');
} elseif ($_SESSION['accType'] == 'Staff') {
  header('location: staff/index');
}


// declare the username u used to login into the session
if (isset($_POST['submit'])) {
  $obj->project_types = $_POST['project_types'];
  $obj->groups = $_POST['group'];
  $obj->individual =  $_POST['individual'];
  $username = $_SESSION['username'];
  // $obj->createdby = $obj->getAdminIDByEmail($username); #create this function using users table
  // $obj->created = $obj->getDateandTime();
  $data = $obj->createProjectType();
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
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                  <center>
                    <?php
                    if ($msg['error'] == true) { ?>

                      <div class="alert alert-success alert-dicorsosible fade show" role="alert">
                        <strong>Hey! </strong><?= $msg['content']; ?>
                        <button type="button" class="close" data-dicorsos="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    <?php
                    }
                    ?>
                  </center>
                  <div class="card-header">
                  </div>
                  <h4 style="text-align: center;">ADD PROJECT TYPES</h4>
                  <div class="card-body">
                    <form method="POST">
                      <div class="row">
                        <div class="form-group col-6">
                          <label for="frist_name">Project Type</label>
                          <input type="text" class="form-control" name="project_types" autofocus autocomplete="off">
                        </div>
                        <div class="form-group col-6">
                          <label for="codescription">Group</label>
                          <input id="codescription" type="text" class="form-control" name="group" autocomplete="off">
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-12">
                          <label for="frist_name">Individual</label>
                          <input id="frist_name" type="text" class="form-control" name="individual" autofocus autocomplete="off">
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn btn-success btn-lg btn-block" name="submit">
                            ADD PROJECT TYPES
                          </button>
                        </div>
                    </form>
                  </div>
        </section>
      </div>
      <?php
      include '../includes/panelstyle.php';
      include '../includes/scripts.php';
      ?>
</body>

</html>