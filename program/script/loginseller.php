<?php
session_start();
?>
<?php
if (isset($_POST['sname'])) {
    //connection
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "mystore";
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8");


    //รับค่า user & password
    $Username = $_POST['sname'];
    $Password = $_POST['spass'];
    //query 
    $sql = "SELECT * FROM seller Where sfname='" . $Username . "' and 	pass='" . $Password . "' ";

    $result = $conn->query($sql);

    if ($result->num_rows >= 1) {
        while ($row = $result->fetch_assoc()) {
            $_SESSION["UserID"] = $row["sid"];
            $_SESSION["sellername"] = $row["sfname"] . " " . $row["slname"];
            $_SESSION["phone"] = $row["sphone"];
            $_SESSION["addr"] = $row["saddress"];
        }

        Header("Location: ../seller.php");
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
?>