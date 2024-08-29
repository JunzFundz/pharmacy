<?php

session_start();

if (!isset($_SESSION['user_session'])) {

    header("location:index.php");
}

?><!-- For more projects: Visit codeastro.com  -->
<!DOCTYPE html>
<html>

<head>
    <title>M&D IMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css">
    <link rel="stylesheet" type="text/css" href="src/facebox.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="src/facebox.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $("a[id*=popup").facebox({
                loadingImage: 'src/img/loading.gif',
                closeImage: 'src/img/closelabel.png'
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

                    <a class="brand" href="#"><b>M&D Pharmacy Inventory System</b></a>
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
                                $date = date('d-m-Y');
                                $inc_date = date("Y-m-d", strtotime("+6 month", strtotime($date)));
                                $select_sql = "SELECT  * FROM stock WHERE expire_date <= '$inc_date' and status='Available' ";
                                $result =  mysqli_query($con, $select_sql);
                                $row1 = $result->num_rows;

                                if ($row1 == 0) {
                                }
                                ?>

                            </li>

                            <!-- For more projects: Visit codeastro.com  -->
                            <li><a href="product/view.php?invoice_number=<?php echo $_GET['invoice_number'] ?>"><span class="icon-home"></span>Home</a></li>

                            <li><a href="logout.php" class="link">
                                    <font color='red'><span class="icon-off"></span></font> Logout
                                </a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div><!--***HEADER****---->



        <div class="container"><!---****SEARCHES_CONTENT*****--->

            <div class="row">
                <div class="contentheader">
                    <h1>Products</h1>
                </div><br>

                <input type="text" size="4" id="med_quantity" onkeyup="quanti()" placeholder="Filter using Medicine Name" title="Type Medicine Name">


            </div>

            <!-- For more projects: Visit codeastro.com  -->
        </div><!---****SEARCHES_CONTENT*****--->


        <?php
        include('dbcon.php');

        $select_sql = "SELECT * FROM stock where status = 'Pullouts'";
        $select_query = mysqli_query($con, $select_sql);
        $row = mysqli_num_rows($select_query);
        ?>

        <div style="text-align:center;">
            Total Pullouts : <font color="green" style="font:bold 22px 'Aleo';">[<?php echo $row; ?>]</font>
        </div>
        <br><br>
        <!-- <div class="container" style="overflow-x:auto; overflow-y: auto;"> -->
        <div class="container">

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
                                        <td style="font-weight: 700;">Option</td>
                                    </tr>
                                    <?php include("dbcon.php"); ?>
                                    <?php $sql = "SELECT * FROM stock where status='Pullouts' order by id desc"; ?>
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
                                            <td><button class="btn btn-danger remove" data-uid="<?php echo $row['id'] ?>"><i class="bi bi-archive"></i></span>&nbsp;</button></td>
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
    </body>

</html>
<!-- For more projects: Visit codeastro.com  -->
<script type="text/javascript">
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


    function stat_search() {
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

    $(".remove").click(function() {
        var id = $(this).data('uid');

        if (confirm("Remove this product?")) {
            $.ajax({
                url: 'product/delete.php',
                type: "post",
                data: {
                    'delete': true,
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