<?php

session_start();

if (!isset($_SESSION['user_session'])) {

  header("location:index.php");
}

?>
<!DOCTYPE html>
<html>

<head>
  <title>SPMS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="src/facebox.css">
  <link rel="stylesheet" type="text/css" href="css/tcal.css">
  <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/facebox.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $("a[id*=popup]").facebox({
        loadingImage: 'src/img/loading.gif',
        closeImage: 'src/img/closelabel.png'
      })
    })
  </script>
  <script type="text/javascript" src="js/tcal.js"></script>
  <script type="text/javascript">
    function Clickheretoprint() {
      var disp_setting = "toolbar=yes,location=no,directories=yes,menubar=yes,";
      disp_setting += "scrollbars=yes,width=700, height=400, left=100, top=25";
      var content_vlue = document.getElementById("content").innerHTML;

      var docprint = window.open("", "", disp_setting);
      docprint.document.open();
      docprint.document.write('</head><body onLoad="self.print()" style="width: 700px; font-size:11px; font-family:arial; font-weight:normal;">');
      docprint.document.write(content_vlue);
      docprint.document.close();
      docprint.focus();
    }
  </script>


</head>

<body>

  <body style="height: 100%">
    <div class="navbar navbar-inverse navbar-fixed-top"><!--*****Header******-->
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
                include("dbcon.php");

                $quantity = "5";
                $select_sql1 = "SELECT * FROM stock where remain_quantity <= '$quantity' and status='Available'";
                $result1 = mysqli_query($con, $select_sql1);
                $row2 = $result1->num_rows;

                if ($row2 == 0) {

                  echo ' <a  href="#" class="notification label-inverse" >
                <span class="icon-exclamation-sign icon-large"></span></a>';
                } else {
                  echo ' <a  href="qty_alert.php" class="notification label-inverse" id="popup">
                <span class="icon-exclamation-sign icon-large"></span>
                <span class="badge">' . $row2 . '</span></a>';
                }


                ?>
              </li>
              <li>
                <?php
                @$date = date('Y-m-d');
                $inc_date = date("Y-m-d", strtotime("+6 month", strtotime($date)));
                $select_sql = "SELECT  * FROM stock WHERE expire_date <= '$inc_date' and status='Available' ";
                $result =  mysqli_query($con, $select_sql);
                $row1 = $result->num_rows;

                if ($row1 == 0) {

                  echo ' <a  href="#" class="notification label-inverse" >
                <span class="icon-bell icon-large"></span></a>';
                } else {
                  echo ' <a  href="ex_alert.php" class="notification label-inverse" id="popup">
                <span class="icon-bell icon-large"></span>
                <span class="badge">' . $row1 . '</span></a>';
                }
                ?>

              </li>

              <!-- For more projects: Visit codeastro.com  -->

              <li><a href="product/view.php?invoice_number=<?php echo $_GET['invoice_number'] ?>"><span class="icon-home"></span>Home</a></li>
              <li><a href="product/view.php?invoice_number=<?php echo $_GET['invoice_number'] ?>"><span class="icon-th"></span> Products</a></li>
              <li><a href="backup.php?invoice_number=<?php echo $_GET['invoice_number'] ?>"><span class="icon-folder-open"></span> Backup</a></li>
              <li><a href="logout.php" class="link">
                  <font color='red'><span class="icon-off"></span></font>Logout
                </a></li>
            </ul>
          </div>

        </div>
      </div>
    </div><!--*****Header******-->

    <div class="container">


      <div class="row">
        <div class="contentheader">

          <h2>Backup</h2>

        </div><br>
        <!-- <div style="display: flex; flex-direction: row; padding-block: 1rem; width: 14rem; justify-content: space-between">
          <div><button type="button" class="btn btn-primary btn-sm">Import</button></div>
          <div> <button type="button" id="exportBtn" class="btn btn-secondary btn-sm"><i class="bi bi-floppy2-fill"></i>Export</button></div>
        </div> -->

        <div class="row">
          <div class="col-12">
            <form method="POST">
              <div style="height: auto;">

                <table id="table0" class="table table-bordered text-center table-striped table-hover">
                  <thead>

                  </thead>
                  <tbody>
                    <tr>
                      <td style="font-weight: 700;">Medicine</td>
                      <td style="font-weight: 700;">Category</td>
                      <td style="font-weight: 700;">Registered Qty</td>
                      <td style="font-weight: 700;">Type</td>
                      <td style="font-weight: 700;">Sold Qty</td>
                      <td style="font-weight: 700;">Remain Qty</td>
                      <td style="font-weight: 700;">Registered</td>
                      <td style="font-weight: 700;">Expiry</td>
                      <td style="font-weight: 700;">Status</td>
                    </tr>
                    <?php include("dbcon.php"); ?>
                    <?php $sql = "SELECT  id,bar_code, medicine_name, category, quantity,used_quantity, remain_quantity,act_remain_quantity, register_date, expire_date, company, sell_type , actual_price, selling_price, profit_price, status FROM stock order by id desc"; ?>
                    <?php $result =  mysqli_query($con, $sql); ?>
                    <?php while ($row =  mysqli_fetch_array($result)) : ?>

                      <tr>
                        <td><?php echo $row['medicine_name']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><?php echo $row['sell_type']; ?></td>
                        <td><?php echo $row['used_quantity']; ?></td>
                        <td><?php echo $row['remain_quantity']; ?></td>
                        <td><?php echo  date("d-m-Y", strtotime($row['register_date'])); ?></td>
                        <td><?php echo date("d-m-Y", strtotime($row['expire_date'])); ?></td>
                        <td>
                          <?php $status = $row['status'];
                          if ($status == 'Available') {
                            echo '<span class="label label-success">' . $status . '</span>';
                          } else {
                            echo '<span class="label label-danger">' . $status . '</span>';
                          } ?>
                        </td>
                      </tr>
                    <?php endwhile ?>
                  </tbody>
                </table>

              </div>
              <button id="exportCsvBtn">Export to CSV</button>
            </form>
          </div>
        </div>

      </div>
    </div>


    <script>
      document.getElementById('exportCsvBtn').addEventListener('click', () => {
        const table = document.getElementById('table0');
        const rows = table.querySelectorAll('tbody > tr');

        let csvContent = 'data:text/csv;charset=utf-8,';

        rows.forEach((row, index) => {
          const rowData = [];
          row.querySelectorAll('td').forEach((cell) => {
            rowData.push(`"${cell.textContent.trim().replace(/"/g, '""')}"`);
          });
          csvContent += rowData.join(',') + '\n';
        });

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', 'table.csv');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
      });
    </script>

  </body>

</html>