<?php
session_start();
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
$_SESSION["cusID"] = $_SESSION["userid"];
$status = 0;

$uid = 0;
$cname = "";
$cphone = "";
$cadrr = "";
if (!$_SESSION["cusID"]) {  //check session
    Header("Location: ./customer.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า login form 
} else {
    $status = 1;


    $uid = $_SESSION["cusID"];
    $sql = "SELECT * from customer where cid = " . $uid;
    $re = $conn->query($sql);
    if ($re->num_rows > 0) {
        $row = $re->fetch_assoc();
        $cname = $row['cfname'] . " " . $row['clname'];
        $cphone = $row['clname'];
        $cadrr = $row['caddress'];
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการสั่งสินค้า</title>
    <link rel='stylesheet' href='css/style_bill.css'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato&display=swap');

        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #93f8f8;
            font-family: 'Lato', sans-serif;
            background-image: url("https://i0.wp.com/lucloi.vn/wp-content/uploads/2020/01/damn-it-hurts-right-here-in-my-meow-meow-61195462.png?resize=500%2C570&ssl=1&is-pending-load=1");
            background-image: url("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRucA8DdZRHK0sP87tkGJz5pPYr7fKumj9aQA&usqp=CAU");

            background-position: center;
            /* Center the image */
            background-repeat: repeat;
            /* Do not repeat the image */
            /* background-size: cover; */
            /* Resize the background image to cover the entire container */
            background-attachment: fixed;

            /* background: rgb(184, 255, 249);
            background: radial-gradient(circle, #aaa 0%, #fff 100%); */
        }

        header {
            padding-left: 60px !important;
            height: 55px;
            background-color: #FFC300 !important;
        }

        header a {
            text-shadow: 2px 2px 2px black;
            margin-left: 20px;
        }

        header a:hover {
            transition: 0.4s;
            font-size: 1.2em;
        }
        .btb{
            border-radius:8px;
            width:80px;
            background-color: #FF8E00;
            box-shadow:2px 2px 2px black;
            text-align:center;
        }
        .bills{
            box-shadow:2px 2px 2px black !important;
            background-color: #f1f1f1 !important;
        }
    </style>
</head>

<body>
    <header class="top-header" style="border-radius: 20px; padding:10px;">
        <a class="menu-item" href="customer.php">Home </a>
        <a class="menu-item" href="customer.php">Product </a>
    </header>

    <?php
    if ($status = 1) {
        $cid = $_SESSION["cusID"];
        $sql = "SELECT bid FROM bill WHERE cid = " . $cid . " GROUP BY bid;";
        $cusAllbid = $conn->query($sql);
        if ($cusAllbid->num_rows > 0) {

            // เรียกดู Bill
            while ($row = $cusAllbid->fetch_assoc()) {

                echo '
                <div style="margin-top:25px"></div>
<div id="invoice-POS" style="padding:20px; border-radius: 20px;" class="bills">
<div style="display: inline-flex; border:1px dashed black;padding:10px;overflow: hidden; width:97%;">
    <div><img src="https://i0.wp.com/lucloi.vn/wp-content/uploads/2020/01/damn-it-hurts-right-here-in-my-meow-meow-61195462.png?resize=500%2C570&ssl=1&is-pending-load=1" style="width: 150px;height: 150px;"></div>
    <div class="info" style="width:600px;  text-align: right;">
        <h1>ONLINE STORE</h1>
    </div>
</div>

<div id="mid" style="display:flex ;justify-content: flex-start;" >
    <div style="">
        <h2>Contact Info</h2>' .
                    "<p>User ID : " . $uid . "</p>" .
                    "<p>Customer Name : " . $cname . "</p>" .
                    "<p>Phone : " . $cphone  . "</p>" .
                    "<p>ADDRESS : " . $cadrr  . "</p>" .
                    '</div>
    <div style="margin-left:20px;">
    <h2>receipt number : ' . $row["bid"] . '</h2>
    </div>
</div>

<!--End Invoice Mid-->
<div id="bot">
    
    <div id="table">
        <table>

            <tr class="tabletitle">
                <td class="item">
                    <h2>Product ID</h2>
                </td>
                <td class="Hours">
                    <h2>Product Name</h2>
                </td>
                <td class="Rate">
                    <h2>Product Price</h2>
                </td>
                <td class="Rate">
                    <h2>Product Total</h2>
                </td>
                <td class="Rate">
                    <h2>Tota Pricel</h2>
                </td>
            </tr>
';
                $sumtotalp = 0;
                $str = "SELECT bill.pid,pname,bill.bamount,pprice,bill.bamount*pprice totalp FROM bill,product WHERE bill.pid = product.pid AND bill.bid = " . $row['bid'] . ";";
                $result = $conn->query($str);
                if ($result->num_rows > 0) {
                    while ($row1 = $result->fetch_assoc()) {

                        $mstr = '<!-- All menu -->  
                    <tr class="service">
                            <td class="tableitem">
                                <p class="itemtext">' . $row1['pid'] . '</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">' . $row1['pname'] . '</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">' . $row1['pprice'] . '</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">' . $row1['bamount'] . '</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">' . $row1['totalp'] . '</p>
                            </td>
                        </tr>';
                        echo $mstr;

                        $sumtotalp = $sumtotalp + $row1['totalp'];
                    }
                }
                $ends = '<tr class="tabletitle">
                <td colspan="3"></td>
                <td class="Rate">
                    <h2>Total</h2>
                </td>
                <td class="payment">
                    <h2>' . $sumtotalp . '</h2>
                </td>
            </tr>

        </table>
    </div>
    <!--End Table-->
    <a class="button btb" href="customer.php">BACK </a>
    <div id="legalcopy">
        <p class="legal"><strong>Thank you for your business!</strong> Payment is expected within 31 days </br>please process this invoice within that time. There will be a 5% interest charge per month on late invoices.
        </p>
    </div>
</div>
<!--End InvoiceBot-->
</div>';
                echo $ends;
                echo '<div style="margin-top:25px"></div>';
            }
        }
    }
    ?>

    <div style="display:flex ;   justify-content: space-between;"></div>
</body>

</html>