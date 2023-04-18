<div id="app">
  <div class="main-wrapper main-wrapper-1">
    <div class="navbar-bg"></div>
    <nav class="navbar navbar-expand-lg main-navbar sticky">
      <div class="form-inline me-auto">
        <ul class="navbar-nav mr-3">
        </ul>
      </div>
      <li><a href="/UNS/corso/index.php"><button class="btn btn-primary">WEBSITE</button></a>
      <li>
        <ul>
          <li class="dropdown"><a href="#" data-bs-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="assets/img/user.png" class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>

            <div class="dropdown-menu dropdown-menu-right pullDown">
              <?php
              $username = $_SESSION['username'];
              ?>
              <div class="dropdown-title">Hello <?= $obj->getAdminNameByEmail($username) ?></div>
              <a href="profile" class="dropdown-item has-icon"><i class="far
										fa-user"></i> Profile
              </a> <a href="timeline" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i>
                Activities
              </a> <a href="#" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                Settings
              </a>
              <div class="dropdown-divider"></div>
              <a href="../logout.php" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                Logout
              </a>
          </li>
        </ul>
  </div>
  </nav>
  <div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="dashboard"> <img alt="image" src="assets/img/logos.jpeg" class="header-logo" /> <span class="logo-name">ALSSC</span>
        </a>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header"></li>
        <li><b>NAVIGATE FROM HERE</b></li>
        <li class="dropdown">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="umbrella"></i><span>SCHOOL</span></a>
          <ul class="dropdown-menu">
            <!-- <li><a href="createStudentSchoolHistory.php">Add School</a></li> -->
            <li><a href="viewstudsch.php">View Schools</a></li>

          </ul>
        </li>

        <li class="dropdown">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="monitor"></i><span>PROJECTYPES</span></a>
          <ul class="dropdown-menu">
            <li><a href="createprojectype.php">Add Project types</a></li>
            <li><a href="viewprojectypes.php">All Project Types</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="monitor"></i><span>PROJECTS</span></a>
          <ul class="dropdown-menu">
            <li><a href="createproject.php">Register project</a></li>
            <li><a href="viewprojects.php">View All Registered projects</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="monitor"></i><span>RESULTS</span></a>
          <ul class="dropdown-menu">
            <!-- <li><a href="createschool.php">Register Results</a></li> -->
            <li><a href="viewresults.php">View All Registered results</a></li>
          </ul>
        </li>

        <li class="dropdown">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="users"></i><span>STUDENTS</span></a>
          <ul class="dropdown-menu">
            <li><a href="viewstudents.php">View All Registered Students</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="briefcase"></i><span>SUBJECTS</span></a>
          <ul class="dropdown-menu">
            <li><a href="createsubjects.php">Add Subject</a></li>
            <li><a href="viewsubjects.php">View All Subjects</a></li>
          </ul>
        </li>

        <li class="dropdown">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="users"></i><span>PROJECT MARKS</span></a>
          <ul class="dropdown-menu">
            <li><a href="createproj_marks.php">Create Project marks</a></li>
            <li><a href="viewprojectmarks.php">View Project marks</a></li>
          </ul>
        </li>
      </ul>
      </li>
      </ul>
    </aside>
  </div>