<?php
    $info = (Object)[];
     
    $data = false;
    $data['userid'] = $_SESSION['userid'];

  
    $data['password'] = md5($DATA_OBJ->password);
    $password = $DATA_OBJ->retype_password;
    if(empty($DATA_OBJ->password))
    {
        $Error = "\nPlease enter a valid password. <br>";
    }
    else
    {
        if($DATA_OBJ->password != $DATA_OBJ->retype_password)
        {
            $Error .= "\nPasswords must match. <br>";
        }
        if(strlen($DATA_OBJ->password) < 8 )
        {
            $Error .= "\nPassword must be at least 8 characters long. <br>";
        }
    }
    // validate email
    $data['email'] = $DATA_OBJ->email;
    if(empty($DATA_OBJ->email))
    {
        $Error = "\nPlease enter a valid email. <br>";
    }
    else
    {
        if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $DATA_OBJ->email))
        {
            $Error .= "\nPlease enter a valid email. <br>";
        }
    }
    // validate gender
	$data['gender'] = isset($DATA_OBJ->gender) ? $DATA_OBJ->gender : null;
	if(empty($DATA_OBJ->gender))
	{
		$Error .= "\nPlease select a gender . <br>";
	}else
	// {
	 
	// 	if($DATA_OBJ->gender != "Male" && $DATA_OBJ->gender != "Female")
	// 	{
	// 		$Error .= "Please select a valid gender . <br>";
	// 	}
 		
	// }
    // validate username
    $data['username'] = $DATA_OBJ->username;
    if(empty($DATA_OBJ->username))
    {
        $Error = "\nPlease enter a valid username. <br>";
    }
    else
    {
        if (strlen($DATA_OBJ->username < 3)) {
            $Error .= "\nUsername must be at least 3 characters long. <br>";
        }
        if (!preg_match("/^[a-z A-Z_[:space:]ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂ ưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ]*$/", $DATA_OBJ->username)) {
            $Error .= "\nPlease eneter a valid username. <br>";
        }
    }

    if($Error == "")
    {
        $query = "update users set username = :username, email = :email, gender = :gender, password = :password
        where userid = :userid limit 1";
        $result = $DB->write($query, $data);

        if($result)
        {
            // echo "Your data was saved";
            $info->message = "Your data was saved";
            $info->data_type = "save_settings";
            echo json_encode($info);
        }
        else{
            // echo "Your data was NOT created";
            $info->message = "Your data was NOT saved due to an error";
            $info->data_type = "save_settings";
            echo json_encode($info);
        }
    }else{
        // echo $Error;
        $info->message = $Error;
        $info->data_type = "save_settings";
        echo json_encode($info);
    }

?>