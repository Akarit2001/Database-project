<?php
    session_start();
?>
<?
    // Connect
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

    require_once('dbcontroller.php');
    $db_handle = new DBController();
    
    // Get data of user to insert in profile.
    if (isset($_POST["cname"]) && isset($_POST["cpass"])) {
        $sname = $_POST["cname"];
    }

    // Get data of customer to insert in profile.
    $userID = $_SESSION["UserID"];
    $customername = $_SESSION["customername"];
    $phone = $_SESSION["phone"];
    $addr =  $_SESSION["addr"];

    // Action
    // if It isn't empty of action.
    if(!empty($_GET["action"])){
        // Get action
        switch($_GET["action"]){
            // Check action
            case "add" :
                // if Quantity isn't empty or it isn't 0.
                if(!empty($_POST["quantity"])){
                    // Select data from database to itemArray.
                    $productBypId = $db_handle->runQuery("SELECT * FROM product WHERE pid = '".$_GET["pid"]."'");
                    $itemArray = array($productBypId[0]["pid"]=>(array( 'pid' => $productBypId[0]["pid"], 
                                                                        'pname' => $productBypId[0]["pname"],
                                                                        'pprice' => $productBypId[0]["pprice"],
                                                                        'pamount' => $productBypId[0]["pamount"],
                                                                        'sid' => $productBypId[0]["sid"],
                                                                        'quantity' => $_POST["quantity"])));  
                }

                // Quantity most than Amount of product in database.
                if ($_POST["quantity"] > $productBypId[0]["pamount"]){
                    echo "<script>";
                    $s = "ยอดสินค้าไม่พอ";
                    echo "alert(\" $s\");";
                    echo "</script>";
                    break;
                }

                // Add
                if(!empty($_SESSION["cart_item"])){
                    $check = False;
                    // Check pId of add with pId of basket.
                    foreach($_SESSION["cart_item"] as $k => $v){
                        if( $productBypId[0]["pid"] == $_SESSION["cart_item"][$k]["pid"]){
                            $check = True;
                        }
                    }
                    if($check){
                        // pId of add has in basket.
                        foreach($_SESSION["cart_item"] as $k => $v){
                            // check pId 
                            if($productBypId[0]["pid"] == $_SESSION["cart_item"][$k]["pid"]){
                                if(empty($_SESSION["cart_item"][$k]["quantity"])){
                                    $_SESSION["cart_item"][$k]["quantity"] = 0;
                                }
                                $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                            }
                        }
                    }else{
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                    }
                }
                else{
                    $_SESSION["cart_item"] = $itemArray;
                }
                break;

            // Remove product by pId in basket.
            case "remove":
                // Data in basket is not empty.
                if(!empty($_SESSION["cart_item"])){
                    // For loop for search pid of basket.
                    foreach($_SESSION["cart_item"] as $k => $v){
                        // check pid of basket and pid of remove.
                        if($_SESSION["cart_item"][$k]["pid"] == $_GET["pid"]){
                            // delete row data in baskey by Key.
                            unset($_SESSION["cart_item"][$k]);
                        }
                    }
                }
                
                if(empty($_SESSION["cart_item"])){
                    unset($_SESSION["cart_item"]);
                }
                break;

            // Empty product to basket.
            case "empty":
                unset($_SESSION["cart_item"]);
                break;

            // Confirm data to database.
            case "confirm":
                // Variable Check 
                $check = TRUE;
                // Check amount of each basket with amount of product in database.
                if(!empty($_SESSION["cart_item"])){
                    foreach($_SESSION["cart_item"] as $k => $v){
                        $result = $conn->query("SELECT * FROM product");
                        while ($product = $result->fetch_assoc()){
                            if ($_SESSION["cart_item"][$k]["pid"] == $product["pid"]){
                                if($_SESSION["cart_item"][$k]["quantity"] > $product["pamount"]){
                                    // Quantity more than Amount.
                                    echo "<script>";
                                    $s = "ยอดสินค้ามีไม่พอ";
                                    echo "alert(\" $s\");";
                                    echo "</script>";
                                    $check = FALSE;
                                    break;
                                }
                            }
                        }
                    }
                }
                
                // Quantity less than Amount.
                if($check == TRUE){
                    if(!empty($_SESSION["cart_item"])){
                        // Sent data in store to bill.php
                        $_SESSION["userID"] = $userID;
                        $_SESSION["customername"] = $customername;
                        $_SESSION["phone"] = $phone;
                        $_SESSION["addr"] = $addr;
                        $_SESSION["bill"] = $_SESSION["cart_item"];
                        header("Location: /program/bill.php");
                    }
                    // Search pId then update amount of product.
                    if(!empty($_SESSION["cart_item"])){
                        foreach($_SESSION["cart_item"] as $item){   
                            // $conn->query("UPDATE product SET pamount = pamount - " . $_POST["quantity"] . " WHERE pid = " . $productBypId[0]["pid"] . " and sid = '" . $productBypId[0]["sid"] . "';");
                            $conn->query("UPDATE product SET pamount = pamount - ". $item["quantity"]. " WHERE pid = ".$item['pid']." and sid = ".$item['sid']."");
                        }
                    }
                    // Create bill.
                    if(!empty($_SESSION["cart_item"])){
                        // Get all data from database.
                        $result = $conn->query("SELECT * FROM bill");
                        // Gen Bill Id.
                        $billId = $result->num_rows + 1;
                        foreach($_SESSION["cart_item"] as $item){   
                            // $conn->query("UPDATE product SET pamount = pamount - " . $_POST["quantity"] . " WHERE pid = " . $productBypId[0]["pid"] . " and sid = '" . $productBypId[0]["sid"] . "';");
                            $conn->query("INSERT INTO bill (bid,cid,pid,bamount) VALUES (".$billId.",".$userID.",".$item['pid'].",".$item['quantity'].");");
                        }
                    }
                    // Clear _SESSTION.
                    unset($_SESSION["cart_item"]);
                    break;
                }else{
                    // Quantity more than Amount.
                    break;
                }
            // History
            case "userhistory":
                // Send Id user.
                $_SESSION["userid"] = $userID;
                // Clear $_SESSION
                unset($_SESSION["cart_item"]);
                // Go to index.php page.
                header("Location: /program/userHistory.php");
                break;

            // Log out 
            case "logout":
                // Clear $_SESSION
                unset($_SESSION["cart_item"]);
                // Go to index.php page.
                header("Location: /program/index.php");
                break;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<!-- Header -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer</title>
    <!-- Bootstrap 5 Alpha CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- Import style_store.css -->
    <!-- Import styple_user.css -->
    <link rel="stylesheet" href="css/style_store.css">
    <link rel="stylesheet" href="css/style_customer.css">

</head>

<!-- body -->
<body>
    <div class="container">

        <!-- Profile -->
            <div class="row profile">
                <div class="col-md-3">
                    <div class="profile-sidebar">
                    <!-- SIDEBAR USERPIC -->
                    <div class="profile-userpic d-flex align-items-center">
                        <img src="https://gravatar.com/avatar/31b64e4876d603ce78e04102c67d6144?s=80&d=https://codepen.io/assets/avatars/user-avatar-80x80-bdcd44a3bfb9a5fd01eb8b86f9e033fa1a9897c3a15b33adfc2649a002dab1b6.png"
                            class="img-responsive" alt="">
                    </div>
                    <!-- END SIDEBAR USERPIC -->
                    <!-- SIDEBAR USER TITLE -->
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name">
                            <?php echo $customername ?>
                        </div>
                        <div class="profile-usertitle-job">
                            USER ID: <?php echo $userID ?>
                        </div>
                        <div class="profile-usertitle-phone">
                            Phone: <?php echo $phone ?>
                        </div>
                        <div class="profile-usertitle-address">
                            Address: <?php echo $addr ?>
                        </div>
                    </div>
                    <!-- END SIDEBAR USER TITLE -->
                    <!-- SIDEBAR BUTTONS -->

                        <div class="profile-userbuttons">
                        <form action="customer.php?action=userhistory" method="post">
                            <input type="submit" class="btn btn-danger btn-sm" value="History">
                            </form>
                        </div>

                        <div class="profile-userbuttons">
                        <form action="customer.php?action=logout" method="post">
                            <input type="submit" class="btn btn-danger btn-sm" value="LOG OUT">
                            </form>
                        </div>
                    
                    <!-- END SIDEBAR BUTTONS -->
                    <!-- SIDEBAR MENU -->
                    <div class="profile-usermenu">
                        <!-- test -->
                    </div>
                    <!-- END MENU -->

                </div>
            </div>
            <!-- End Profile -->

            <!-- Area Basket -->
            <div class="basket">
                <!-- ฺBasket-->
                    <!-- Header Text of Basket -->
                    <div class="text-header">ตะกร้าสินค้า</div>
                    <!-- Action Delete Basket -->
                    <a href="customer.php?action=empty" id="btnEmpty">Empty crt</a>

                    <?php
                        if(isset($_SESSION["cart_item"])){
                            $total_quantity = 0;
                            $total_price = 0;
                    ?>

                    <table class="table-basket" cellpadding="10" cellspacting="1" method="post">
                        <tbody>
                            <tr class="header-title-table">
                                <th style="text-align: center;" width="15%">Name</th>
                                <th style="text-align: center;" width="15%">Code</th>
                                <th style="text-align: right;" width="15%">Amount</th>
                                <th style="text-align: right;" width="15%">Unit Price</th>
                                <th style="text-align: center;" width="15%">Price</th>
                                <th style="text-align: center;" width="15%">Remove</th>
                            </tr>
                                <?php
                                    foreach($_SESSION["cart_item"] as $item){
                                        $item_price = $item["pprice"] * $item["quantity"];
                                ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $item["pname"];?></td>
                                <td style="text-align: center;"><?php echo $item["pid"];?></td>
                                <td style="text-align: right;"><?php echo $item["quantity"];?></td>
                                <td style="text-align: right;"><?php echo $item["pprice"] . " $";?></td>
                                <td style="text-align: center;"><?php echo number_format($item_price,2) . " $";?></td>
                                <td style="text-align: center;"><a href="customer.php?action=remove&pid=<?php echo $item["pid"] ?>"><img src="picture/delete.png" alt="picture-delete" width="15px"></a></td>
                            </tr>

                            <?php
                                $total_quantity += $item["quantity"];
                                $total_price += ($item["pprice"] * $item["quantity"]);
                              }
                            ?>

                            <tr>
                                <td align="right" colspan="4">Total</td>
                                <td align="center" colspan="1"><?php echo number_format($total_price, 2). "$";?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php
                        }else{
                ?>
                    <div class="no-records">Your Cart is Empty</div>
                <?php
                    }
                ?>
                <!-- action for confirm data in store to bill.php -->
                <form action="customer.php?action=confirm" method="post">
                    <input type="submit" value="Confirm" name="save_data" class="table-basket-submit">
                </form>
                <!-- ฺEnd Basket-->
            </div>
            <!-- Area Basket -->
        </div>

        <!-- Product -->
        <div class="container">
            <div class="container-fluid bg-trasparent my-4 p-3" style="position: relative">
                <div class="row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-4 g-3">
                    
                    <!-- All Product -->
                    <?php
                        $product_array = $db_handle->runQuery("SELECT * FROM product ORDER BY pid ASC");
                        if(!empty($product_array)){
                            foreach($product_array as $key => $value){
                                // Select sfname by pId of product.
                                $dataSellerByKey = $conn->query("SELECT * FROM seller WHERE sid = ".$product_array[$key]["sid"]."");
                                $rowSeller = $dataSellerByKey->fetch_assoc();
                                // pamount is not empty.
                                if($product_array[$key]["pamount"] > 0){
                    ?>
                    <div class="col hp">
                        <div class="card h-100 shadow-sm">

                            <form id="addProduct" action="customer.php?action=add&pid=<?php echo $product_array[$key]["pid"];?>" method="post">

                            <div class="card-body">
                                <!-- Price Product -->
                                <div class="clearfix mb-3">
                                    <span class="float-start badge rounded-pill bg-success"><?php echo $product_array[$key]["pname"];?></span>
                                </div>
                                <!-- Name Product -->
                                <h5 class="card-title">
                                    <a ><?php echo "ราคา ".$product_array[$key]["pprice"];?></a>
                                </h5>
                                <!-- Amount Product -->
                                <h5 class="amount-title">
                                    <a >เหลือ <?php echo $product_array[$key]["pamount"];?></a>
                                </h5>
                                <h5 class="seller-title">
                                    <a >ขายโดยพ่อค้า <?php echo $rowSeller["sfname"];?></a>
                                </h5>
                                <!-- Add Product to baskest -->
                                <div class="d-grid gap-2 my-4">
                                    <input type="number" class="product-quantity" name="quantity" value="1" size="2">
                                    <input type="submit" value="Add to cart" name="addProduct" class="btn btn-warning bold-btn">
                                </div>
                            </div>

                            </form>
                        </div>
                    </div>

                    <?php
                            }
                        }
                    }
                    ?>
                    <!-- End All Projuct -->
                </div>
            </div>
        </div>
    </div>
</body>
</html>