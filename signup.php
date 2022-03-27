<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./ui/css/signup.css">
    <title>Sign up</title>
</head>
<body>
    <div id="wrapper">
        <div id="header">
            Online Chat
            <div id="header_signup">Sign up</div>
        </div>
        <div id="error"></div>
        <form action="" id="myform">
            <input type="text" name="username" placeholder="Username"><br>
            <input type="text" name="email" placeholder="Email">
            <div id="form_gender">
                Gender :<br><br>
                <input id="gender_male" type="radio" name="gender_male">Male<br><br>
                <input id="gender_female" type="radio" name="gender_female">Female<br>
            </div>
            <input type="password" name="password" placeholder="Password"><br>
            <input type="password" name="retype_password" placeholder="Retype Password"><br>
            <input type="button" value="Sign up" id="signup_button"><br>
            
            <br>
            <a id="link_login" href="login.php" style="display: block; text-decoration:none; text-align:center; font-size:14px">
                Already have an Account? Login here</a>
        </form>
    </div>
</body>
<script type="text/javascript" src="./ui/js/signup.js"></script>
</html>