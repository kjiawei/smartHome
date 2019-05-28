#include <stdio.h>
#include <string.h>

void main()
{
     char sbuf[128]="hellohellohellohello";
     char sbuftemp[128]="hellohellohellohello";
     int slen = 0;
     slen = snprintf(sbuftemp,sizeof(sbuftemp),"%s:%s","from","message");
     printf("slen is %d and sbuftemp is \"%s\"\r\n",slen,sbuftemp);
     slen = snprintf(sbuf,sizeof(sbuf),"$%d\r\n%s\r\n",slen,sbuftemp);
     printf("slen is %d and sbuf is %s\r\n",slen,sbuf);
}

