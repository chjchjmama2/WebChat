<?php
    $mydata = '
    <style type="text/css">
    form{
        text-align:left; 
        margin: auto;
        padding: 10px;
        width: 100%;
        max-width: 400px ;
    }
    #form_gender{
        padding: 10px;
    }
    input[type=text], input[type=password], input[type=button]{
        padding: 10px;
        margin: 10px;
        width: 200px;
        border-radius: 5px;
        border: solid 1px grey;
    }
    input[type=button]{
        padding: 10px;
        width: 200px;
        cursor: pointer;
        background-color: #2b5488;
        color: white;
    }
    input[type=radio]{
        transform: scale(1.2);
        cursor: pointer;
    }
    </style>
    <div id="error"></div>
    <div style="display:flex">
        <div>
            <img src="ui/images/male.jpg" style="width=250px; height:250px; margin:50px" />
            <input type="button" value="Change Image" id="change_image_button" style="background-color:#9b9a80;"><br>
        </div>
        
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
            <input type="button" value="Save Settings" id="save_settings_button"><br>
        </form>
        
    </div>
    <script type="text/javascript">
    function _(element){
   
        return document.getElementById(element);
    }
    
    var signup_button = _("signup_button");
    signup_button.addEventListener("click",collect_data);
    
    function collect_data(){
        signup_button.disabled = true;
        signup_button.value = "Loading...Please wait...";
    
        var myform = _("myform");
        var inputs = myform.getElementsByTagName("INPUT");
        
        var data ={};
        for(var i = inputs.length - 1; i >= 0 ;i--){
            var key = inputs[i].name;
            switch(key){
                case "username":
                    data.username = inputs[i].value;
                    break;
                case "email":
                    data.email = inputs[i].value;
                    break;
                case "gender_male":
                case "gender_female":
                    if(inputs[i].checked){
                        data.gender = inputs[i].value;
                    }
                    break;
                case "password":
                    data.password = inputs[i].value;
                    break;
                case "retype_password":
                    data.retype_password = inputs[i].value;
                    break;
            }
        }
        send_data(data,"signup");
    }
    function send_data(data, type){
        var xml = new XMLHttpRequest();
        xml.onload = function(){
            if(xml.readyState == 4 || xml.status == 200){
                // alert(xml.responseText);
                handle_result(xml.responseText);
                signup_button.disabled = false;
                signup_button.value = "Sign up";
            }
        }
            data.data_type = type;
            var data_string = JSON.stringify(data);
            xml.open("POST","api.php",true);
            xml.send(data_string);
    }
    
    function handle_result(result){
        var data = JSON.parse(result);
        if(data.data_type == "info"){
            window.location = "index.php";
        }else
        {
            var error = _("error");
            error.innerHTML = data.message;
            error.style.display = "block";
        }
    }    
    </script>
    ';

    $info->message = $mydata;
    $info->data_type = "contacts";
    echo json_encode($info);

    die;

    $info->message = "No contacts were found";
    $info->data_type = "error";
    echo json_encode($info);
?>
