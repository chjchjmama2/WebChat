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
            <div style="padding: 10px;">
                <img id="profile_img" src="ui/images/user1.jpg" alt="Võ Ngọc Minh Trang">
                <br>
                Võ Ngọc Minh Trang 
                <br>
                <span>vongocminhtrang@gmail.com</span> 
                <br>
                <br>
                <br>
                <div id="select_box">
                    <label id="label_chat" for="radio_chat">
                        <strong>Chat</strong>
                        <img src="ui/icons/chat.png" alt="Chat"></label>
                    <label id="label_chat" for="radio_contacts">
                        <strong>Contacts</strong> 
                        <img src="ui/icons/contacts.png" alt="Contacts"></label>
                    <label id="label_chat" for="radio_settings">
                        <strong>Settings</strong> 
                        <img src="ui/icons/settings.png" alt="Settings"></label>
                </div>
            </div>
        </div>
        <div id="right_pannel">
            <div id="header">Online Chat</div>
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
<script type="text/javascript" src="./ui/js/index.js"></script>
</html>