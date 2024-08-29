<!-- For more projects: Visit codeastro.com  -->
<?php

session_start();
include("../dbcon.php");

if (!isset($_SESSION['user_session'])) {

   header("location:index.php");
}


$invoice_number = $_GET['invoice_number'];

if (isset($_POST['update'])) {

   $id = $_POST['id'];
   $med_name = $_POST['med_name'];
   $category = $_POST['category'];
   $quantity =  $_POST['quantity'];
   $used_qty = $_POST['used_quantity'];
   $remain_qty = $_POST['remain_quantity'];
   $reg_date = strtotime($_POST['reg_date']);
   $new_reg_date = date('Y-m-d', $reg_date);
   $exp_date = strtotime($_POST['exp_date']);
   $new_exp_date = date('Y-m-d', $exp_date);
   $sell_type = $_POST['sell_type'];
   $status =  $_POST['status'];

   $t = $quantity - $used_qty;

   $sql = " UPDATE stock SET 
   medicine_name='$med_name',
   category='$category',
   quantity='$quantity', 
   used_quantity='$used_qty', 
   remain_quantity= '$t',
   register_date='$new_reg_date',
   expire_date='$new_exp_date',
   sell_type='$sell_type',
   status='$status' WHERE id = '$id' ";

   $result = mysqli_query($con, $sql);

   echo "<h1>...LOADING</h1>";

   if ($result) {

      echo "<script type='text/javascript'>window.top.location='view.php?invoice_number=$invoice_number'</script>";
   }
}

?>