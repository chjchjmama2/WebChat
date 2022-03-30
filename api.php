<?php
    session_start();
    
    $DATA_RAW = file_get_contents("php://input");
    $DATA_OBJ = json_decode($DATA_RAW);

    $info = (object)[];
    // check if logged in 
    if(!isset($_SESSION['userid']))
    {
        if(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type != "login" && $DATA_OBJ->data_type != "signup"){
            $info->logged_in = false;
            echo json_encode($info);
            die;
        } 
    }
    
    require_once("./classes/autoload.php");
    $DB = new Database();
    
    $Error = "";    
    // process the data
    if(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "signup"){
        
        // signup
       include("includes/signup.php");
    }
    elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "login"){

        // login
        include("includes/login.php");
    }
    elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "logout"){

        // logout
        include("includes/logout.php");
    }
    elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "user_info"){
       
        // user info
        include("includes/user_info.php");
    } 
    elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "contacts"){
       
        // contacts
        include("includes/contacts.php");
    }
    elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "chats"){
       
        // chats
        include("includes/chats.php");
    }
    elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "settings"){
       
        // settings
        include("includes/settings.php");
    }
    elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "save_settings"){
       
        // save_settings
        include("includes/save_settings.php");
    }


?>