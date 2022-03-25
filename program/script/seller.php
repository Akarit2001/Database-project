<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mystore";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";
$sellerID = 1;
$pname = $_POST["pname"];
$price = $_POST["price"];
// $ptype = $_POST['ptype'];
$pamout = 0;
$mstr = sprintf("('%s', '%u','%u');", $pname, $price, $pamout);
$sql = "INSERT INTO product (pname, Pprice,pAmount)
VALUES " . $mstr;
// echo $sql;
$conn->set_charset("utf8");
if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>status</title>
</head>

<body>
  <div>-------------------------------------------------</div>
  <a href="../seller.php"><button>trun back to page</button></a>
  <div>-------------------------------------------------</div>
</body>

</html>