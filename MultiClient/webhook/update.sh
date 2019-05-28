#!/bin/sh

SRCDIR=/var/www/My-smart-home
SERVDIR=$SRCDIR/server

echo "stop server"
cd $SERVDIR/bin
./stop.sh
echo "update server" 
cd $SRCDIR
git pull 2>&1
echo "build server"
cd $SERVDIR
make && make install
echo "start server"
cd $SERVDIR/bin
./start.sh
