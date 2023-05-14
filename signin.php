<?php

@include 'functions/config.php';

session_start();
ini_set("display_errors",0);

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = ($_POST['password']);
   $cpass = ($_POST['cpassword']);
   $user_type = $_POST['user_type'];

   $select = "SELECT * FROM user_db WHERE email = '$email' AND password = '$pass'";

   $result_user = mysqli_query($conn, $select);

   if(!$result_user) {
      die("Query failed: " . mysqli_error($conn));
   }

   if(mysqli_num_rows($result_user) > 0){

      $row = mysqli_fetch_array($result_user);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         header('location:admin_page/admin_dashboard.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         header('location:index.php');

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
   <title>SVCI COMLAB AN IoT | SIGN IN</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<div class="form-container" style="background: linear-gradient(to bottom, #87CEFA, #1E90FF);">


   <form action="" method="post" style="padding-top: 5px; ">

     <a href="admin/admin_signin.php"><img src="images/svci.png.png" alt="SVCI LOGO" style="width: 70px; height: 70px;">
     </a>

<h3>SVCI ComLab An Internet of Things System | Sign In </a></h3>

      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="email" name="email" required placeholder="Enter your Email">
      <input type="password" name="password" required placeholder="Enter your Password">
      <input type="submit" name="submit" value="login now" class="form-btn">
      <p>Forgot your password? <a href="forgot_password.php">Reset here</a></p>
      <p>Don't have an account? <a href="signup.php">Sign up now</a></p>
   </form>

</div>

</body>
</html>
