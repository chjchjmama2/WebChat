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
                    username.innerHTML = obj.username;
                    email.innerHTML = obj.email;
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