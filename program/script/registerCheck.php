
<?php
session_start();
if (isset($_POST['fname']) && $_POST['lname'] && $_POST['position']) {
    //connection
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "mystore";
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8");


    //รับค่า form
    $po = $_POST['position'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $adrr = $_POST['address'];
    $psw = $_POST['psw'];
    $pswR = $_POST['psw-repeat'];


    //query 
    $custom = "SELECT * FROM customer Where cfname='" . $fname . "';";
    $seller = "SELECT * FROM seller Where sfname='" . $fname . "'; ";

    $resultc = $conn->query($custom);
    $results = $conn->query($seller);
    if ($resultc->num_rows >= 1 || $results->num_rows >= 1) {
        echo "<script>";
        $s = "ชื่อ " . $fname . " ถูกใช้แล้ว";
        echo "alert(\" $s\");";
        echo "window.history.back()";
        echo "</script>";
    } elseif ($pswR != $psw) {
        echo "<script>";
        $s = "Password ไม่ตรงกัน";
        echo "alert(\" $s\");";
        echo "window.history.back()";
        echo "</script>";
    } else {
        // create Seller
        if ($po == 'sell') {
            $sql = "INSERT INTO seller (sfname, slname, sphone,saddress,pass) VALUES ('" . $fname . "', '" . $lname . "', '" . $phone . "', '" . $adrr. "', '" . $psw . "')";
            if ($conn->query($sql)) {
                echo "<script>";
                $s = "ผู้ใช้ " . $fname . " ตำแหน่ง ผู้ขาย ถูกสร้างสำเร็จ";
                echo "alert(\" $s\");";
                echo 'window.location.replace("../index.php");';
                echo "</script>";
            }
            // create Customer
        } elseif ($po == 'cus') {
            $sql = "INSERT INTO customer (cfname, clname, cphone,caddress,cpassword	) VALUES ('" . $fname . "', '" . $lname . "', '" . $phone . "', '" . $adrr. "', '" . $psw . "')";
            if ($conn->query($sql)) {
                echo "<script>";
                $s = "ผู้ใช้ " . $fname . " ตำแหน่ง ลูกค้า ถูกสร้างสำเร็จ";
                echo "alert(\" $s\");";
                echo 'window.location.replace("../index.php");';
                echo "</script>";
            }
        }
    }
} else {
    echo "<script>";
    $s = "ไม่ได้รับข้อมูล มีบางอย่างผิดปกติ";
    echo "alert(\" $s\");";
    echo "window.history.back()";
    echo "</script>";

    // Header("Location: ../index.php"); //user & password incorrect back to login again
}
?>