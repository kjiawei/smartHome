#include <Ethernet.h>
#include <SPI.h>

byte mac[] = {  0x9c,0xd2,0x1e,0xb3,0x95,0x96 };
byte ip[] = { 192, 168, 1, 4};
byte server[] = { 115,29,235,211 }; 
int port=6379;
EthernetClient client;
char * userid="2745dd5ef44dd3f7a9a19e6d1491f18f";
int led = 9;
//  !!!!! This number will overflow (go back to zero), after approximately 50 days. 
unsigned long previoustime;
unsigned long currenttime;

#define	CFG_MAXARGS		8	       /* max number of command args	*/
char * argv[CFG_MAXARGS + 1];		/* NULL terminated	*/
int argc=0;

char buf[256] = { 0x00 }; 
int  bufIndex=0;

int make_argv(char *s, int argvsz, char *argv[])
{
	int argc = 0;
	/* split into argv */
	while (argc < argvsz - 1) {
		/* skip any white space */
		while ((*s == ' ') || (*s == '\t'))
			++s;
		if (*s == '\0') 	/* end of s, no more args	*/
			break;
		argv[argc++] = s;	/* begin of argument string	*/
		/* find end of string */
		while (*s && (*s != ' ') && (*s != '\t'))
			++s;
		if (*s == '\0')		/* end of s, no more args	*/
			break;
		*s++ = '\0';		/* terminate current arg	 */
	}
	argv[argc] = NULL;
	return argc;
}

char  tempBuf [256] ="chat login yongming yongming";
void processData()
{
     argc=make_argv(buf, sizeof(argv)/sizeof(argv[0]), argv);
     Serial.println("argc is :");
     Serial.println(argc);
     if(argc<4)
     {
        
       // return;
     }   
    for (int i=0;i<argc;i++)
    {
        Serial.println(argv[i]);
    }
    if(strstr(argv[argc-3],"open"))
    {
       Serial.println("open");
       pinMode(led, OUTPUT); 
        digitalWrite(led, HIGH);
    } 
    if(strstr(argv[argc-3],"close"))
    {
       Serial.println("close");
       pinMode(led, OUTPUT); 
        digitalWrite(led, LOW);
    }

}
void readline(char c)
{
    if (c!='\r' && c!='\n')
    {
          //Serial.println("is not r or n");
          buf[bufIndex]=c;
          bufIndex=bufIndex+1;
    }
    else
    {
        //Serial.println("is r or n");
        buf[bufIndex]=0x00;
        if(bufIndex>1)
        {
            //Serial.println("enter processData");
            processData();
        }
        bufIndex=0;
        // and memset
    }
}

void setup()
{
  Serial.begin(9600);
  pinMode(led, OUTPUT); 
  delay(1000);
  Ethernet.begin(mac);
  Serial.println("Obtaining local IP");
  IPAddress myIPAddress = Ethernet.localIP(); 
  Serial.println(myIPAddress);
  Serial.println(" connecting  ......");
  if (client.connect(server, port))
  {
    Serial.println("connected");
    client.println("node login 2745dd5ef44dd3f7a9a19e6d1491f18f light r r \r\n");
  } else {
    if (client.connect(server, port))
    {
          digitalWrite(led, HIGH); 
          Serial.println("connected");
          client.println("node login 2745dd5ef44dd3f7a9a19e6d1491f18f light r r\r\n");
    }
    else
    {
          Serial.println("Connection failed");
    }
    
  }
  previoustime = millis();
}

void sendMessage()
{
     currenttime= millis();
     if(currenttime-previoustime>30000)
     {
        //Serial.println(previoustime);
        //Serial.println(currenttime);
        previoustime = millis();
        client.println("node say  family  name=light,value=open r r\r\n");
        client.println("node heartbeat r r r r\r\n");

     } 
}

void loop()
{
  sendMessage();

  while (client.available()) {
    char c = client.read();
    readline(c);
    Serial.print(c);
  }
  if (!client.connected()) {
    Serial.println();
    Serial.println("disconnecting.");
    client.stop();
    for(;;)
      ;
  }
}
