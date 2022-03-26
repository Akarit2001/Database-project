<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill</title>
    <link rel = 'stylesheet' href = 'css/style_bill.css'>
</head>
<body>
    <header class = "top-header" style = "font-family: Times New Roman">
        <a class = "menu-item" href="#">Home </a>
        <a class = "menu-item" href="#">Product </a>
    </header>

    <div id="invoice-POS">
    <center id="top" >
        
    <div class="logo"></div>
        <div class="info"> 
        <h2>ONLINE STORE</h2>
        </div><!--End Info-->
        
    </center><!--End InvoiceTop-->

    <div id="mid" >
        <div class="info">
        <h2>Contact Info</h2>
        
        <p> 
            <?php
                session_start();
                echo "User ID : ".$_SESSION['userID']."<br>";
                echo "Customer Name : ".$_SESSION['customername']."<br>";
                echo "Phone : ".$_SESSION['phone']."<br>";
                echo "ADDRESS : ".$_SESSION['addr']."<br>";
            ?>
            
        </p>
        
        </div>
    </div><!--End Invoice Mid-->
    <div id="bot">

            <div id="table" >
            <table>

                <tr class="tabletitle">
                <td class="item"><h2>Item</h2></td>
                <td class="Hours"><h2>Qty</h2></td>
                <td class="Rate"><h2>Sub Total</h2></td>
                <td class="Rate"><h2>Total</h2></td>
                </tr>
                
                <!-- All menu -->
                <?php
                $total_price = 0;
                foreach($_SESSION["bill"] as $item){
                    $item_price = $item["pprice"] * $item["quantity"];
                ?>
                <tr class="service">
                <td class="tableitem"><p class="itemtext"><?php echo $item["pname"]?></p></td>
                <td class="tableitem"><p class="itemtext"><?php echo $item["quantity"]?></p></td>
                <td class="tableitem"><p class="itemtext"><?php echo $item["pprice"]?></p></td>
                <td class="tableitem"><p class="itemtext"><?php echo $item_price?></p></td>
                </tr>
                
                <?php

                    $total_price += ($item["pprice"] * $item["quantity"]);
                }
                ?>

            <tr class="tabletitle">
                <td></td>
                <td></td>
                <td class="Rate"><h2>Total</h2></td>
                <td class="payment"><h2><?php echo $total_price?></h2></td>
                </tr>

            </table>
            </div><!--End Table-->
            <a class = "button" href="customer.php">BACK </a>
            <div id="legalcopy" >
            <p class="legal"><strong>Thank you for your business!</strong>  Payment is expected within 31 days </br>please process this invoice within that time. There will be a 5% interest charge per month on late invoices. 
            </p>
            </div>
</div><!--End InvoiceBot-->
    </div><!--End Invoice-->
    
</body>
</html>