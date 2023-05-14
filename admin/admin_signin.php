<?php

@include 'functions/config.php';

session_start();

ini_set("display_errors",0);

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
   $pass = ($_POST['password']);
   $cpass = ($_POST['cpassword']);
   $user_type = $_POST['user_type'];

   $select = "SELECT * FROM admin_db WHERE user_name = '$user_name' AND password = '$pass'";

   $result_admin = mysqli_query($conn, $select);

   if(!$result_admin) {
      die("Query failed: " . mysqli_error($conn));
   }

   if(mysqli_num_rows($result_admin) > 0){

      $row = mysqli_fetch_array($result_admin);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         header('location:admin_page/admin_dashboard.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         header('location:signin.php');

      }
   }else{
      $error[] = 'Incorrect Email or Password!';
   }
}

mysqli_close($conn);
?>




<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" href="images/svci.icon.png" type="image/x-icon">
   <title>SVCI | Administrator</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../admin/css/style.css">

</head>
<body>

<div class="form-container" style="background: linear-gradient(to bottom, #87CEFA, #1E90FF);">

   <form action="" method="post">
     <a <a href="../signin.php"><img src="images/svci.png.png" alt="SVCI LOGO" style="width: 70px; height: 70px;">
     </a>
      <h3>ADMINISTRATOR</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="user_name" name="user_name" required placeholder="Enter your Email">
      <input type="password" name="password" required placeholder="Enter your Password">
      <input type="submit" name="submit" value="login now" class="form-btn">
      <!-- <p>Don't have an account as admin? <a href=".admin/admin_signup.php">Register now</a></p> -->
   </form>

</div>
</body>
</html>
