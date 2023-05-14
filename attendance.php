<?php
require 'functions/common.php';

session_start();
if(!isset($_SESSION['user_name'])){
    header('Location:signin.php');
    exit;
}


//Grab all the student from our database
$student = $database->select("student", [
    'id',
    'name',
    'rfid_uid'
]);

?>

<?php
//Check if we have a year passed in through a get variable, otherwise use the current year
if (isset($_GET['year'])) {
    $current_year = int($_GET['year']);
} else {
    $current_year = date('Y');
}

//Check if we have a month passed in through a get variable, otherwise use the current year
if (isset($_GET['month'])) {
    $current_month = $_GET['month'];
} else {
    $current_month = date('n');
}

//Calculate the amount of days in the selected month
$num_days = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> SVCI ComLab An Internet of Things System </title>
    <link rel="stylesheet" href="css/style.attendance.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="icon" href="images/svci.icon.png" type="image/x-icon">
     <script src="js/bootstrap.min.js"></script>
    </head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <img src="images/svci.png.png" alt="SVCI LOGO">
      <span class="logo_name">SVCI | ComLab An IoT</span>
    </div>
      <ul class="nav-links">
        <li>
          <a href="index.php">
            <i class='bx bx-grid-alt' ></i>
            <span class="links_name">Dashboard</span>
          </a>
        </li>
        <li>
          <a href="student.php">
            <i class='bx bx-box' ></i>
            <span class="links_name">Students</span>
          </a>
        </li>
        <li class="log_out">
          <a href="functions/logout.php">
            <i class='bx bx-log-out'></i>
            <span class="links_name">Log out</span>
          </a>
        </li>
      </ul>
  </div>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Attendance</span>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search...">
        <i class='bx bx-search' ></i>
      </div>
      <div class="profile-details">
        <i class='bx bx-user'></i>
        <span> <?php echo $_SESSION['user_name'] ?></span>
        <i class='bx bx-chevron-down' ></i>
      </div>
    </nav>
    <div class="home-content">
      <div class="title">RADIO-FREQUENCY IDENTIFICATION INFORMATION</div>
        <div class="attendance box">
          <table class="table table-striped table-responsive">
              <thead class="thead-dark">
                  <tr>
                      <th scope="col">Name</th>
                      <?php
                          //Generate headers for all the available days in this month
                          for ( $iter = 1; $iter <= $num_days; $iter++) {
                            echo '<th scope="col" style="min-width:150px;max-width:250px;">' . $iter . '</th>';
                          }
                      ?>
                  </tr>
              </thead>
              <tbody>
                  <?php
                      //Loop through all our available student
                      foreach($student as $user) {
                          echo '<tr>';
                          echo '<td scope="row">' . $user['name'] . '</td>';

                          //Iterate through all available days for this month
                          for ( $iter = 1; $iter <= $num_days; $iter++) {

                              //For each pass grab any attendance that this particular user might of had for that day
                              $attendance = $database->select("attendance", [
                                  'clock_in'
                              ], [
                                  'user_id' => $user['id'],
                                  'clock_in[<>]' => [
                                      date('Y-m-d', mktime(0, 0, 0, $current_month, $iter, $current_year)),
                                      date('Y-m-d', mktime(24, 60, 60, $current_month, $iter, $current_year))
                                  ]
                              ]);

                              //Check if our database call actually found anything
                              if(!empty($attendance)) {
                                  //If we have found some data we loop through that adding it to the tables cell
                                  echo '<td class="table-success">';
                                  foreach($attendance as $attendance_data) {
                                      echo $attendance_data['clock_in'] . '</br>';
                                  }
                                  echo '</td>';
                              } else {
                                  //If there was nothing in the database notify the user of this.
                                  echo '<td class="table-secondary">No Data Available</td>';
                              }
                          }
                          echo '</tr>';
                      }
                  ?>
              </tbody>
          </table>
    </div>
  </div>
  </section>
  <script src="js/script.dashboard.js"></script>
</body>
</html>
