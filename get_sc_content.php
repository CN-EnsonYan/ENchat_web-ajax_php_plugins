<?php
//本文件负责数据库查询 当前ecw_id 好友
include('../common/header.php');
$ecw_id=$_SESSION['enc_ecw_id'];
$scid=$_GET['scid'];
$query = @mysql_query("select * from en_chatweb_single_chatroom where ecw_chat_id='$scid' ORDER BY snd_time")or die; //查询

$i=0;
while ($row = mysql_fetch_assoc($query))    //遍历表中的数据，并形成数组
  {


      if($ecw_id==$row['ecw_id_from']){
          //该条消息是当前用户发的
          $msg_right_side="yes";
          
      }else{
          //该条消息不是当前用户发的
          $msg_right_side="no";
      }
      //写入JSON
      $row['msg_right_side'] = $msg_right_side;
      
      $snd_time_timestamp=$row['snd_time'];
      $h_snd_time = date("Y-m-d H:i:s", $snd_time_timestamp);
      
      $row['h_snd_time'] = $h_snd_time;
      
      
      //print_r($row);exit;
      //add the row to the $chat array at specific index of $i
      $get[$i] = $row;
      $i += 1;
  }


$encode = json_encode($get);
echo "$encode";
mysql_close();
exit;
?>