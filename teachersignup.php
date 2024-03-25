<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>MooreCoin</title>

        <link rel="stylesheet" href="CSS/style.css">

        <link rel="icon" type="image/x-icon" href="Images/favicon.png">
    </head>

    <body>
        <div id="blurry-circle"></div>
        <script src="JS/circle.js"></script>
        <script src="JS/error.js"></script>

        <div class="center">
            <h1>Sign up for <span class="moorecoin">MooreCoin</span></h1>

            <spacer></spacer>

            <form action="PHP/teachersignup.php" method="post" class="form">
                <label for="email">
                    <input id="email" type="text" name="email" placeholder="Email" required>
                </label><br>

                <label for="name">
                    <input id="name" type="text" name="name" placeholder="Name" required>
                </label><br>
                
                <label for="pwd">
                    <input id="pwd" type="password" name="pwd" placeholder="Password" required>
                </label><br>

                <label for="cpwd">
                    <input id="cpwd" type="password" name="cpwd" placeholder="Confirm Password" required>
                </label><br>

                <button type="submit" class="button-full">Sign Up</button>

                <spacer></spacer>

                <a href="student.php" class="a">I'm a Student</a>
                <a href="teacherlogin.php" class="a">Log In</a>
            </form>
        </div>
    </body>
</html>