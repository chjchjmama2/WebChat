<?php
    
    $sql = "select * from users limit 10";
    $myusers = $DB->read($sql, []);

    $mydata = 
    '<div id="wrapper_contact">';
    
    if(is_array($myusers)){
        foreach($myusers as $row)
        {
            $image = ($row->gender == "Male") ? "ui/images/male.jpg" : "ui/images/female.jpg";
            if(file_exists($row->image)){
                $image = $row->image;
            }
            $mydata .= "
            <div id='contact'>
                    <img src='$image'>
                    <br>$row->username
            </div>";
        }
    }

    $mydata .= '         
            </div>';

    $info->message = $mydata;
    $info->data_type = "contacts";
    echo json_encode($info);

    die;

    $info->message = "No contacts were found";
    $info->data_type = "error";
    echo json_encode($info);
?>
