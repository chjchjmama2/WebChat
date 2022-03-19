<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./ui/css/login.css">
    <title>Login</title>
</head>
<body>
    <div id="wrapper">
        <div id="header">
            Online Chat
            <div id="header_signup">Login</div>
        </div>
        <div id="error"></div>
        <form action="" id="myform">
            <input type="text" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password"><br>
            <input type="submit" value="Login" id="login_button"><br>
            <br>
            <a id="link_signup" href="signup.php">Don't have an Account? Signup here</a>
        </form>
    </div>
</body>
<script type="text/javascript" src="./ui/js/login.js"></script>
</html>