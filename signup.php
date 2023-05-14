<?php

@include 'functions/config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = $_POST['password'];
   $cpass = $_POST['cpassword'];
   $user_type = "user";

   $select = "SELECT email FROM user_db WHERE email = '$email'";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) == 0){

      if($pass == $cpass){

         $insert = "INSERT INTO user_db (name, email, password, user_type) VALUES ('$name', '$email', '$pass', '$user_type')";
         mysqli_query($conn, $insert);

         $success[] = 'Registration Successful!';
         header('location:signin.php');
      }else{
         $error[] = 'Password and Confirm Password do not match!';
      }

   }else{
      $error[] = 'Email already exists!';
   }

};
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" href="images/svci.icon.png" type="image/x-icon">
   <title>Register Form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<div class="form-container" style="background: linear-gradient(to bottom, #87CEFA, #1E90FF);">

   <form action="" method="post">
     <a href="index.php">
         <img src="images/svci.png.png" alt="" class="logo"  style="width: 70px; height: 70px;">
     </a>
      <h3>SVCI Computer Laboratory An Internet of Things System | Sign up</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="name" required placeholder="Enter your Name">
      <input type="email" name="email" required placeholder="Enter your Email">
      <input type="password" name="password" required placeholder="Enter your Password">
      <input type="password" name="cpassword" required placeholder="Confirm your Password">
      <select name="user_type">
         <option value="user">User</option>
         <!-- <option value="admin">Admin</option> -->
      </select>
      <input type="submit" name="submit" value="register now" class="form-btn">
      <p>Already have an account? <a href="signin.php">Sign In now</a></p>
   </form>

</div>

</body>
</html>
