
<?php
require_once("dbcon.php");

$sql = "SELECT  id,bar_code, medicine_name, category, quantity,used_quantity, remain_quantity,act_remain_quantity, register_date, expire_date, company, sell_type , actual_price, selling_price, profit_price, status FROM stock order by id desc";
$result =  mysqli_query($con, $sql);

$data = [];
while ($row =  mysqli_fetch_array($result)) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>