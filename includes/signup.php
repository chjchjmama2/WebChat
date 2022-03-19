<?php
    $info = (Object)[];
    $data = false;
    $data['userid'] = $DB->generate_id(20);
    $data['date'] = date("Y-m-d H:i:s");

  
    $data['password'] = $DATA_OBJ->password;
    $password = $DATA_OBJ->retype_password;
    if(empty($DATA_OBJ->password))
    {
        $Error = "\nPlease enter a valid password.";
    }
    else
    {
        if($DATA_OBJ->password != $DATA_OBJ->retype_password)
        {
            $Error .= "\nPasswords must match.";
        }
        if(strlen($DATA_OBJ->password) < 8 )
        {
            $Error .= "\nPassword must be at least 8 characters long.";
        }
    }
    // validate email
    $data['email'] = $DATA_OBJ->email;
    if(empty($DATA_OBJ->email))
    {
        $Error = "\nPlease enter a valid email.";
    }
    else
    {
        if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $DATA_OBJ->email))
        {
            $Error .= "\nPlease enter a valid email.";
        }
    }
    // validate username
    $data['username'] = $DATA_OBJ->username;
    if(empty($DATA_OBJ->username))
    {
        $Error = "\nPlease enter a valid username.";
    }
    else
    {
        if (strlen($DATA_OBJ->username < 3)) {
            $Error .= "\nUsername must be at least 3 characters long.";
        }
        if (!preg_match("/^[a-z A-Z_[:space:]ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂ ưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ]*$/", $DATA_OBJ->username)) {
            $Error .= "\nPlease eneter a valid username.";
        }
    }

    if($Error == "")
    {
        $query = "insert into users (userid,username,email,password,date) 
        values (:userid,:username,:email,:password,:date)";
        $result = $DB->write($query, $data);

        if($result)
        {
            // echo "Your profile was created";
            $info->message = "Your profile was created";
            $info->data_type = "info";
            echo json_encode($info);
        }
        else{
            // echo "Your profile was NOT created";
            $info->message = "Your profile was NOT created due to an error";
            $info->data_type = "error";
            echo json_encode($info);
        }
    }else{
        // echo $Error;
        $info->message = $Error;
        $info->data_type = "error";
        echo json_encode($info);
    }

?>