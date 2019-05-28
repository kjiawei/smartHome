import time
from socket import *  
print 'begin'
HOST='127.0.0.1'  
PORT=6379  
BUFSIZ=1024  
ADDR=(HOST,PORT)
 
tcpCliSock=socket(AF_INET,SOCK_STREAM)  
tcpCliSock.connect(ADDR)  
print 'while' 
tcpCliSock.send('chat login test test\r\n') 
#data=tcpCliSock.recv(BUFSIZ) 
#print data
ii=20;

nodeclient =socket(AF_INET,SOCK_STREAM)  
nodeclient.connect(ADDR)  
nodeclient.send('node login 2745dd5ef44dd3f7a9a19e6d1491f18f temperature\r\n')

tvclient =socket(AF_INET,SOCK_STREAM)  
tvclient.connect(ADDR)  
tvclient.send('node login 2745dd5ef44dd3f7a9a19e6d1491f18f light\r\n')

while True:  
    ii=ii+1;
    tcpCliSock.send('chat say yongming %s\r\n'%ii) 
    if(ii==30):
        ii=20
    nodeclient.send('node say self name=temperature,value=%s,measurement=C\r\n'%ii) 

    if(ii==23):
        tvclient.send('node say self name=light,state=close,brightness:0;name=tv,state=open,channel=cctv5\r\n')
    if(ii==28):
        tvclient.send('node say self name=light,state=open,brightness:255;name=tv,state=close,channel=cctv5\r\n')

    print 'again'
    time.sleep(15) 

nodeclient.close()
tvclient.close()   
tcpCliSock.close()  

