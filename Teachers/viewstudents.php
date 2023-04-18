<?php
session_start();
include '../includes/Operations.php';
$obj = new Operations();
$msg = ['error' => '', 'content' => ''];

//Checking if logined - impLying username exists
// if (!isset($_SESSION['username'])) {
//   header('location: ../login.php');
// }

//checking account type
// if ($_SESSION['accType'] == 'SuperAdmin') {
//   header('location: admin/index');
// } elseif ($_SESSION['accType'] == 'Student') {
//   header('location: student/index');
// } elseif ($_SESSION['accType'] == 'Staff') {
//   header('location: staff/index');
// }

//Delete a row
if (isset($_GET['id'])) {
  $obj->ID = $_GET['id'];
  // $result = $obj->deleteStudent();
  echo $result;
}
?>

<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from www.einfosoft.com/templates/admin/COMP TECH/source/light/advance-table.php by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 21 Dec 2022 15:02:49 GMT -->

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>School Management Information System</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/css/app.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='assets/img/unsalogo.png' />
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
                  <div class="card-header">
                    <h4></h4>
                  </div>
                  <h4 style="text-align: center;">ALL REGISTERED STUDENTS</h4>
                  <?php
                  $obj = new Operations();
                  $result = $obj->retrieveAllStudents();
                  ?>
                  <div class="card-body">
                    <div class="table-responsive">
                      <?php if (is_array($result)) { ?>
                        <table class="table table-striped table-md">
                          <tr>
                            <th>S/N</th>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th>SCHOOL</th>
                            <th>LIN</th>
                            <th>CONTACT</th>
                            <th>CLASS</th>
                            <th>IMAGE</th>
                            <th>ACTION</th>
                          </tr>

                          <?php
                          $t = 0;
                          foreach ($result as $res) {
                            $t++; ?>
                            <tr>
                              <td><?= $res['sn'] ?></td>
                              <td><?= $res['stud_name'] ?></td>
                              <td><?= $res['email'] ?></td>
                              <td><?= $res['school_name'] ?></td>
                              <td><?= $res['LIN'] ?></td>
                              <td><?= $res['contact'] ?></td>
                              <td><?= $res['class_name'] ?></td>
                              <td><?= $res['image'] ?></td>
                              <td>
                                <a href="editstudent.php?id=<?= $res['ID'] ?>"><button class="btn btn-success">Edit</button></a>
                                <a href="viewstudent.php?id=<?= $res['ID'] ?>
                                "><button class="btn btn-danger">Delete</button></a>
                              </td>
                            </tr>
                          <?php
                          }
                          ?>
                        </table> <?php } else {
                                  ?><center><?php
                                            echo 'NO REGISTERED STUDENT';
                                            ?></center> <?php
                                                      } ?>
                    </div>
                  </div>
                </div>
              </div>
              <?php
              include '../includes/panelstyle.php';
              ?>
              <!-- General JS Scripts -->
              <script src="assets/js/app.min.js"></script>
              <!-- JS Libraies -->
              <script src="assets/bundles/jquery-ui/jquery-ui.min.js"></script>
              <!-- Page Specific JS File -->
              <script src="assets/js/page/advance-table.js"></script>
              <!-- Template JS File -->
              <script src="assets/js/scripts.js"></script>
              <!-- Custom JS File -->
              <script src="assets/js/custom.js"></script>
</body>

</html>