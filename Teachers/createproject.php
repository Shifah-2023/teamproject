<?php
session_start();
date_default_timezone_set('Africa/Kampala');
include '../includes/Operations.php';
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


  if (isset($_POST['submit'])) {
    $array = [
      ($obj->username = $_POST['username']),
      ($obj->name = $_POST['project_name']),
      ($obj->project_type = $_POST['project_type']),
      // ($obj->subject_id = $_POST['subject_id']),
      ($obj->stud_id = $_POST['student_id']),

    ];
    //$obj->website = $_POST['website'];
    //$obj->districtID = $_POST['districtID'];
    $username = $_SESSION['username'];
    $obj->createdby = $obj->getAdminIDByEmail();
    $obj->created = $obj->getDateandTime();
    $create_pro = $obj->createProjects();
    if ($create_pro == PROJECT_CREATED) {
      $msg['error'] = true;
      $msg['content'] = "$obj->name,
      created successfully";
      $username = $_SESSION['username'];
      $id = $obj->getProjectIDByname();
    } elseif ($create_pro == PROJECT_EXISTS) {
      $msg['error'] = true;
      $msg['content'] = $obj->name . ' exists in the system';
    }
    if ($create_pro == PROJECT_CREATION_FAILED) {
      $msg['error'] = true;
      $msg['content'] = 'project NOT Created';
    }
    if ($insert_project == false) {
      echo 'error insert project';
    } else {
      $project_ID = $db->getproject_IDbyNameSubject();
      $insert_mark = $db->createProjectMark();

      if ($insert_mark == 'FALSE') {
        echo 'error inserting marks';
      } else {
        $insert_Details = $db->createProjectDetails();
        if ($insert_Details == 'FALSE') {
          echo 'error inserting Details';
        } else {
          echo 'succes';
        }
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>20% New curriculum tracking System</title>
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
                    <?php if ($msg['error'] == true) { ?>

                      <div class="alert alert-success alert-dicorsosible fade show" role="alert">
                        <strong>Hey! </strong><?= $msg['content'] ?>
                        <button type="button" class="close" data-dicorsos="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    <?php } ?>
                  </center>
                  <div class="card-header">
                  </div>
                  <h4 style="text-align: center;">REGISTER PROJECT </h4>
                  <div class="card-body">
                    <form method="POST">
                      <div class="row">
                        <div class="form-group col-6">
                          <label for="frist_name">Project Name</label>
                          <input type="text" class="form-control" name="project_name" autofocus autocomplete="off">
                        </div>
                        <div class="form-group col-6">
                          <label for="codescription">Project Type</label>
                          <select name="project_type" class="form-control form-select">
                            <option value="Group">Group</option>
                            <option value="Individual">Individual</option>
                          </select>

                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-6">
                          <label for="frist_name">Student Name</label>
                          <input id="frist_name" type="text" class="form-control" name="student_id" autofocus autocomplete="off">
                        </div>
                        <div class="form-group col-6">
                          <label for="codescription">Class</label>
                          <select name="Class" class="form-control form-select">
                            <option value="Form 1">Form 1</option>
                            <option value="Form 2">Form 2</option>
                            <option value="Form 3">Form 3</option>
                            <option value="Form 4">Form 4</option>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-6">
                          <label for="frist_name">Subject</label>
                          <select name="subject_ID" class="form-control form-select">
                            <option value="Biology">Biology</option>
                            <option value="Chemistry">Chemistry</option>
                            <option value="Physics">Physics</option>
                            <option value="Mathematics">Mathematics</option>
                            <option value="English">English</option>
                            <option value="Geography">Geography</option>
                            <option value="History">History</option>
                            <option value="Agriculture">Agriculture</option>
                            <option value="Kiswahili">Kiswahili</option>
                            <option value="Luganda">Luganda</option>
                            <option value="Entrepreneurship">Entrepreneurship</option>
                            <option value="ICT">ICT</option>
                            <option value="CRE">CRE</option>
                            <option value="Islam">Islam</option>
                          </select>
                        </div>
                        <div class="form-group col-6">
                          <label for="codescription">Marks</label>
                          <input id="codescription" type="text" class="form-control" name="Marks" autocomplete="off">
                        </div>
                      </div>
                      <div class=row>
                        <div class="form-group col-6">
                          <label for="codescription">Term</label>
                          <select name="term" class="form-control form-select">
                            <option value="term">term 1</option>
                            <option value="term">term 1</option>
                          </select>
                        </div>

                        <div class="form-group col-6">
                          <label for="codescription">Year</label>
                          <select name="project_type" class="form-control form-select">
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                          </select>

                        </div>
                      </div>
                      <!-- </div> -->
                      <div class="form-group">
                        <button type="submit" class="btn btn-success btn-lg btn-block" name="submit">
                          ADD PROJECT
                        </button>
                      </div>
                    </form>
        </section>
      </div>
      <?php include '../includes/panelstyle.php'; ?>
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