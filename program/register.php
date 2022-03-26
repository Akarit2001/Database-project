<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <!-- <link rel="stylesheet" href="css/style_usre.css"> -->
    <link rel="stylesheet" href="css/style_register.css">
    <link rel="stylesheet" href="css/style_main.css">
    <title>Register</title>
</head>

<body>

    <div class="container">

        <div class="bb">
            <a href="index.php" class="back-btn">back</a>
        </div>


        <form action="./script/registerCheck.php" method="post">
            <div class="container">
                <h1>Register</h1>
                <p>Please fill in this form to create an account.</p>
                <hr>
                <label class="opt" for="opt"><b>ตำแหน่ง*</b></label>
                <select name="position" id="opt">
                    <option value="cus">
                        <p class="ooo">Customer</p>
                    </option>
                    <option value="sell">
                        <p class="ooo">Seller</p>
                    </option>
                </select><br>
                <label for="fname"><b>First Name</b></label>
                <input type="text" placeholder="Enter name" name="fname" id="fname" required>
                <label for="lname"><b>Last Name</b></label>
                <input type="text" placeholder="Enter last name" name="lname" id="lname" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

                <label for="psw-repeat"><b>Repeat Password</b></label>
                <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>
                <hr>
                <label for="phone"><b>Phone</b></label>
                <input type="tel" placeholder="0123456789" pattern="[0-9]{10}" name="phone" id="phone" required>
                <label for="address"><b>Address</b></label>
                <input type="text" placeholder="Enter address" name="address" id="address" required>
                <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>



                <button type="submit" class="registerbtn">Register</button>
            </div>
            <script src="js/script.js"></script>
            <div class="container signin">
                <p>Already have an account? <a href="index.php">Sign in</a>.</p>
            </div>
        </form>
    </div>

</body>

</html>