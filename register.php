<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="stylesheet" href="css/style_usre.css"> -->
    <link rel="stylesheet" href="css/style_register.css">
    <link rel="stylesheet" href="css/style_main.css">
</head>

<body>

    <div class="container">

            <a  href="index.html" class="back-btn">back</a>


        <form action="/action_page.php">
            <div class="container">
                <h1>Register</h1>
                <p>Please fill in this form to create an account.</p>
                <hr>

                <label for="name"><b>Name</b></label>
                <input type="text" placeholder="Enter name" name="name" id="name" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

                <label for="psw-repeat"><b>Repeat Password</b></label>
                <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>
                <hr>
                <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

                <button type="submit" class="registerbtn" onclick="self.close();window.open('index.html')" >Register</button>
            </div>
            <script src="js/script.js"></script>
            <div class="container signin">
                <p>Already have an account? <a href="index.html">Sign in</a>.</p>
            </div>
        </form>
    </div>

</body>

</html>