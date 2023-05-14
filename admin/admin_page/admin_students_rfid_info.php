<?php
require '../functions/common.php';
@include '../functions/config.php';

session_start();
if(!isset($_SESSION['admin_name'])){
    header('Location:../admin_signin.php');
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



if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete_query = "DELETE FROM student WHERE id = '$id'";
    $delete = $conn->query($delete_query);

}

?>


<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> SVCI | Administrator</title>
    <link rel="stylesheet" href="../css/style.student.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="icon" href="../images/svci.icon.png" type="image/x-icon">

    </head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <a href="admin_dashboard.php"><img src="../images/svci.png.png" alt="SVCI LOGO">
      </a>
      <span class="logo_name">Administrator</span>
    </div>
      <ul class="nav-links">
        <li>
          <a href="admin_dashboard.php">
            <i class='bx bx-grid-alt' ></i>
            <span class="links_name">Admin Dashboard</span>
          </a>
        </li>
        <li>
          <a>
            <i class='bx bx-box' ></i>
            <span class="links_name">Students Information</span>
          </a>
        </li>
        <li>
          <a href="admin_accounts.php">
            <i class='bx bx-list-ul' ></i>
            <span class="links_name">Accounts</span>
          </a>
        </li>
        <li class="log_out">
          <a href="../functions/logout.php">
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
        <span class="dashboard">Student's Information</span>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search...">
        <i class='bx bx-search' ></i>
      </div>
      <div class="profile-details">
        <i class='bx bx-user'></i>
         <?php echo $_SESSION['admin_name'] ?></span>
        <i class='bx bx-chevron-down' ></i>
      </div>
    </nav>
    <div class="home-content" >
      <div class="title">STUDENT RFID UID</div>
        <div class="attendance box">
          <table class="table table-striped table-responsive">
              <div class="st-boxes">
                <div class="student box">
                  <div class="container">
                      <table class="table table-striped">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">RFID UID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Created</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php
                              $sql = "SELECT * FROM `student`";
                              $result = mysqli_query($conn, $sql);
                              while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                  <td><?php echo $row["id"] ?></td>
                                  <td><?php echo $row["rfid_uid"] ?></td>
                                  <td><?php echo $row["name"] ?></td>
                                  <td><?php echo $row["created"] ?></td>
                                  <td>
                                    <a href="../edit/edit_students_uid.php?id=<?php echo $row["id"] ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
                                   <a href="admin_students_rfid_info.php?id=<?php echo $row["id"] ?>" class="link-dark" onclick="return confirm('Are you sure you want to delete this record?')"><i class="fa-solid fa-trash fs-5"></i></a>

                                  </td>
                                </tr>
                              <?php } ?>
                            </tbody>
                      </table>
                  </div>
              </div>
            </div>
          </table>
    </div>
  </div>

  <div class="home-content" >
    <div class="title">STUDENT'S ATTENDANCE</div>
      <div class="attendance box">
        <table class="table table-striped table-responsive">
          <table class="table table-striped">
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
    </table>
  </div>
</div>
</section>

  <script src="../js/script.dashboard.js"></script>
</body>
</html>
