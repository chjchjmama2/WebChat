function _(element){
    return document.getElementById(element);
}


var label = _("label_chats");
label.addEventListener("click",function(){
    var inner_pannel = _("inner_left_pannel");
    var ajax = new XMLHttpRequest();
    ajax.onload = function(){
        if(ajax.status == 200 || ajax.readyState == 4){
            inner_pannel.innerHTML = ajax.responseText;
        }
    }

    ajax.open("POST","file.php", true);
    ajax.send();
});

function get_data(find, type){
    var xml = new XMLHttpRequest();
    var loader_holder = _("loader_holder");
    loader_holder.className = "loader_on";
    xml.onload = function (){
        if(xml.readyState == 4 || xml.status == 200)
        {
            loader_holder.className = "loader_off";
            handle_result(xml.responseText, type);
        }
    }
    var data = {};
    data.find = find;
    data.data_type = type;
    data = JSON.stringify(data);

    xml.open("POST", "api.php", true);
    xml.send(data);
}

function handle_result(result, type)
{
    if(result.trim() != ""){
        var obj = JSON.parse(result);
        if(typeof(obj.logged_in) != "undefined" && !obj.logged_in){
            window.location = "login.php";
        }
        else{
            switch(obj.data_type){
                case "user_info":
                    var username = _("username");
                    var email = _("email");
                    var profile_img = _("profile_img");

                    username.innerHTML = obj.username;
                    email.innerHTML = obj.email;
                    profile_img.src = obj.image;
                    break;

                case "contacts":
                    var inner_left_panel = _("inner_left_pannel");
                    inner_left_panel.innerHTML = obj.message;
                    break;
                case "chats":
                    var inner_left_panel = _("inner_left_pannel");
                    inner_left_panel.innerHTML = obj.message;
                    break;
                case "settings":
                    var inner_left_panel = _("inner_left_pannel");
                    inner_left_panel.innerHTML = obj.message;
                    break;
                case "save_settings":
                    alert(obj.message);
                    get_data({},"user_info");
                    get_settings(true);
                    break;
            };
        }
    }
}

var logout = _("logout");
logout.addEventListener("click", logout_user);
function logout_user(){
    var answer = confirm("Are you sure you want to logout?");
    if(answer)
    {
        get_data({}, "logout");
    }
   
}

var label_contacts = _("label_contacts");
label_contacts.addEventListener("click",get_contacts);
function get_contacts(e){
    get_data({},"contacts");
}

var label_chats = _("label_chats");
label_chats.addEventListener("click", get_chats);
function get_chats(e){
    get_data({},"chats");
}

var label_settings = _("label_settings");
label_settings.addEventListener("click", get_settings);
function get_settings(e){
    get_data({},"settings");
}


get_data({},"user_info");

function _(element){

    return document.getElementById(element);
}

function collect_data(){
    var save_settings_button = _("save_settings_button");
    save_settings_button.disabled = true;
    save_settings_button.value = "Loading...Please wait...";

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
            case "gender":
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
    send_data(data,"save_settings");
}
function send_data(data, type){
    var xml = new XMLHttpRequest();
    xml.onload = function(){
        if(xml.readyState == 4 || xml.status == 200){
            handle_result(xml.responseText);
            var save_settings_button = _("save_settings_button");
            save_settings_button.disabled = false;
            save_settings_button.value = "Save Settings";
        }
    }
        data.data_type = type;
        var data_string = JSON.stringify(data);
        xml.open("POST","api.php",true);
        xml.send(data_string);
}
function upload_profile_image(files){
    var change_image_button = _("change_image_button");
    change_image_button.disabled = true;
    change_image_button.innerHTML = "Uploading Image...";

    var myform = new FormData();
    var xml = new XMLHttpRequest();
    xml.onload = function(){
        if(xml.readyState == 4 || xml.status == 200){
            // alert(xml.responseText);
            alert("Your image was changed successfully.");
            get_data({}, 'user_info');
            get_settings(true);
            change_image_button.disabled = false;
            change_image_button.innerHTML = "Change Image";
        }
    }
        myform.append('file', files[0]);
        myform.append('data_type', "change_profile_image");

        xml.open("POST","uploader.php",true);
        xml.send(myform);
}
function handle_drag_and_drop(e)
{
    if(e.type == "dragover"){
        e.preventDefault();
        e.target.className = "dragging";
    }
    else if(e.type == "dragleave")
    {
        e.target.className = "";
    }
    else if(e.type == "drop")
    {
        e.preventDefault();
        e.target.className = "";

        upload_profile_image(e.dataTransfer.files);
    }
    else
    {
        e.target.className = "";
    }
}