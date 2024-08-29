<!-- For more projects: Visit codeastro.com  -->
<?php

include("../dbcon.php");


session_start();

if (!isset($_SESSION['user_session'])) {

   header("location:index.php");
}


if (isset($_POST['submit'])) { //***INSERTING NEW  MEDICEINES******
   $invoice_number = $_GET['invoice_number'];
   echo "<h1>....LOADING</h1>";
   $med_name = $_POST['med_name'];
   $category = $_POST['category'];
   $quantity =  $_POST['quantity'];
   $sell =  $_POST['sell_type'];
   $reg_date = strtotime($_POST['reg_date']);
   $new_reg_date = date('Y-m-d', $reg_date);
   $exp_date = strtotime($_POST['exp_date']);
   $new_exp_date = date('Y-m-d', $exp_date);
   $status = "Available";

   $sql = "INSERT INTO stock(medicine_name, category, quantity,remain_quantity,act_remain_quantity, register_date, expire_date, sell_type, status) VALUES ('$med_name','$category','$quantity','$quantity','$quantity','$new_reg_date','$new_exp_date', '$sell', '$status')";

   $result = mysqli_query($con, $sql);

   if ($result) {

      echo "<script type='text/javascript'>window.top.location='view.php?invoice_number=$invoice_number';</script>";
   }
}


?>
<!-- For more projects: Visit codeastro.com  -->