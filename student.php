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

        <div class="center">
            <h1>Welcome to <span class="moorecoin">MooreCoin</span>!</h1>
            <p>As a student, you can earn coins, which you can turn in to earn extra credit or another reward.<br>Your teacher should give you a code to join a class. There, you will be able to spend any coins you make on your teachers desired reward.</p>
            <p>Enter the code below to get started, or click a link given to you by your teacher.</p>

            <form action="student.php" method="post" class="form">
                <label for="code">
                    <input type="text" name="code" placeholder="Enter Class Code" pattern="[a-zA-Z0-9]+" minlength="6" maxlength="6" oninvalid="this.setCustomValidity('This is not a valid code.');" required>
                </label>
                <br>
                <button type="submit" class="button-outline">Join Class</button>

                <spacer></spacer>

                <a href="studentlogin.php" class="a">Log In</a>
            </form>
        </div>
    </body>
</html>