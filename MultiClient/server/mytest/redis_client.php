<?php 
// 建立客户端的socet连接 
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); 
$connection = socket_connect($socket, '127.0.0.1', 6379); //连接服务器端socket 
socket_write($socket, "chat login root root\r\n");
//服务器端收到信息后，给于的回应信息 
//$buffer = socket_read($socket, 1024, PHP_NORMAL_READ) ;
$userid='45454545454555454545454';
$username="xiaodada";
$sendbuf = "chat adduser " . $userid . "  " . $username . "\r\n";
echo  "sendbuf is " . $sendbuf;
socket_write($socket, $sendbuf);
echo "receive data is :" . $buffer . "\n"; 
socket_close ($socket); 
?> 
