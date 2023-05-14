<?php
// require '../functions/common.php';
@include '../functions/config.php';

session_start();
if(!isset($_SESSION['admin_name'])){
    header('Location:../admin_signin.php');
    exit;
}

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete_query = "DELETE FROM admin_db WHERE id = '$id'";
    $delete = $conn->query($delete_query);

}

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete_query = "DELETE FROM user_db WHERE id = '$id'";
    $delete = $conn->query($delete_query);

}
?>

<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> SVCI | Administrator</title>
    <link rel="stylesheet" href="../css/style.attendance.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="icon" href="../images/svci.icon.png" type="image/x-icon">
    <script src="../js/scriptchart.js"></script>
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
          <a href="admin_students_rfid_info.php">
            <i class='bx bx-box' ></i>
            <span class="links_name">Students Information</span>
          </a>
        </li>
        <li>
          <a>
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
        <span class="dashboard">Accounts</span>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search...">
        <i class='bx bx-search' ></i>
      </div>
      <div class="profile-details">
        <i class='bx bx-user'></i>
        <span> <?php echo $_SESSION['admin_name'] ?></span>
        <i class='bx bx-chevron-down' ></i>
      </div>
    </nav>
    <div class="add_accounts" >
    <a href="add_accounts.php" class="btn btn-dark mb-3">Add New</a>
    </div>
    <div class="home-content" >
      <div class="title">ADMINISTRATOR</div>
        <div class="attendance box">
          <table class="table table-striped table-responsive">
              <div class="st-boxes">
                <div class="student box">
                  <div class="container">
                      <table class="table table-striped">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Password</th>
                                    <th scope="col">User Type</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php
                              $sql = "SELECT * FROM `admin_db`";
                              $result = mysqli_query($conn, $sql);
                              while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                  <td><?php echo $row["id"] ?></td>
                                  <td><?php echo $row["name"] ?></td>
                                  <td><?php echo $row["user_name"] ?></td>
                                  <td><?php echo $row["password"] ?></td>
                                  <td><?php echo $row["user_type"] ?></td>
                                  <td><?php echo $row["date"] ?></td>
                                  <td>
                                    <a href="../edit/edit_admin.php?id=<?php echo $row["id"] ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
                                    <a href="admin_accounts.php?id=<?php echo $row["id"] ?>" class="link-dark" onclick="return confirm('Are you sure you want to delete this record?')"><i class="fa-solid fa-trash fs-5"></i></a>
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
  <div class="home-content">
    <div class="title">STUDENT'S</div>
    <div class="attendance box">
      <table class="table table-striped table-responsive">
        <thead class="thead-dark">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Password</th>
            <th scope="col">User Type</th>
            <th scope="col">Date</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM `user_db`";
          $result = mysqli_query($conn, $sql);
          while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
              <td><?php echo $row["id"] ?></td>
              <td><?php echo $row["name"] ?></td>
              <td><?php echo $row["email"] ?></td>
              <td><?php echo $row["password"] ?></td>
              <td><?php echo $row["user_type"] ?></td>
              <td><?php echo $row["date"] ?></td>
              <td>
                <a href="../edit/edit_user.php?id=<?php echo $row["id"] ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
                <a href="admin_accounts.php?id=<?php echo $row["id"] ?>" class="link-dark" onclick="return confirm('Are you sure you want to delete this record?')"><i class="fa-solid fa-trash fs-5"></i></a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  </section>

  <script src="../js/script.dashboard.js"></script>
  <script src="../js/sidebar.js"></script>
</body>
</html>
