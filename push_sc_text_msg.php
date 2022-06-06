<?php
include('../common/header.php');
   $text_box_msg=safeStrings($_POST['text_box_msg']);
   $get_post_op_ecw_id=safeStrings($_POST['op_ecw_id']);
   $get_post_scid=safeStrings($_POST['scid']);
   $cur_time=time();

if(empty($text_box_msg)||empty($get_post_op_ecw_id)||empty($get_post_scid)){
    echo "<script>alert('Contact not found. / 未找到该好友 !');window.history.back(-1);</script>";
    exit;
}
   
//检测当前用户是否有其好友
$ckeck_friend_or_not = mysql_query("select id from en_chatweb_user_contacts where ecw_id='$ecw_id' and friend_ecw_id='$get_post_op_ecw_id' or ecw_id='$get_post_op_ecw_id' and friend_ecw_id='$ecw_id'");
		if (mysql_num_rows($ckeck_friend_or_not) < 1){
	            echo "<script>alert('Contact not found. / 未找到该好友 !');window.history.back(-1);</script>";
                exit;
	        }

echo "Illegal Parameters.";
  //echo "$text_box_msg <br>";


$enc_id_push_msg = mysql_query("insert into en_chatweb_single_chatroom(ecw_chat_id,ecw_id_from,ecw_id_to,snd_time,content,msg_type,seen_or_not,delete_or_not) values('$get_post_scid','$ecw_id','$get_post_op_ecw_id','$cur_time','$text_box_msg','text','no','no')");
while(mysql_query($enc_id_push_msg)){}

?>
