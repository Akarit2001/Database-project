<?php
session_start();
?>
<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "mystore";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// query data

$pname = '';
$selerID = 0;
$sname = "";
$phone = "";
$adrr = "";


if (isset($_POST["sname"]) && isset($_POST["spass"])) {
    $sname = $_POST["sname"];
}
// login here
if (!$_SESSION["UserID"]) {  //check session
    Header("Location: ./index.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า login form 
} else {
    $selerID = $_SESSION["UserID"];
    $sname = $_SESSION["sellername"];
    $phone = $_SESSION["phone"];
    $addr =  $_SESSION["addr"];
}

// query data แสดงสินค้า
$sql = "SELECT * FROM product where sid = " . $selerID . ";";
// query data ประวัติการเพิ่มสินค้า
$sql2 = "SELECT addproduct.aid,product.pname,addproduct.addAmount,addproduct.pid,atime FROM addproduct,product WHERE addproduct.sid = " . $selerID . " AND addproduct.pid = product.pid;";

$result = $conn->query($sql);
$result2 = $conn->query($sql2);
// 
$sql = "SELECT * FROM product where sid = " . $selerID . ";";


// add data
if (isset($_POST["pname"]) && isset($_POST["price"])) {
    $pname = $_POST["pname"];
    $price = $_POST["price"];
    $checkProduct = "select * from product where pname = '".$pname ."';";
    $cpppp = $conn->query($checkProduct);
    if($cpppp->num_rows == 0){
        $pamount = 0;
        $mstr = sprintf("('%u', '%s', '%u','%u');", $selerID, $pname, $price, $pamount);
        $sqlInsert = "INSERT INTO product (sid,pname, pprice,pamount ) VALUES " . $mstr;
        if ($conn->query($sqlInsert)) {
            header("Refresh:0; url=seller.php"); //reload page
        }
    }else{
        echo "<script>";
        $s = "มีสินค้าชิ้นนี้แล้ว";
        echo "alert(\" $s\");";
        echo "window.history.back()";
        echo "</script>";
    }
}
// addmount
if (isset($_POST["addamout"]) && isset($_POST["apid"])) {
    $apid = $_POST["apid"];
    $apamount = $_POST["addamout"];
    $timenow = date("Y-m-d",time());
    $addperson = $_POST["addperson"];
    $mstr = sprintf("('%s', '%s', '%u', '%s','%s');", $selerID, $apid, $apamount,$timenow,$addperson);
    $sqlAdd_addproduct = "INSERT INTO addproduct (sid, pid,addAmount,atime,addperson) VALUES " . $mstr;

    $sqlAlt_product = "UPDATE product SET pamount = pamount +" . $apamount . " WHERE pid = " . $apid . " and sid = '" . $selerID . "';";
    if ($conn->query($sqlAdd_addproduct) && $conn->query($sqlAlt_product)) {
        header("Refresh:0; url=seller.php"); //reload page
    }
}


// ยอดขายกับจำนวนชนิดสินค้าที่มี
$pt = 0;
$sellamout = 0;
// $sl = "select sid from product where sid = ".$selerID;
$rr = $conn->query($sql);
$pt = $rr->num_rows;

$pidl = "select pid from product where sid = " . $selerID;
$sres = $conn->query($pidl);
if ($sres->num_rows > 0) {
    while ($ses = $sres->fetch_assoc()) {
        $sl = "select sum(bamount) summ from bill where pid = " . $ses['pid'];
        $rr = $conn->query($sl);
        $sellamout = $sellamout + $rr->fetch_assoc()['summ'];
    }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">


    <link rel="stylesheet" href="css/style_seller.css">
    <!-- <link rel="stylesheet" href="css/style_main.css"> -->
    <style>
        .inadd {
            color: black;
            margin: 13px auto;
            padding: 10px 10px;
            width: 50%;
            border: none;
            background-color: #FFF;
            border-radius: 20px !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row profile">
            <div class="col-md-3 ">
                <div class="profile-sidebar ppff">
                    <!-- SIDEBAR USERPIC -->
                    <div class="profile-userpic d-flex align-items-center">
                        <img src="https://gravatar.com/avatar/31b64e4876d603ce78e04102c67d6144?s=80&d=https://codepen.io/assets/avatars/user-avatar-80x80-bdcd44a3bfb9a5fd01eb8b86f9e033fa1a9897c3a15b33adfc2649a002dab1b6.png" class="img-responsive" alt="">
                    </div>
                    <!-- END SIDEBAR USERPIC -->
                    <!-- SIDEBAR USER TITLE -->
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name">
                            <?php echo $sname; ?>
                        </div>
                        <div class="profile-usertitle-job">
                            <p>USER ID: <?php echo $selerID ?> </p>
                        </div>
                        <div class="profile-usertitle-job">
                            <p>Address: <?php echo $addr ?> </p>
                            <p>Phone: <?php echo $phone  ?> </p>
                        </div>
                    </div>
                    <!-- END SIDEBAR USER TITLE -->
                    <!-- SIDEBAR BUTTONS -->
                    <div class="profile-userbuttons">
                        <a href="./script/logout.php" type="button" class="btn btn-danger btn-sm">LOG OUT</a>
                    </div>
                    <!-- END SIDEBAR BUTTONS -->
                    <!-- SIDEBAR MENU -->
                    <div class="profile-usermenu">
                        <!-- test -->
                    </div>
                    <!-- END MENU -->

                    <div class="portlet light bordered">
                        <!-- STAT -->
                        <div class="row list-separated profile-stat">
                            <div class="col-md-4 col-sm-4 col-xs-6">
                                <div class="uppercase profile-stat-title"> <?php echo $pt ?> </div>
                                <div class="uppercase profile-stat-text"> <b>Product</b> </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-6">
                                <div class="uppercase profile-stat-title"> <?php echo $sellamout ?> </div>
                                <div class="uppercase profile-stat-text"> Sells </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-6">
                                <div class="uppercase profile-stat-title"> 61 </div>
                                <div class="uppercase profile-stat-text"> LIKE </div>
                            </div>
                        </div>
                        <!-- END STAT -->
                        <div>
                            <h4 class="profile-desc-title">About Jason Davis</h4>
                            <span class="profile-desc-text"> ผู้มีอุปการะคุณที่เขียนเทมเพลสนี้ให้ทุกคนได้ใช้.
                            </span>
                            <div class="margin-top-20 profile-desc-link">
                                <i class="fa fa-globe"></i>
                                <a href="https://www.apollowebstudio.com">apollowebstudio.com</a>
                            </div>
                            <div class="margin-top-20 profile-desc-link">
                                <i class="fa fa-twitter"></i>
                                <a href="https://www.twitter.com/jasondavisfl/">@jasondavisfl</a>
                            </div>
                            <div class="margin-top-20 profile-desc-link">
                                <i class="fa fa-facebook"></i>
                                <a href="https://www.facebook.com/">JasonDavisFL</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-9">
                <div class="profile-content">
                    <form class="fcss" action="" method="POST" enctype="multipart/form-data" name="addproduct">
                        <fieldset>
                            <legend>Add New Product</legend>
                            <div>
                                <label class="lfm" for="pName">PName:</label>
                                <input class="inadd" id="pName" type="text" placeholder="Product name" name="pname" required>
                            </div>
                            <hr>
                            <div>
                                <label class="lfm" for="price">Price: </label>
                                <input class="inadd" id="price" type="number" min="1" placeholder="Product price" name="price" required>
                                <!-- <hr> -->
                            </div>

                        </fieldset>
                        <div class="div_btn">
                            <button type="submit" class="mybtn" name="addpro">เพิ่ม</button>
                        </div>
                    </form>
                    <form class="fcss" action="" method="POST" enctype="multipart/form-data" name="adm">
                        <fieldset>
                            <legend>เพิ่มจำนวนสินค้า</legend>
                            <div>
                                <label class="lfm" for="apid">PID: </label>
                                <input class="inadd" id="apid" type="number" min="1" placeholder="ID สินค้าที่ต้องการเพิ่ม" name="apid" required>
                            </div>
                            <hr>
                            <div>
                                <label class="lfm" for="addamout">Amout: </label>
                                <input class="inadd" id="addamout" type="number" min="1" placeholder="จำนวนสินค้าที่ต้องการเพิ่ม" name="addamout" required>
                            </div>
                            <hr>
                            <div>
                                <label class="lfm" for="addperson">Person: </label>
                                <input class="inadd" id="addperson" type="text" placeholder="ผู้ใช้งานที่เพิ่มจำนวนสินค้า" name="addperson" required>
                            </div>
                        </fieldset>
                        <div class="div_btn">
                            <button type="submit" class="mybtn" name="addA">เพิ่ม</button>
                        </div>
                    </form>

                    <h2 class="underline">สินค้าทั้งหมด</h2>
                    <div id="product_list" class="interfaceproduct">
                        <table id="customers">
                            <tr>
                                <th>ID สินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th>ราคา/$</th>
                                <th>จำนวนคงเหลือ</th>
                            </tr>
                            <?php
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    $str = '<tr><td>' . $row['pid'] . '</td><td>' . $row['pname'] . '</td><td>' . $row['pprice'] . '</td><td>' . $row['pamount'] . '</td></tr>';
                                    echo $str;
                                }
                            } else {
                                echo "<tr><td>ไม่มีข้อมูล</td><td>ไม่มีข้อมูล</td><td>ไม่มีข้อมูล</td></tr>";
                            }

                            ?>
                        </table>
                    </div>
                    <h2 class="underline">Add history</h2>
                    <div id="product_Add" class="interfaceproduct">
                        <table id="customers">
                            <tr>
                                <th>ID ประวัติการเพิ่มสินค้า</th>
                                <th>ID สินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th>จำนวนที่ถูกเพิ่ม</th>
                                <th>เวลาเพิ่ม</th>
                            </tr>
                            <?php
                            if ($result2->num_rows > 0) {
                                // แสดงประวัติการเพิ่มสินค้า
                                while ($row = $result2->fetch_assoc()) {
                                    $str = '<tr><td>' . $row['aid'] . '</td><td>' . $row['pid'] . '</td><td>' . $row['pname'] . '</td><td>' . $row['addAmount']   . '</td><td>' . $row['atime']   . '</td></tr>';
                                    echo $str;
                                }
                            } else {
                                echo "<tr><td>ไม่มีข้อมูล</td><td>ไม่มีข้อมูล</td><td>ไม่มีข้อมูล</td><td>ไม่มีข้อมูล</td></tr>";
                            }
                            ?>
                        </table>
                    </div>
                    <h2 class="underline">สินค้าที่ถูกซื้อ</h2>
                    <div id="product_Add" class="interfaceproduct">
                        <table id="customers">
                            <tr>
                                <th>ID สินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th>ราคา</th>
                                <th>ยอดขาย</th>
                                <th>เวลาที่ขาย</th>
                                <th>รวมจำนวนเงิน $</th>
                            </tr>
                            <?php
                            // query pid สินค้าที่เป็นของ seller คนนี้
                            $sql4 = "SELECT pid FROM product WHERE sid = " . $selerID . ";";
                            $result4 = $conn->query($sql4);
                            $sumsell = 0;
                            if ($result4->num_rows > 0) {

                                while ($rowt = $result4->fetch_assoc()) {
                                    // query data รายการสินค้าที่ถูกซื้อ
                                    $sql3 = "SELECT bill.pid,product.pname,SUM(bill.bamount) sumAmount,product.pprice,product.pprice*SUM(bill.bamount) sellTotal,bill.time FROM bill,product 
                                    WHERE bill.pid = product.pid AND bill.pid =" . $rowt['pid'] . " 
                                    GROUP BY bill.pid,product.pprice,product.pname,bill.time
                                    ORDER BY bill.time";
                                    $result3 = $conn->query($sql3);
                                    if ($result3->num_rows > 0) {
                                        // แสดงรายการสินค้าที่ถูกซื้อ
                                        while ($row = $result3->fetch_assoc()) {
                                            $str = '<tr><td>' . $row['pid'] . '</td><td>' . $row['pname'] . '</td><td>' . $row['pprice'] . '</td><td>' . $row['sumAmount']   . '</td><td>' . $row['time'] . '</td><td>' . $row['sellTotal'] . '</td></tr>';
                                            // $str = "ssss";
                                            $sumsell = $sumsell + $row['sellTotal'];
                                            echo $str;
                                        }
                                    }
                                }
                            }
                            echo "<tr><td colspan='5'>รวมจำนวนเงินทั้งหมด</td><td>" . $sumsell . "</td></tr>";
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>