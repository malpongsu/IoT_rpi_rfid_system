<?php
// Include the database connection code here

if(isset($_POST['submit'])){
   // Get the email address from the form submission
   $email = $_POST['email'];

   // Check if the email address is valid
   if(filter_var($email, FILTER_VALIDATE_EMAIL)){

      // Generate a new password
      $new_password = substr(md5(time()), 0, 8);

      // Update the user's password in the database
      $query = "UPDATE users SET password = '".md5($new_password)."' WHERE email = '".$email."'";
      // Execute the query here

      // Send the new password to the user's email address
      $subject = "Password reset";
      $message = "Your new password is: ".$new_password;
      // Use the mail() function or a third-party library to send the email here

      // Display a success message to the user
      echo "Your new password has been sent to your email address.";
   } else {
      // Display an error message if the email address is not valid
      echo "Please enter a valid email address.";
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" href="images/svci.icon.png" type="image/x-icon">
   <title>Forgot Password</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="form-container" style="background: linear-gradient(to bottom, #87CEFA, #1E90FF);">
   <form action="" method="post">
   <a href="signin.php"><img src="images/svci.png.png" alt="SVCI LOGO" style="width: 70px; height: 70px;">
     </a>
      <h3>Forgot Password</h3>
      <input type="email" name="email" required placeholder="Enter your Email">
      <input type="submit" name="submit" value="Reset Password" class="form-btn">
      <p>Remembered your password? <a href="index.php">Sign In</a></p>
   </form>
</div>

</body>
</html>
