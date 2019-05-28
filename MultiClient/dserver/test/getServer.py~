import time
from socket import *  
print 'begin'
HOST='127.0.0.1'  
PORT=6379  
BUFSIZ=10240 
ADDR=(HOST,PORT)
 
tcpCliSock=socket(AF_INET,SOCK_STREAM)  
tcpCliSock.connect(ADDR)  

# clear state
tcpCliSock.send('ZREM msgservers 127.0.0.1:6000\r\n') 
tcpCliSock.send('ZREM msgservers 127.0.0.1:6001\r\n') 
tcpCliSock.send('ZREM msgservers 127.0.0.1:6002\r\n') 

for i in range(1, 5):
    tcpCliSock.send('ZINCRBY msgservers 1 127.0.0.1:6000\r\n') 

for i in range(1, 3):
    tcpCliSock.send('ZINCRBY msgservers 1 127.0.0.1:6001\r\n') 

for i in range(1, 8):
    tcpCliSock.send('ZINCRBY msgservers 1 127.0.0.1:6002\r\n') 

data=tcpCliSock.recv(BUFSIZ) 
#tcpCliSock.send('ZREVRANGE msgservers 0  0\r\n') 
tcpCliSock.send('ZRANGE msgservers 0  0\r\n')

data=tcpCliSock.recv(BUFSIZ) 
print data
tcpCliSock.close()  

