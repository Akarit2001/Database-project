<?php
    session_start();
    $total_price = 0;
    foreach($_SESSION["bill"] as $bill){
        echo "Name : ".$bill['pname'];
        echo "</br>";
        echo "ID : ".$bill['pid'];
        echo "</br>";
        echo "Quantity : ".$bill['quantity'];
        echo "</br>";
        echo "Price : ".$bill['pprice'];
        echo "</br>";
        echo "</br>";
        $total_price += ($bill["pprice"] * $bill["quantity"]);
    }
    echo $total_price ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill</title>
</head>
<body>
    </br>
    <a href="user.php">Back</a>
</body>
</html>