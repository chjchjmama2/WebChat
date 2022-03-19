function _(element){
    return document.getElementById(element);
}

var label = _("label_chat");
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
    xml.onload = function (){
        if(xml.readyState == 4 || xml.status == 200)
        {
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