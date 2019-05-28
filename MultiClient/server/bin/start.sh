#!/bin/sh

`pwd`/redis-server redis.conf
 echo "start fake node client , just for test"
 sleep 3
 python  `pwd`/../mytest/fakeClient.py&

