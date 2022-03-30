<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./ui/css/index.css">
    <title>Online Chat</title>
</head>
<body>
    <div id="wrapper">
        <div id="left_pannel">
            <div id="user_info">
                <img id="profile_img" src="ui/images/male.jpg" alt="User">
                <br>
                <span id="username">Username</span>
                <br>
                <span id="email">email@gmail.com</span> 
                <br>
                <br>
                <br>
                <div id="select_box">
                    <label id="label_chats" for="radio_chat">
                        <strong>Chat</strong>
                        <img src="ui/icons/chat.png" alt="Chat"></label>
                    <label id="label_contacts" for="radio_contacts">
                        <strong>Contacts</strong> 
                        <img src="ui/icons/contacts.png" alt="Contacts"></label>
                    <label id="label_settings" for="radio_settings">
                        <strong>Settings</strong> 
                        <img src="ui/icons/settings.png" alt="Settings"></label>
                    <label id="logout" for="radio_logout">
                        <strong>Logout</strong> 
                        <img src="ui/icons/logout.png" alt="Logout"></label>
                </div>
            </div>
        </div>
        <div id="right_pannel">
            <div id="header">
                <div id="loader_holder" class="loader_on">
                    <img id="loader_on_gif" src="ui/icons/giphy.gif" alt="">
                </div>
                Online Chat
            </div>
            <div id="container">
               
                <div id="inner_left_pannel">
                   
                </div>

                <input type="radio" id="radio_chat" name="myradio">
                <input type="radio" id="radio_contacts" name="myradio">
                <input type="radio" id="radio_settings" name="myradio">

                <div id="inner_right_pannel">
                   
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="ui/js/index.js"></script>
</html>