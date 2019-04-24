<?php

if(isset($_POST['submit']))
{
include_once 'dbconn.php';

$name = mysqli_real_escape_string($conn,$_POST['name']);
$email= mysqli_real_escape_string($conn,$_POST['email']);
$password = mysqli_real_escape_string($conn,$_POST['password']);

//error handler empty fields
if (empty($name)||empty($email) || empty($password)) {
  header("location: ../index.php?index=empty");
  exit();
}else {
  // valid email
  if(!preg_match("/^[a-zA-Z]*$/",$name))
  {
    header("location: ../index.php?index=invalid");
    exit();
  } else {
    // valid email
    if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
      header("location: ../index.php?index=EMAIL");
      exit();
    } else {
      $sql = "SELECT * FROM users WHERE user_name='$name'";
      $result = mysqli_query($conn, $sql);
      $resultcheck = mysqli_num_rows($result);

      if ($resultcheck > 0) {
        header("location: ../index.php?index=usertaken");
        exit();
      } else {
        // password hashing
        $passhash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(user_name, email, password) VALUES ($name, $email, $passhash);";
        $result = mysqli_query($conn, $sql);
        header("location: ../index.php?index=success");
        exit();
      }
    }
  }
}
}else {
  header("location: ../index.php");
  exit();
}
 ?>
