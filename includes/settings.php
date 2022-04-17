<?php

    $sql = "select * from users where userid = :userid limit 1";
    $id = $_SESSION['userid'];
    $data = $DB->read($sql, ['userid'=>$id]); 
    
    if (is_array($data)) {
        $data = $data[0];

        // check if image exits
        $image = ($data->gender == "Male") ? "ui/images/male.jpg" : "ui/images/female.jpg";
        if (file_exists($data->image)) {
            $image = $data->image;
        }

        $gender_male = "";
        $gender_female = "";

        if ($data->gender == "Male") {
            $gender_male = "checked";
        } else {
            $gender_female = "checked";
        }

        $mydata = '
            <link rel="stylesheet" href="./ui/css/settings.css">
            <div id="error"></div>
            <div id="container">
                <div>
                    <img ondragover="handle_drag_and_drop(event)" ondragleave="handle_drag_and_drop(event)" ondrop="handle_drag_and_drop(event)" 
                     id="image_settings" src="'.$image.'" />
                    <label for="change_image_input" id="change_image_button" style="">
                        Change Image 
                    </label>
                    <input type="file" onchange="upload_profile_image(this.files)" value="Change Image" id="change_image_input" >
                </div>
                
                <form action="" id="myform">
                    <input style="margin-top:40px" type="text" name="username" placeholder="Username"
                    value="'.$data->username.'"><br>
                    <input  type="text" name="email" placeholder="Email" value="'.$data->email.'">
                    <div id="form_gender">
                        Gender :<br><br>
                        <input style="display: block;" id="gender_male" type="radio" name="gender" '.$gender_male.'>Male<br><br>
                        <input style="display:block;" id="gender_female" type="radio" name="gender" '.$gender_female.'>Female<br>
                    </div>
                    <input type="password" name="password" placeholder="New Password"><br>
                    <input type="password" name="retype_password" placeholder="Retype Password"><br>
                    <input type="button" value="Save Settings" id="save_settings_button" onclick="collect_data(event)"><br>
                </form>

            </div>
           
            ';
    
        $info->message = $mydata;
        $info->data_type = "contacts";
        echo json_encode($info);
    }
    else{
        $info->message = "No contacts were found";
        $info->data_type = "error";
        echo json_encode($info);
    }

?>
