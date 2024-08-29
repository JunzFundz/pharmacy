<?php

session_start();

if (!isset($_SESSION['user_session'])) {

  header("location:../index.php");
}

?><!-- For more projects: Visit codeastro.com  -->
<!DOCTYPE html>
<html>

<head>
  <title>SPMS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/bootstrap-responsive.css">
  <link rel="stylesheet" type="text/css" href="../src/facebox.css">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../src/facebox.js"></script>

  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $("a[id*=popup").facebox({
        loadingImage: '../src/img/loading.gif',
        closeImage: '../src/img/closelabel.png'
      })
    })
  </script>

</head>

<body>

  <body style="height: 100%">
    <div class="navbar navbar-inverse navbar-fixed-top"><!--***HEADER****---->
      <div class="navbar-inner">
        <div class="container-fluid">

          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>

          <a class="brand" href="#"><b>Simple Pharmacy System</b></a>
          <div class="nav-collapse">
            <ul class="nav pull-right">
              <li>

                <?php
                include("../dbcon.php");

                $quantity = "5";
                $select_sql1 = "SELECT * FROM stock where remain_quantity <= '$quantity' and status='Available'";
                $result1 = mysqli_query($con, $select_sql1);
                $row2 = $result1->num_rows;

                if ($row2 == 0) {

                  echo ' <a  href="#" class="notification label-inverse" >
                <span class="icon-exclamation-sign icon-large"></span></a>';
                } else {
                  echo ' <a  href="../qty_alert.php" class="notification label-inverse" id="popup">
                <span class="icon-exclamation-sign icon-large"></span>
                <span class="badge">' . $row2 . '</span></a>';
                }
                ?>
              </li>

              <li><a href="view.php?invoice_number=<?php echo $_GET['invoice_number'] ?>"><span class="icon-home"></span>Home</a></li>
              <li><a href="../pullouts.php?invoice_number=<?php echo $_GET['invoice_number'] ?>"><i class="bi bi-arrow-90deg-up"></i>Pullouts</a></li>
              <li><a href="../sales_report.php?invoice_number=<?php echo $_GET['invoice_number'] ?>"><span class="icon-folder-open"></span> Backup</a></li>
              <li><a href="../logout.php" class="link">
                  <font color='red'><span class="icon-off"></span></font> Logout
                </a></li>
            </ul>
          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="contentheader">
          <h1>Products</h1>
        </div><br>

        <input type="text" size="4" id="med_quantity" onkeyup="quanti()" placeholder="Filter using Medicine Name" title="Type Medicine Name">
        <input type="text" size="4" id="med_exp_date" onkeyup="exp_date()" placeholder="Filter using Registered Date" title="Type in registered date">
        <a href="index.php?invoice_number=<?php echo $_GET['invoice_number'] ?>" id="popup"><button class="btn btn-success btn-md" name="submit"><span class="icon-plus-sign icon-large"></span> Add New Medicine</button></a>
      </div>
    </div>


    <?php
    include('../dbcon.php');

    $select_sql = "SELECT * FROM stock order by quantity";
    $select_query = mysqli_query($con, $select_sql);
    $row = mysqli_num_rows($select_query);
    ?>
    <br>
    <div style="text-align:center;">
      Total Medicines : <font color="green" style="font:bold 22px 'Aleo';">[<?php echo $row; ?>]</font>
    </div>
    <br>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <form method="POST">
            <div style="height: auto;">
              <table id="table0" class="table table-bordered table-striped table-hover">
                <thead>
                  <tr style="background-color: #383838; color: #FFFFFF;">
                    <th>Medicine</th>
                    <th>Category</th>
                    <th>Registered Qty</th>
                    <th>Sold Qty</th>
                    <th>Remain Qty</th>
                    <th>Registered</th>
                    <th style="background-color: #c53f3f">Expiry</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  $current_date = new DateTime();
                  $sql = "SELECT * FROM stock WHERE status = 'Available' order by id desc";
                  $result =  mysqli_query($con, $sql);

                  while ($row =  mysqli_fetch_array($result)) :
                  ?>
                    <tr>
                      <td><?php echo $row['medicine_name']; ?></td>
                      <td><?php echo $row['category']; ?></td>
                      <td><?php echo $row['quantity'] . "&nbsp;&nbsp;(<strong><i>" . $row['sell_type'] . "</i></strong>)" ?></td>
                      <td><?php echo $row['used_quantity']; ?></td>
                      <td><?php echo $row['remain_quantity']; ?></td>
                      <td><?php echo  date("m-d-Y", strtotime($row['register_date'])); ?></td>
                      <td>
                        <?php
                        $expire_date = new DateTime($row['expire_date']);
                        $interval = $expire_date->diff($current_date);
                        if ($interval->days <= 14) :
                        ?>
                          <font color="red"><?php echo date("m-d-Y", strtotime($row['expire_date'])); ?></font>
                        <?php else : ?>
                          <?php echo date("m-d-Y", strtotime($row['expire_date'])); ?>
                        <?php endif; ?>
                      </td>
                      <td><?php $status = $row['status'];
                          $q = $row['quantity'];

                          if ($status == 'Available' && $q > 1) {
                            echo '<span class="label label-success">' . $status . '</span>';
                          } else if ($status == 'Available' && $q < 1) {
                            $status = "Not available";
                            echo '<span class="label label-danger">' . $status . '</span>';
                          }

                          ?></td>
                      <td><a type="button" id="popup" href="update_view.php?id=<?php echo $row['id'] ?>&invoice_number=<?php echo $_GET['invoice_number'] ?>"><button class="btn btn-info"><span class="icon-edit"></span></button></a>
                        <button class="btn btn-danger delete" data-uid="<?php echo $row['id'] ?>"><i class="bi bi-archive"></i></span>&nbsp;</button>
                      </td>

                    </tr>
                  <?php endwhile ?>
                </tbody>
              </table>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>

</html>
<!-- For more projects: Visit codeastro.com  -->
<script type="text/javascript">
  $(document).on('change', '#quantity-change', function() {
    var qty = $(this).data('qy');

    console.log(qty)
  })






  function med_name1() { //***Search For Medicine *****
    var input, filter, table, tr, td, i;
    input = document.getElementById("name_med1");
    filter = input.value.toUpperCase();
    table = document.getElementById("table0");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[0];
      if (td) {
        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }


  function quanti() { //***Search For quantity *****
    var input, filter, table, tr, td, i;
    input = document.getElementById("med_quantity");
    filter = input.value.toUpperCase();
    table = document.getElementById("table0");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[1];
      if (td) {
        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }

  function exp_date() { //***Search For expireDate *****
    var input, filter, table, tr, td, i;
    input = document.getElementById("med_exp_date");
    filter = input.value.toUpperCase();
    table = document.getElementById("table0");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[6];
      if (td) {
        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }


  function stat_search() { //***Search For Status*****
    var input, filter, table, tr, td, i;
    input = document.getElementById("med_status");
    filter = input.value.toUpperCase();
    table = document.getElementById("table0");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[11];
      if (td) {
        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }

  $(".delete").click(function() {
    var id = $(this).data('uid');

    console.log(id)
    if (confirm("Add this to pullout??")) {

      $.ajax({
        type: "POST",
        url: 'delete.php',
        data: {
          'update': true,
          'id': id
        },
        success: function() {
          location.reload(true);
        },
        error: function() {
          alert("error");
        }

      });

    }
    return false;

  });
</script>
<!-- For more projects: Visit codeastro.com  -->