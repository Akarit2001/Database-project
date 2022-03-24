<?php
    session_start();
    require_once('dbcontroller.php');
    $db_handle = new DBController();
?>

<!DOCTYPE html>
<html lang="en">

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
    <link rel="stylesheet" href="css/style_user.css">

</head>

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
                            Jason Davis
                        </div>
                        <div class="profile-usertitle-job">
                            USER ID: 000000000000
                        </div>
                        <div class="profile-usertitle-phone">
                            Phone: xxxxxxxxxx
                        </div>
                        <div class="profile-usertitle-address">
                            Address: xxxxxxxxxx
                        </div>
                        <div class="profile-usertitle-gmail">
                            Gmail: xxxxxxxxxx
                        </div>
                    </div>
                    <!-- END SIDEBAR USER TITLE -->
                    <!-- SIDEBAR BUTTONS -->
                    <div class="profile-userbuttons">
                        <button type="button" class="btn btn-danger btn-sm" onclick="window.open('index.html');self.close()">log out</button>
                    </div>
                    <!-- END SIDEBAR BUTTONS -->
                    <!-- SIDEBAR MENU -->
                    <div class="profile-usermenu">
                        <!-- test -->
                    </div>
                    <!-- END MENU -->

                </div>
            </div>

            <!-- Box Basket -->
            <div class="basket">
                <!-- ฺBasket-->
                    <div class="text-header">ตะกร้าสินค้า</div>
                    <a href="user.php?action=empty" id="btnEmpty">Empty crt</a>

                    <?php
                        if(isset($_SESSION["cart_item"])){
                            $total_quantity = 0;
                            $total_price = 0;
                        }
                    ?>

                    <?php
                        foreach($_SESSION["cart_item"] as $item){
                            $item_price = $item["quantity"] = $item["price"];
                    ?>

                    <table class="table-basket" cellpadding="10" cellspacting="1">
                        <tbody>
                            <tr>
                                <th style="text-align: left;" width="15%">Name</th>
                                <th style="text-align: left;" width="15%">Code</th>
                                <th style="text-align: right;" width="15%">Amount</th>
                                <th style="text-align: right;" width="15%">Unit Price</th>
                                <th style="text-align: right;" width="15%">Price</th>
                                <th style="text-align: center;" width="15%">Remove</th>
                            </tr>

                            <tr>
                                <td><img src="./product-images/product.png" style="width:10px;" class="cart-item-image" alt=""><<?php echo $item["pName"];?>/td>
                                <td><?php echo $item["pId"];?></td>
                                <td style="text-align: right;"><?php echo $item["pAmount"];?></td>
                                <td style="text-align: right;"><?php echo $item["pPrice"] . " $";?></td>
                                <td style="text-align: right;"><?php echo number_format($item["pPrice"]) . " $";?>/td>
                                <td style="text-align: center;" href="user.php?action=remove&pId=<?php echo $item["pId"];?>"class="btnRemoveAction"><img src="delete.png" style="width: 10px" alt="Remove Item"></td>
                            </tr>

                            <?php
                                $total_quantity += $item["pAmount"];
                                $total_price += ($item["pPrice"] * $item["pAmount"]);
                            ?>

                            <tr>
                                <td colspan="2" align="right">Total</td>
                                <td align="right"><?php echo $total_quantity;?></td>
                                <td align="right" colspan="2"><?php echo number_format($total_price, 2). "$";?></td>
                            </tr>
                        </tbody>
                    </table>
                <
                <?php
                    }
                ?>
            </div>
        </div>

        <!-- Product -->
        <div class="container">
            <div class="container-fluid bg-trasparent my-4 p-3" style="position: relative">
                <div class="row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-4 g-3">
                    

                    
                    <!-- All Product -->
                    <?php
                        $product_array = $db_handle->runQuery("SELECT * FROM product ORDER BY pId ASC");
                        if(!empty($product_array)){
                            foreach($product_array as $key => $value){

                    ?>
                    <div class="col hp">
                        <div class="card h-100 shadow-sm">
                            <a href="#">
                                <img src="https://m.media-amazon.com/images/I/81gK08T6tYL._AC_SL1500_.jpg"
                                    class="card-img-top" alt="product.title" />
                            </a>

                            <div class="card-body">
                                <!-- Price Product -->
                                <div class="clearfix mb-3">
                                    <span class="float-start badge rounded-pill bg-success"><?php echo $product_array[$key]["pPrice"];?></span>
                                </div>
                                <!-- Name Product -->
                                <h5 class="card-title">
                                    <a ><?php echo $product_array[$key]["pName"];?></a>
                                </h5>
                                <!-- Amount Product -->
                                <h5 class="seller-title">
                                    <a >จำนวน<?php echo $product_array[$key]["pAmount"];?></a>
                                </h5>
                                <!-- Add Product to baskest -->
                                <div class="d-grid gap-2 my-4">

                                    <input type="number" class="product-quantity" name="quantity" value="1" size="2">
                                    <a href="#" class="btn btn-warning bold-btn">add to cart</a>

                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
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