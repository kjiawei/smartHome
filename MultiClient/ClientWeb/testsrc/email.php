<?php
//  auther :  yongming.li
$to = "ruifeng.d@tcl.com";
$subject = " hello tu hao ";
$message = " tu hao " ;
$from = "ruifeng.d@tcl.com";
$headers = "From: $from";
mail($to,$subject,$message,$headers);
echo "Mail Sent.";
echo "\r\n";

?>
