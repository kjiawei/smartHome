

void timer0() interrupt 1
{                                
   TH0=(65536-50)/256;
   TL0=(65536-50)%256;
   PWMcntA++;        
   PWMcntB++;        
   PWMcntC++;        
   PWMcntD++;        
   if (PWMcntA>=230)
   {  PWMcntA=1；}
   if (PWMcntA<=cntPWMA)
   {   PWMa=1; }
   else
    {  PWMa=0; }
    
    //PWMb、PWMc、PWMd依此类推
} 

//bt
void service()
{
switch (BlueToothData)
{
case 'g':go_forward();
               delay(1);
               break;
case 'b':go_back(); 
               delay(1);
               break;
case 's':stop ();
               delay(1);
               break;
}
} 

//红外
void search()
{
unchar flag;
if((search_left==0)&&(search_right==0))
{flag='g';}
if((search_left==0)&&(search_right==1))
{flag='l';}

switch(flag)
  {
case 'g':go_forward();
                break;
case 'l':turn_left();
               break;

  }
}

//红外循迹
void infrared()
{
if(Lr1==0)
turn_right();
if(Lr2==0)
turn_back_right();
if(Rr1==0)
turn_left();
if(Rr2==0)
turn_back_left();
}  

//超声波
void distance ()
{
int t,i;
delay_us ();
Trig=1;
Trig=0;
TR1=1;
while (!Echo);while(Echo);
n=0;
TR1=0;t=256*TH1+TL1+65535*n;
if(s>0&&s<30) //如果距离30厘米，小车持续左转
TH1=TL1=0;s=t*0.01845; //距离为厘米 {
{turn_left();}
for(t=0;t<70;t++)for(i=0;i<10;i++)}else{stop();}
}

