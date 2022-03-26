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

if (!$_SESSION["cusID"]) {  //check session
    Header("Location: ./index.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า login form 
} else {
    $cid = $_SESSION["cusID"];
    $sql = "SELECT bid FROM bill WHERE cid = " . $cid . " GROUP BY bid;";
    $cusAllbid = $conn->query($sql);
    if ($cusAllbid->num_rows > 0) {
        // เรียกดู Bill
        while ($row = $cusAllbid->fetch_assoc()) {
            echo "bid = " . $row['bid'];
            $str = "SELECT bill.pid,bill.bamount,pname,pprice FROM bill,product WHERE bill.pid = product.pid AND bill.bid = " . $row['bid'] . ";";
            $result = $conn->query($str);
        }
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
</head>

<body>

</body>

</html>