<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <!-- <link rel="stylesheet" href="css/style_usre.css"> -->
    <link rel="stylesheet" href="css/style_register.css">
    <link rel="stylesheet" href="css/style_main.css">
    <title>สมัครสมากชิก</title>
</head>

<body>

    <div class="container">

        <a href="index.php" class="back-btn">back</a>


        <form action="/action_page.php">
            <div class="container">
                <h1>Register</h1>
                <p>Please fill in this form to create an account.</p>
                <hr>

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
                <input type="tel" placeholder="123-45-678" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" name="phone" id="phone" required>
                <label for="address"><b>Address</b></label>
                <input type="text" placeholder="Enter address" name="address" id="address" required>
                <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
                <label for="opt">ตำแหน่ง</label>

                <select name="cars" id="opt">
                    <option value="sell">Sell</option>
                    <option value="cus">Customer</option>
                </select>
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