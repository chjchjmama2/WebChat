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
    elseif(isset($DATA_OBJ->data_type) && ($DATA_OBJ->data_type == "chats" || $DATA_OBJ->data_type == "chats_refresh")){
       
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
    elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "send_message"){

        // send_message
        include("includes/send_message.php");
    }
    elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "delete_message"){

        // delete_message
        include("includes/delete_message.php");
    }
    elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "delete_thread"){

        // delete_thread
        include("includes/delete_thread.php");
    }

    function message_left($data, $row){
        $image = ($row->gender == "Male") ? "ui/images/male.jpg" : "ui/images/female.jpg";
        if(file_exists($row->image)){
            $image = $row->image;
        }

        $a = "
        <div id='message_left'>

        <div>";

        if($data->seen){
            $a .= "<img id='seen_img' src='ui/icons/tick.png' />";
        }elseif($data->received){ 
            $a .= "<img id='seen_img' src='ui/icons/tick_grey.png' />";
        }
       

        $a .= "</div>
            <img id = 'prof_img' src='$image'>
            <b>$row->username</b><br>
            $data->message<br><br><br>";

            if($data->files != "" && file_exists($data->files)){
                $a .= "<img id='message_image_file' src='$data->files' onclick='image_show(event)' /> <br>";
            }
            
            $a .= "<span>".date("jS M Y",strtotime($data->date))."</span>

        </div>";
        return $a;
    }

    function message_right($data, $row){
        $image = ($row->gender == "Male") ? "ui/images/male.jpg" : "ui/images/female.jpg";
        if(file_exists($row->image)){
            $image = $row->image;
        }

        $a = "
        <div id='message_right'>

        <div>";

        if($data->seen){
            $a .= "<img id='seen_img' src='ui/icons/tick.png' style = '   
           '/>";
        }elseif($data->received){ 
            $a .= "<img id='seen_img' src='ui/icons/tick_grey.png' />";
        }
       
        $a .= "</div>
            <img id='prof_img' src='$image'>
            <b>$row->username</b><br>
            $data->message<br><br><br>";

            if($data->files != "" && file_exists($data->files)){
                $a .= "<img id='message_image_file' src='$data->files' onclick='image_show(event)' /> <br>";
            }

            $a .= "<span>".date("jS M Y",strtotime($data->date))."</span>

            <img id='trash' src='ui/icons/trash.png' onclick='delete_message(event)' msgid='$data->id'/>
        </div>";
        return $a;
    }

    function message_controls(){
        return "
        <span id='messages_delete_this_thread' onclick='delete_thread(event)'>Delete this thread</span> 
        <div id='messages_footer'>
            <label for='message_file' >
                <img src='./ui/icons/Editing-Attach-icon.png' />
            </label>
            <input type='file' id='message_file' name='file' onchange='send_image(this.files)' />
            <input type='text' id='message_text' onkeyup='enter_pressed(event)' placeholder='Type your message' />
            <input type='button' value='send' onclick='send_message(event);' />
		</div>";
    }

?>
