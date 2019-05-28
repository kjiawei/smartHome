#!/bin/sh  

echo "kill redis-server"
PID=`sudo ps -A | grep redis-server |awk '{print $1}'`  
echo pid is $PID
sudo kill -9  $PID 

