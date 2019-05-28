#!/bin/sh  
echo "run mysql.php"
php ./mysql.php 

echo "kill redis-server"
PID=`sudo ps -A | grep redis-server |awk '{print $1}'`  
echo pid is $PID
sudo kill -9  $PID 

echo "run redis-server"
sudo  ../src/redis-server  --loglevel verbose&
# /dev/null 2>&1 
sleep 3
python ./fakeClient.py&

echo "game over"
