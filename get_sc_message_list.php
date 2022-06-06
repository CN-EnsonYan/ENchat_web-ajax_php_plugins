<?php
//本文件负责数据库查询 当前ecw_id 聊天记录
include('../common/header.php');
$ecw_id=$_SESSION['enc_ecw_id'];


$query = @mysql_query("SELECT * FROM en_chatweb_single_chatroom WHERE EXISTS (SELECT 1 FROM en_chatweb_single_chatroom where ecw_id_from='$ecw_id' or ecw_id_to='$ecw_id' GROUP BY ecw_chat_id HAVING MAX(id) = en_chatweb_single_chatroom.id)")or die; //查询

$i=0;
while ($row = mysql_fetch_assoc($query))    //遍历表中的数据，并形成数组
  {
      $db_ecw_id_from=$row['ecw_id_from'];
      $db_ecw_id_to=$row['ecw_id_to'];

      if($ecw_id=="$db_ecw_id_from"){//如果发送者是本人 则用接收者ID获取对方头像以及昵称
          $query2 = @mysql_query("SELECT * FROM en_chatweb_user_contacts where ecw_id='$ecw_id' and friend_ecw_id='$db_ecw_id_to'")or die; //查询
          while ($row2 = mysql_fetch_array($query2)){
          $db_friend_avatar_url=$row2['avatar_url'];
          $db_op_alias=$row2['op_alias'];
          $op_ecw_id=$db_ecw_id_to;
          }
      } else if ($ecw_id=="$db_ecw_id_to"){//如果接收者是本人 则用发送者ID获取对方头像以及昵称
          $query2 = @mysql_query("SELECT * FROM en_chatweb_user_contacts where ecw_id='$ecw_id' and friend_ecw_id='$db_ecw_id_from'")or die; //查询
          while ($row2 = mysql_fetch_array($query2)){
          $db_friend_avatar_url=$row2['avatar_url'];
          $db_op_alias=$row2['op_alias'];
          $op_ecw_id=$db_ecw_id_from;
          }
      } else {die;}
      $row['op_ecw_id']=$op_ecw_id;
      $row['op_alias']=$db_op_alias;
      $row['op_avatar']=$db_friend_avatar_url;
      
      $snd_time_timestamp=$row['snd_time'];
      $h_snd_time = date("Y-m-d H:i:s", $snd_time_timestamp);
      
      $row['h_snd_time'] = $h_snd_time;
      
      //add the row to the $chat array at specific index of $i
      $get[$i] = $row;
      $i += 1;
  }

$encode = json_encode($get);
echo "$encode";
mysql_close();
exit;
?>