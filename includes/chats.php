<?php
    $arr['userid'] = "null";
    if(isset($DATA_OBJ->find->userid)){
        $arr['userid'] = $DATA_OBJ->find->userid;
    }

    $refresh = false;
    $seen = false;
    if($DATA_OBJ->data_type == "chats_refresh"){
        $refresh = true;
        $seen = $DATA_OBJ->find->seen;
    }

    $sql = "select * from users where userid = :userid limit 1";
    $result = $DB->read($sql,$arr);

    if(is_array($result)){

        // user found
        $row = $result[0];

        $image = ($row->gender == "Male") ? "ui/images/male.jpg" : "ui/images/female.jpg";
        if(file_exists($row->image)){
            $image = $row->image;
        }

        $row->image = $image;
            if(!$refresh){
                $mydata = "<br> Now Chatting with : <br>
                <div id='active_contact'>
                        <img src='$image'>
                        $row->username
                </div>";
            }

            $messages = ""; 
            $new_message = false;

            if(!$refresh){
                $messages = "<br> 
                <div id='messages_holder_parent' onclick = 'set_seen(event)' >
                    <div id='messages_holder'>";
                    // $messages .= message_left($row, $data);
                    // $messages .= message_right($row, $data);
            }

                        //read from database
                        $a['sender'] = $_SESSION['userid'];
                        $a['receiver'] = $arr['userid'];

                        $sql = "select * from messages where (sender = :sender && receiver = :receiver && deleted_sender = 0) || 
                        (receiver = :sender && sender = :receiver && deleted_receiver = 0) order by id desc limit 10";
                        
                        $result2 = $DB->read($sql,$a);

                        if(is_array($result2)){
                            $result2 = array_reverse($result2);
                            foreach ($result2 as $data) {
                                $myuser = $DB->get_user($data->sender);

                                // check for new messages 
                                if($data->receiver == $_SESSION['userid'] && $data->received == 0){
                                    $new_message = true;
                                }
                                if($data->receiver == $_SESSION['userid']){
                                    $DB->write("update messages set received = 1 where id = '$data->id' limit 1");
                                }

                                if($data->receiver == $_SESSION['userid'] && $data->received == 1 && $seen){
                                    $DB->write("update messages set seen = 1 where id = '$data->id' limit 1");
                                }

                                if($_SESSION['userid'] == $data->sender){
                                    $messages .= message_right($data,$myuser);
                                }else{
                                    $messages .= message_left($data,$myuser);
                                }
                            }
                        }
                        $messages .= "</div>";

                    if(!$refresh){
                        $messages .= message_controls();
                    }
                   
        $messages .= "</div>";

        $info->user = $mydata;
        $info->messages = $messages;
        $info->new_message = $new_message;

        $info->data_type = "chats";
        if($refresh){
            $info->data_type = "chats_refresh";
        }
        echo json_encode($info);
    
    }
    else{
        // read from database 
		$a['userid'] = $_SESSION['userid'];
 
		$sql = "select * from messages where (sender = :userid || receiver = :userid) group by msgid order by id desc limit 10";
		$result2 = $DB->read($sql,$a);

		$mydata = "Previews Chats:<br>";

		if(is_array($result2)){
 
			$result2 = array_reverse($result2);

				foreach ($result2 as $data) {
					# code...
					$other_user = $data->sender;
					if($data->sender == $_SESSION['userid'])
					{
						$other_user = $data->receiver;
					}

					$myuser = $DB->get_user($other_user);

					$image = ($myuser->gender == "Male") ? "ui/images/male.jpg" : "ui/images/female.jpg";
	  				if(file_exists($myuser->image)){
	  					$image = $myuser->image;
	  				}
                    
                    $cipher_algo = "AES-128-CTR"; //The cipher method, in our case, AES 
                    $iv_length = openssl_cipher_iv_length($cipher_algo); //The length of the initialization vector
                    $option = 0; // Bitwise disjunction of flags
                    $decrypt_iv = '8746376827619797'; // Initialization vector, non-null
                    $decrypt_key = "1234567890trangtuantruongvu@@##^$!"; // The encryption key
                    // Use openssl_decrypt() to decrypt the string
                    $decrypted_string = openssl_decrypt ($data->message, $cipher_algo,
                            $decrypt_key, $option, $decrypt_iv);
              

 						$mydata .= "
 							<div id='active_contact' userid='$myuser->userid' onclick='start_chat(event)' style='cursor:pointer'>
								<img src='$image'>
								$myuser->username<br>
								<span style='font-size:11px;'>'$decrypted_string'</span>
							</div>";
			}
		}

		$info->user = $mydata;
		$info->messages = "";
 		$info->data_type = "chats";
 
		echo json_encode($info);
	}


?>
