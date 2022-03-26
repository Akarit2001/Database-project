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
    $selerID = $_SESSION["UserID"];

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
$sql2 = "SELECT addproduct.aid,product.pname,addproduct.addAmount FROM addproduct,product WHERE addproduct.sid = " . $selerID . " AND addproduct.pid = product.pid;";
$result = $conn->query($sql);
$result2 = $conn->query($sql2);


// add data
echo isset($_POST["pname"]);
if (isset($_POST["pname"]) && isset($_POST["price"])) {
    $pname = $_POST["pname"];
    $price = $_POST["price"];
    $pamount = 0;
    $mstr = sprintf("('%u', '%s', '%u','%u');", $selerID, $pname, $price, $pamount);
    $sqlInsert = "INSERT INTO product (sid,pname, pprice,pamount ) VALUES " . $mstr;
    if ($conn->query($sqlInsert)) {
        header("Refresh:0; url=seller.php"); //reload page
    }
}
// echo 'test';
// echo isset($_POST["apid"]);
if (isset($_POST["addamout"]) && isset($_POST["apid"])) {
    $apid = $_POST["apid"];
    $apamount = $_POST["addamout"];
    $mstr = sprintf("('%s', '%s', '%u');", $selerID, $apid, $apamount);
    $sqlAdd_addproduct = "INSERT INTO addproduct (sid, pid,addAmout) VALUES " . $mstr;
    // $tempamount = 0;
    $getoldAmout = "select * form product WHERE pid = '" . $apid . "';";

    $sqlAlt_product = "UPDATE product SET pamount = pamount +" . $apamount . " WHERE pid = " . $apid . " and sid = '" . $selerID . "';";
    if ($conn->query($sqlAdd_addproduct) && $conn->query($sqlAlt_product)) {
        header("Refresh:0; url=seller.php"); //reload page
    }
}


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">


    <link rel="stylesheet" href="css/style_seller.css">
    <!-- <link rel="stylesheet" href="css/style_main.css"> -->

</head>

<body>
    <div class="container">
        <div class="row profile">
            <div class="col-md-3">
                <div class="profile-sidebar">
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
                        <button type="button" class="btn btn-danger btn-sm" onclick="window.open('index.php');self.close()">log out</button>
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
                                <div class="uppercase profile-stat-title"> 37 </div>
                                <div class="uppercase profile-stat-text"> Projects </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-6">
                                <div class="uppercase profile-stat-title"> 51 </div>
                                <div class="uppercase profile-stat-text"> Tasks </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-6">
                                <div class="uppercase profile-stat-title"> 61 </div>
                                <div class="uppercase profile-stat-text"> Uploads </div>
                            </div>
                        </div>
                        <!-- END STAT -->
                        <div>
                            <h4 class="profile-desc-title">About Jason Davis</h4>
                            <span class="profile-desc-text"> Lorem ipsum dolor sit amet diam nonummy nibh dolore.
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
                    <form action="" method="POST" enctype="multipart/form-data" name="addproduct">
                        <fieldset>
                            <legend>Addproduct</legend>
                            <label for="pName">PName:</label>
                            <input id="pName" type="text" placeholder="Product name" name="pname" required>
                            <label for="price">Price: </label>
                            <input id="price" type="number" min="1" placeholder="Product price" name="price" required>
                        </fieldset>
                        <div class="div_btn">
                            <button type="submit" class="mybtn" name="addpro">เพิ่ม</button>
                        </div>
                    </form>
                    <form action="" method="POST" enctype="multipart/form-data" name="adm">
                        <fieldset>
                            <legend>เพิ่มจำนวนสินค้า</legend>
                            <label for="apid">PID: </label>
                            <input id="apid" type="number" min="1" placeholder="ID สินค้าที่ต้องการเพิ่ม" name="apid" required>
                            <label for="addamout">Amout: </label>
                            <input id="addamout" type="number" min="1" placeholder="จำนวนสินค้าที่ต้องการเพิ่ม" name="addamout" required>
                        </fieldset>
                        <div class="div_btn">
                            <button type="submit" class="mybtn" name="addA">เพิ่ม</button>
                        </div>
                    </form>

                    <h2>สินค้าทั้งหมด</h2>
                    <div id="product_list" class="interfaceproduct">
                        <p><?php
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    $str = '<p class="product_list">' . 'pid: ' . $row['pid'] . ' Pname: ' . $row['pname'] . ' Pprice: ' . $row['pprice'] . ' pamount : ' . $row['pamount'] . '</p>';
                                    echo $str;
                                }
                            }
                            ?>
                        </p>
                    </div>
                    <h2>Add history</h2>
                    <div id="product_Add" class="interfaceproduct">
                        <p>
                            <?php
                            if ($result2->num_rows > 0) {
                                // output data of each row
                                while ($row = $result2->fetch_assoc()) {
                                    $str = '<p class="product_list">' . 'pid: ' . $row['aid'] . ' Pname: ' . $row['pname'] . ' addAmount: ' . $row['addAmount'] . '</p>';
                                    echo $str;
                                }
                            } else {
                                echo "ไม่มีประวัติสินค้าที่ถูกเพิ่ม";
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>