var sent_audio = new Audio("message_sent.mp3");
var received_audio = new Audio("message_received.mp3");

var CURRENT_CHAT_USER = "";
var SEEN_STATUS = false;

function _(element){
    return document.getElementById(element);
}

function get_data(find, type){
    var xml = new XMLHttpRequest();
	var loader_holder = _("loader_holder");
	loader_holder.className = "loader_on";

	xml.onload = function (){

	if(xml.readyState == 4 || xml.status == 200)
    {
		loader_holder.className = "loader_off";
		handle_result(xml.responseText,type);
		}
	}

    var data = {};
    data.find = find;
    data.data_type = type;
    data = JSON.stringify(data);

    xml.open("POST","api.php",true);
    xml.send(data);
}

function handle_result(result, type)
{
    // alert(result);
    if(result.trim() != ""){

        var inner_right_panel = _("inner_right_pannel");
        inner_right_panel.style.overflow = "visible";

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
                
                    inner_right_panel.style.overflow = "hidden";
                    inner_left_panel.innerHTML = obj.message;
                    break;


                case "chats_refresh":
                    SEEN_STATUS = false;
                    var messages_holder = _("messages_holder");
                    messages_holder.innerHTML = obj.messages;
                    if(typeof obj.new_message != 'undefined'){
                        if(obj.new_message){
                            received_audio.play();
                            setTimeout(function(){
                                messages_holder.scrollTo(0,messages_holder.scrollHeight);
                                var message_text = _("message_text");
                                message_text.focus();
                            },100);
                        }
                    }
                    break;

                case "send_message":
                    sent_audio.play();
                case "chats":
                    SEEN_STATUS = false;
                    var inner_left_panel = _("inner_left_pannel");

                    inner_left_panel.innerHTML = obj.user;
                    inner_right_panel.innerHTML = obj.messages;
                    
                    var messages_holder = _("messages_holder");
                    setTimeout(function(){
                        messages_holder.scrollTo(0,messages_holder.scrollHeight);
                        var message_text = _("message_text");
                        message_text.focus();
                    },100);
                    if(typeof obj.new_message != 'undefined'){
                        if(obj.new_message){
                            received_audio.play();
                        }
                    }
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
                
                case "send_image" :
                    alert(obj.message);
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


get_data({},"user_info");
get_data({},"contacts");

var radio_contacts = _("radio_contacts");
radio_contacts.checked = true ;

var label_contacts = _("label_contacts");
label_contacts.addEventListener("click",get_contacts);
function get_contacts(e){
    get_data({},"contacts");
}

var label_chats = _("label_chats");
label_chats.addEventListener("click", get_chats);
function get_chats(e){
    get_data({
        seen: SEEN_STATUS, 

    },"chats");
}

var label_settings = _("label_settings");
label_settings.addEventListener("click", get_settings);
function get_settings(e){
    get_data({},"settings");
}

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

function start_chat(e){
    var userid = e.target.getAttribute("userid");
    if(e.target.id == ""){
        userid = e.target.parentNode.getAttribute("userid");
    }
    CURRENT_CHAT_USER = userid;

    var radio_chat = _("radio_chat");
    radio_chat.checked = true;
    get_data({ userid:CURRENT_CHAT_USER,}, "chats");
}    

function send_message(e){
    var message_text = _("message_text");
    if(message_text.value.trim() == "")
    {
        alert("Nothing to send!");
        return ;
    }
    // alert(message_text.value);
    get_data({
        message: message_text.value.trim(),
        userid: CURRENT_CHAT_USER
    },"send_message");

    // location.reload();
}

function enter_pressed(e){
    if(e.keyCode == 13)
    {
        send_message(e);
    }
    SEEN_STATUS = true;
}

setInterval(function(){
    var radio_chat = _("radio_chat");
    var radio_contacts = _("radio_contacts");
    if(CURRENT_CHAT_USER != "" && radio_chat.checked){
        get_data({
            userid: CURRENT_CHAT_USER,
            seen: SEEN_STATUS
            },"chats_refresh");
    }

    if(radio_contacts.checked){
        get_data({
            userid: CURRENT_CHAT_USER,
            seen: SEEN_STATUS
            },"chats_refresh");
    }
},60000);

function set_seen(e){
    SEEN_STATUS = true;
}

function delete_message(e){
    if(confirm("Are you sure you want to delete this message?")){
        var msgid = e.target.getAttribute("msgid");
        get_data({
            rowid: msgid
        },"delete_message");

        get_data({
            userid: CURRENT_CHAT_USER,
            seen: SEEN_STATUS,
        },"chats_refresh"); 
    }
    location.reload();
}

function delete_thread(e){
    if(confirm("Are you sure you want to delete this whole thread?")){
        get_data({
            userid: CURRENT_CHAT_USER
        },"delete_thread");

        get_data({
            userid: CURRENT_CHAT_USER,
            seen: SEEN_STATUS,
        },"chats_refresh"); 
    }
    location.reload();
}

function send_image(files){
    var filename = files[0].name;
    var ext_start = filename.lastIndexOf(".");
    var ext = filename.substr(ext_start + 1 ,3);
    if(!(ext == "jpg" || ext == "JPG" || ext == "jpeg" || ext == "JPEG" || ext == "png" || ext == "PNG")){
        alert("This file type is not allowed");
        return;
    }
    var myform = new FormData();
    var xml = new XMLHttpRequest();

    xml.onload = function(){
        if(xml.readyState == 4 || xml.status == 200){
            handle_result(xml.responseText,"send_image");
            get_data({
                userid: CURRENT_CHAT_USER,
                seen: SEEN_STATUS
            },"chats_refresh");
        }
    }
        myform.append('file', files[0]);
        myform.append('data_type', "send_image");
        myform.append('userid', CURRENT_CHAT_USER);

        xml.open("POST","uploader.php",true);
        xml.send(myform);

        location.reload();
}

function close_image(e){
    e.target.className = "image_off";
    document.getElementsByClassName("change_background")[0].style.display = "none";
    
}

function image_show(e){

    var image = e.target.src;
    var image_viewer = _("image_viewer");

    image_viewer.innerHTML = "<img src='"+image+"' style='width:100%' />";
    image_viewer.className = "image_on";
    document.getElementsByClassName("change_background")[0].style.display = "block";
}


