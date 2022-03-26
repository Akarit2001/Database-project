<?php
session_start();
if (isset($_POST['cname'])) {
    //connection
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "mystore";
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8");


    //รับค่า user & password
    $Username = $_POST['cname'];
    $Password = $_POST['cpass'];
    //query 
    $sql = "SELECT * FROM customer Where cfname='" . $Username . "' and 	cpassword='" . $Password . "' ";

    $result = $conn->query($sql);

    if ($result->num_rows >= 1) {
        while($row = $result->fetch_assoc()) {
            $_SESSION["UserID"] = $row["cid"];
            $_SESSION["customername"] = $row["cfname"] . " " . $row["clname"];
            $_SESSION["phone"] = $row["cphone"];
            $_SESSION["addr"] = $row["caddress"];
            
          }

        Header("Location: ../customer.php");
    } else {
        echo "<script>";
        $s = "user หรือ  password ไม่ถูกต้อง";
        echo "alert(\" $s\");";
        echo "window.history.back()";
        echo "</script>";
    }
} else {
    Header("Location: ../index.php"); //user & password incorrect back to login again
}