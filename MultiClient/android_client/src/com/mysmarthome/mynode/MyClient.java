package com.mysmarthome.mynode;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.io.PrintWriter;
import java.net.Socket;
import java.util.ArrayList;

import android.app.Service;
import android.content.Context;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Handler;
import android.os.IBinder;
import android.util.Log;

import com.mysmarthome.mynode.*;
import com.mysmarthome.mynode.setting.MySetting;

//public class MyClient implements Runnable  
public class MyClient  extends Service
{  
    private static final String TAG = "myclient";
    private  StringBuffer mStringBuffer =null;
    private  PrintWriter out=null;
    private  BufferedReader br=null;

	private  static Socket socket=null;
	private  static Handler m_handle;
	private  MySetting settings;
	public static  Context mainContext;
	public static  boolean isRunning = false;

	private  static MyParse loginParse = new MyParse();
	public  static ArrayList<String> sendCmd = new ArrayList<String>();
	
    public IBinder onBind(Intent intent)
    {
        return null;
    }
    
	public void start() 
	{
	  settings = new MySetting(mainContext);
      final int reconnectInterval = settings.getReconnectInterval()*1000;
      
      Log.e(TAG, "reconnectInterval is "+reconnectInterval); 
      isRunning=true;
	  while(true)
	  {
		  String msg;
		  try   
	 	  { 
				Log.e(TAG, " <<<<<<<<<<< big while  >>>>>>>>>>>");  
				m_handle.obtainMessage(MyConfig.MSG_NET_NEXT_LOOP,
							"OK").sendToTarget();
				mStringBuffer = new StringBuffer();
				socket = new Socket(MyConfig.SERVER_IP,MyConfig.SERVER_PORT);   
				out = new PrintWriter( new BufferedWriter( new OutputStreamWriter(socket.getOutputStream())),true); 
				br = new BufferedReader(new InputStreamReader(socket.getInputStream()));
				
				
	            while(true)
	            {
	            	 //Log.e(TAG, " <<<<<<<<<<< small while  >>>>>>>>>>>");  
	            	 for(int i=0;i<sendCmd.size();i++)
	            	 {
	            		 Log.e(TAG, "i is "+i+" cmd is "+sendCmd.get(i)); 
	            		 out.println((String)sendCmd.get(i));
	            	 }
	            	 sendCmd.clear();
	           	     msg=br.readLine();
	           	     // modified by yongming.li for nullpointexception
	           	     if(msg.length()<3)
	           	     {
	           	    	 break;
	           	     }
	           	     if(loginParse.parse(m_handle,msg)==1)
	           	     {
	           	    	 break;
	           	     }
	            }
					
	 	  }
	      catch (Exception e)   
	      {  
	            Log.e(TAG, e.toString());  
	      } 
		  try   
	 	  { 
			  Log.e(TAG, "reconnectInterval is "+reconnectInterval); 
		     Thread.sleep(reconnectInterval);
		     myClose();
			 //m_handle.obtainMessage(MyConfig.MSG_NET_RUNCMD_FAIL,
			//			"fail").sendToTarget();
	 	  }
	      catch (Exception e)   
	      {  
	            Log.e(TAG, e.toString());  
	      } 	  
	  }
    }
	
	public void parseMessage(String msg) {
		try {

			loginParse.parse(m_handle,msg);
		} catch (Exception e) {
			Log.e(TAG, e.toString());
		}
	}

	public void runCmd(String cmd) {
		try {
			if(out==null)
			{
				return;
			}
			out.println(cmd);
			return;
		} catch (Exception e) {
			Log.e(TAG, e.toString());
		}
		
		try {
			m_handle.obtainMessage(MyConfig.MSG_NET_RUNCMD_FAIL,
					"fail").sendToTarget();
		} catch (Exception e) {
			Log.e(TAG, e.toString());
		}
		

	}
	public void insertCmd(String cmd)
    {
		try {
			sendCmd.add(cmd);
		} catch (Exception e) {
			Log.e(TAG, e.toString());
		}
    }
	public void myClose()
	{
	   try   
	   { 
	        out.close();  
	        br.close();  
	        socket.close(); 
	        
	        out=null;
	        br=null;
	        socket=null;
	        
	        sendCmd.clear();
	   }
	   catch (Exception e)   
	   {  
	            Log.e(TAG, "myclose  : "+e.toString());  
	   }  
	}

	public void setHandle(Handler handle)
	{
	     m_handle = handle;
	     return;
	}
	
	public static String getCurrentNetStatus(Context context) {  
        
		String str="";
		if(isNetworkAvailable(context)==false)
		{
            str ="网络不可用，请检查设置";
            return str;
		}
		
		if(isWifi(context)==true)
		{
            str ="网络链接为WIFI，请尽情使用流量";
            return str;
		}
		else
		{
			str ="网络链接为2/3/4G，小心破产";
		}
		return str;
   }
	private static boolean isNetworkAvailable(Context context) {  
	         ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);  
	         if (cm == null) {  
	         } else {  
	             // 如果仅仅是用来判断网络连接　　　　　　  
	             // 则可以使用 cm.getActiveNetworkInfo().isAvailable();  
	             NetworkInfo[] info = cm.getAllNetworkInfo();  
	             if (info != null) {  
	                 for (int i = 0; i < info.length; i++) {  
	                     if (info[i].getState() == NetworkInfo.State.CONNECTED) {  
                            return true;  
	                     }  
	                 }  
	             }  
	         }  
	         return false;  
	}  
    private static boolean isWifi(Context context) {   
	            ConnectivityManager cm = (ConnectivityManager) context   
	                    .getSystemService(Context.CONNECTIVITY_SERVICE);   
	            NetworkInfo networkINfo = cm.getActiveNetworkInfo();   
	            if (networkINfo != null   
	                    && networkINfo.getType() == ConnectivityManager.TYPE_WIFI) {   
	                return true;   
	            }   
	            return false;   
	}

}  