<?php
include "../functions/config.php";
$id = $_GET["id"];

if (isset($_POST["submit"])) {
  $name = $_POST['name'];
  $user_name = $_POST['user_name'];
  $password = $_POST['password'];
  $user_type = $_POST['user_type'];

  $sql = "UPDATE `admin_db` SET `name`='$name',`user_name`='$user_name',`password`='$password',`user_type`='$user_type' WHERE id = $id";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    header("Location: ../admin_page/admin_accounts.php?msg=Data updated successfully");
  } else {
    echo "Failed: " . mysqli_error($conn);
  }
}

$sql = "SELECT * FROM `admin_db` WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> SVCI | Administrator</title>
    <link rel="stylesheet" href="edit_admin.css">
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
        <!-- <span> <?php echo $_SESSION['admin_name'] ?></span> -->
        <i class='bx bx-chevron-down' ></i>
      </div>
    </nav>
<div class="home-content">
  <div class="title">ADMINISTRATOR - EDIT</div>
  <div class="attendance box">
    <form method="post">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name'] ?>" required>
      </div>
      <div class="form-group">
        <label for="user_name">Email</label>
        <input type="email" class="form-control" id="user_name" name="user_name" value="<?php echo $row['user_name'] ?>" required>
      </div>
      <div class="form-group">
        <label for="user_name">Password</label>
        <input type="text" class="form-control" id="password" name="password" value="<?php echo $row['password'] ?>" required>
      </div>
      <div class="form-group">
        <label for="user_type">User Type</label>
        <select class="form-select" id="user_type" name="user_type" required>
          <option value="">Select User Type</option>
          <option value="Admin" <?php echo $row['user_type'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
        </select>
      </div>
        <button type="submit" name="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
</div>
</body>
<html>
