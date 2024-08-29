<?php

include("../dbcon.php");

session_start();

if (!isset($_SESSION['user_session'])) {

  header("location:../index.php");
}


if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $update = "UPDATE stock set status = 'Pullouts' where id = '$id'";
  $update = mysqli_query($con, $update);
}

if (isset($_POST['delete'])) {
  $id = $_POST['id'];

  $delete_sql = "DELETE FROM stock where id = '$id'";
  $delete_query = mysqli_query($con, $delete_sql);
}
