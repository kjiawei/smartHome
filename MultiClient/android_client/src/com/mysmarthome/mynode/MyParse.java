package com.mysmarthome.mynode;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;
import java.util.Map.Entry;

import android.os.Handler;
import android.util.Log;

public class MyParse  {
	Handler m_handle;
	
	public static int  TYPE_USER=0;
	public static int  TYPE_NODE=1;
	
	public  static  ArrayList<String> protocolList = new ArrayList<String>();
	public  static  HashMap<String, Object> userList = new HashMap<String, Object>();
	public  static  HashMap<String, Object> nodeList = new HashMap<String, Object>();
	//public  static  ArrayList<HashMap<String, Object>> userList = new ArrayList<HashMap<String, Object>>();

	public void loginparse()
	{
        if(protocolList.get(0).startsWith("ok"))
        {
        	m_handle.obtainMessage(MyConfig.MSG_LOGIN_SUCCESS,"ok").sendToTarget();
        	m_handle.obtainMessage(MyConfig.MSG_LOGIN_USERID,protocolList.get(1)).sendToTarget();
            return;
        }
        if(protocolList.get(0).startsWith("fail"))
        {
        	m_handle.obtainMessage(MyConfig.MSG_LOGIN_FAILURE,protocolList.get(1)).sendToTarget();
        	return;
        }
	}
	public void insertNewUserOrNode(HashMap<String, Object> mylist,String parentname,String name,String message)
	{
		HashMap<String, Object> map=null;
	    map = new HashMap<String, Object>();
	
		map.put("parentname", parentname);
        map.put("name", name);
        map.put("messagesize","0");
        map.put("messages",new ArrayList<String>());
        map.put("line",message);
        mylist.put(name, map);
        return;
		
	}
	public void onlyUpdateNodeState(HashMap<String, Object> mylist,String parentname,String name ,String message)
	{
		if(message.equalsIgnoreCase("on"))
		{
			return;
		}
    	Iterator<Entry<String,Object>> it = mylist.entrySet().iterator();  
    	while(it.hasNext()){  
    	   Map.Entry<String,Object> m = it.next();  
    	   String key =  m.getKey();
    	   HashMap<String, Object> item= (HashMap<String, Object>)m.getValue();
    	   
    	   if(parentname.equalsIgnoreCase((String)item.get("parentname")))
    	   {
    		   userOrNodeinfoparse(mylist,parentname,(String)item.get("name") ,message);
    	   }
    	  
    	  }   		
    	
	}
	public void userOrNodeinfoparse(HashMap<String, Object> mylist,String parentname,String name ,String message)
	{

		HashMap<String, Object> map=null;
		
		if(mylist.containsKey(name))
		{
			map=(HashMap<String, Object>)mylist.get(name);
			map.put("line",message);
			m_handle.obtainMessage(MyConfig.MSG_USER_NODE_INFO_UPDATE,mylist).sendToTarget();
			return;
		}
		insertNewUserOrNode(mylist, parentname, name,message);
		m_handle.obtainMessage(MyConfig.MSG_USER_NODE_INFO_UPDATE,mylist).sendToTarget();
		return;
	}
	// chat ok yongming hello
	// node ok light  name=light,state=close,brightness:0;name=tv,state=true,channel=cctv5
	// node say temperature  name=temperature,value=28,measurement=摄氏度
	public void chatparse(HashMap<String, Object> mylist,String parentname,String name ,String message) {
		try {
	
		    userOrNodeinfoparse(mylist,parentname,name,"on"); 
		
			
			HashMap<String, Object> map = null;
			map = (HashMap<String, Object>) mylist.get(name);

			String messagesize = (String) map.get("messagesize");
			int tempmessagesize = 0;
			tempmessagesize = Integer.parseInt(messagesize) + 1;
			map.put("messagesize", String.format("%d", tempmessagesize));
			ArrayList<String> messageList = (ArrayList<String>) map
					.get("messages");
			messageList.add(message);

			m_handle.obtainMessage(MyConfig.MSG_CHAT_UPDATE,
					name + ":" + message).sendToTarget();

		} catch (Exception e) {
			Log.e("Myparse chatparse", e.toString());
		}
		return;
	}

	public int  parse(Handler handle, String line) {
		m_handle = handle;
		String parentname = null;
		String name = null;
		String messages =null;
		String message=null;
        
		//Log.e("parse",line);
		// node ok light  name=light,state=close,brightness:0;name=tv,state=true,channel=cctv5
		//node ok temperature name=temperature,value=24,measurement=C
		//node ok light name=light,state=open,brightness:255;name=tv,state=close,channel=cctv5
		//line="node ok light name=light,state=open,brightness:255;name=tv,state=close,channel=cctv5";
		try {
			String strArray[] = line.split("\\s+");
			protocolList.clear();
			for(int i=1 ; i< strArray.length;i++)
			{
				protocolList.add(strArray[i].trim());

			}
			if(protocolList.size()==0)
			{
				return 0;
			}
			if (line.startsWith("login")) {
				loginparse();

				return 0;
			}
			name = (String) protocolList.get(1);
			parentname=name;
			messages = (String) protocolList.get(2);
			message=messages;
			
			if (line.startsWith("userinfo")) {
				userOrNodeinfoparse(userList,parentname,name,message);
				return 0;
			}
			if (line.startsWith("nodeinfo")) {
				onlyUpdateNodeState(nodeList,parentname,name,message);
				return 0;
			}
			if (line.startsWith("user")) {

				chatparse(userList,parentname,name,message);
				return 0;
			}
								
			String tpyeArray[] = messages.split(";");
			
			for(int i=0 ; i< tpyeArray.length;i++)
			{
				//Log.e("parse",i+" is "+tpyeArray[i].trim());
				message=tpyeArray[i].trim();
				
				if (line.startsWith("node")) {
					name=MyParseCommon.getValueFromMessageByName(message,"name");
					message=MyParseCommon.getRealMessageFromMessage(message);
					
					//Log.e("parse","parent is "+parentname+" name is "+name+" message is "+message);
					chatparse(nodeList,parentname,name,message);
				}
			}
			return 0;
			
		} catch (Exception e) {
			Log.e("Myparse parse", "parse"+e.toString());
			return 1;
		}
	}
	
}
