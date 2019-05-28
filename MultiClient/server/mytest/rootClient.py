import time
from socket import *  


print 'begin'
HOST='127.0.0.1'  
PORT=6379  
BUFSIZ=4096 
ADDR=(HOST,PORT)
print 'connet ...' 
rootSock=socket(AF_INET,SOCK_STREAM)  
rootSock.connect(ADDR)  

rootSock.send('chat login root root\r\n') 
data=rootSock.recv(BUFSIZ) 
print data

rootSock.send('chat debug d d\r\n') 
data=rootSock.recv(BUFSIZ) 
print data
i=0
while(1):
   i=i+1;
rootSock.close()

