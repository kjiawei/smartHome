#!/bin/sh  

PID=`sudo ps -A | grep redis-server |awk '{print $1}'`  
echo $PID
sudo kill -9  $PID 

sudo  ./redis-server  --loglevel verbose&
