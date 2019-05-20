#include <reg52.h>
#include <MacroAndConst.h>

uchar Receive;
uchar Receive_table[30]; //接收 WiFi 模块透传的数据

void Delay_Ms(uint ms)
{
    uint i, j;
    for (i = ms; i > 0; i--)
        for (j = 110; j > 0; j--)
            ;
}

void Delay_Us(uchar us)
{
    while (us--)
        ;
}

void Uart_Init()
{
    SCON = 0X50; //8位异步收发，允许串行接收
    TH2 = 0XFF;
    TL2 = 0XFD; //定时器 2 装初值
    RCAP2H = 0XFF;
    RCAP2L = 0XFD; //再载值
    TCLK = 1;
    RCLK = 1;
    C_T2 = 0;
    EXEN2 = 0;
    TR2 = 1;
    ES = 1;
    EA = 1;
}

void Uart_Send_Char(uchar dat)
{
    ES = 0;
    TI = 0;
    SBUF = dat;
    while (!TI)
        ;
    TI = 0;
    ES = 1;
}

void Uart_Send_String(uchar *string)
{
    while (*string)
    {
        Uart_Send_Char(*string++);
        Delay_Us(5);
    }
    Delay_Ms(1000);
}

void ESP8266_Send(uchar *puf)
{
    Uart_Send_String("AT+CIPSEND=0,11\r\n");
    Uart_Send_String(puf);
}

void ESP8266_Init()
{
    Uart_Send_String("AT+CIPMUX=1\r\n");
    Uart_Send_String("AT+CIPSERVER=1,8080\r\n");
}

void Init()
{
    P1 = 0X00;
    Delay_Ms(5000);
    P1 = 0XFF;
    Uart_Init();
    ESP8266_Init();
}

void main()
{
    Init();

    while (1)
    {
        if ((Receive_table[0] == '+') && (Receive_table[1] == 'I') && (Receive_table[2] == 'P')) //MCU接收到的数据为+IPD时进入判断控制0\1来使小灯亮与灭
        {
            if ((Receive_table[3] == 'D') && (Receive_table[6] == ','))
            {
                EA = 0; //关闭总中断，防止数据重叠
                switch (Receive_table[9])
                {
                case '0':
                    P1 = 0XFE;
                    ESP8266_Send("LED0 OPEN\r\n");
                    break;
                case '1':
                    P1 = 0XFD;
                    ESP8266_Send("LED1 OPEN\r\n");
                    break;
                case '2':
                    P1 = 0XFB;
                    ESP8266_Send("LED2 OPEN\r\n");
                    break;
                case '3':
                    P1 = 0XF7;
                    ESP8266_Send("LED3 OPEN\r\n");
                    break;
                default:
                    P1 = 0XFE; //因为我用的定时器2,所以这里要令 P1.0 口为 0
                }
                Receive_table[9] = 'f'; //随便赋值
                EA = 1;
            }
        }
    }
}

void Uart_Interrupt() interrupt 5
{
    static uchar i = 0;
    if (RI)
    {
        ES = 0;
        Receive = SBUF;
        Receive_table[i++] = Receive;
        if ((Receive_table[i - 1] == '\n') || (i == 29)) //数组接收完毕或者将满时将数组清零
        {
            i = 0;
        }
        RI = 0;
        ES = 1;
    }
}