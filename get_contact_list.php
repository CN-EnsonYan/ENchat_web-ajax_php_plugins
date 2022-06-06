<?php
//本文件负责数据库查询 当前ecw_id 好友
include('../common/header.php');
$ecw_id=$_SESSION['enc_ecw_id'];
$query = @mysql_query("select * from en_chatweb_user_contacts where ecw_id='$ecw_id' and black_listed_or_not='no' and accepted_or_not='accepted'")or die; //查询

$i=0;
while ($row = mysql_fetch_array($query))    //遍历表中的数据，并形成数组
  {
      //add the row to the $chat array at specific index of $i
      $get[$i] = $row;
      $i += 1;
  }

$encode = json_encode($get);
echo "$encode";
mysql_close();
exit;
?>