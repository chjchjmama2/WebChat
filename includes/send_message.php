<?php 
	
	$arr['userid'] = "null";
	if(isset($DATA_OBJ->find->userid)){

		$arr['userid'] = $DATA_OBJ->find->userid;
	}

	$sql = "select * from users where userid = :userid limit 1";
	$result = $DB->read($sql,$arr);

	if(is_array($result)){

		$arr['message'] = message_encrypted($DATA_OBJ->find->message);
		$arr['date'] = date("Y-m-d H:i:s");
		$arr['sender'] = $_SESSION['userid'];
		$arr['msgid'] = get_random_string_max(60);

			$arr2['sender'] = $_SESSION['userid'];
			$arr2['receiver'] = $arr['userid'];
		
			$sql = "select * from messages where (sender = :sender && receiver = :receiver) or 
			(receiver = :sender && sender = :receiver) limit 1";
			$result2 = $DB->read($sql,$arr2);

			if(is_array($result2)){
				$arr['msgid'] = $result2[0]->msgid;
			}

			
		$query = "insert into messages (sender,receiver,message,date,msgid) values (:sender,:userid,:message,:date,:msgid)";
		
		$DB->write($query,$arr);

		//user found
 		$row = $result[0];

 				$image = ($row->gender == "Male") ? "ui/images/user_male.jpg" : "ui/images/user_female.jpg";
  				if(file_exists($row->image)){
  					$image = $row->image;
  				}

  				$row->image = $image;

				$mydata = "Now Chatting with:<br>
							<div id='active_contact'>
								<img src='$image'>
								$row->username
							</div>";
				
				$messages = "
						<div id='messages_holder_parent' >
							<div id='messages_holder'>";
			
								//read from database
								$a['msgid'] = $arr['msgid'];

								$sql = "select * from messages where msgid = :msgid order by id desc limit 10";
								$result2 = $DB->read($sql,$a);

								if(is_array($result2)){
									$result2 = array_reverse($result2);
									foreach ($result2 as $data) {
										$myuser = $DB->get_user($data->sender);
										if($_SESSION['userid'] == $data->sender){
											$messages .= message_right($data,$myuser);
										}else{
											$messages .= message_left($data,$myuser);
										}
									}
								}
						
							$messages .= "</div>";
                    
							$messages .= message_controls();

		$messages .= "</div>";


		$info->user = $mydata;
		$info->messages = $messages;
		$info->data_type = "send_message";
		echo json_encode($info);
	
	}else{

        //user not found
        $info->message = "That contact was not found";
        $info->data_type = "send_message";
        echo json_encode($info);
    }
	

function get_random_string_max($length) {

	$array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	$text = "";

	$length = rand(4,$length);

	for($i=0;$i<$length;$i++) {

		$random = rand(0,61);
		
		$text .= $array[$random];

	}

	return $text;
}

function message_encrypted($message){
	$cipher_algo = "AES-128-CTR"; //The cipher method, in our case, AES 
	$iv_length = openssl_cipher_iv_length($cipher_algo); //The length of the initialization vector
	$option = 0; // Bitwise disjunction of flags
	$encrypt_iv = '8746376827619797'; //Initialization vector, non-null
	$encrypt_key = "1234567890trangtuantruongvu@@##^$!"; // The encryption key
	// Use openssl_encrypt() encrypt the given string
	$encrypted_string = openssl_encrypt($message, $cipher_algo,
				$encrypt_key, $option, $encrypt_iv);

	return $encrypted_string;
}

?>
      
   