package com.mysmarthome.mynode;

import java.util.HashMap;

import android.util.Log;

public class MyParseCommon {
	
	// input : name=light,state=close 
	// output: light
    public  static  String  getValueFromMessageByName(String message,String name)
    {
    	String itemArray[] = message.split(",+");
		
		for(int i=0 ; i< itemArray.length;i++)
		{
			//Log.e("parse",i+" is "+itemArray[i].trim());
			
			if (itemArray[i].startsWith(name)) {
				String valueArray[] = itemArray[i].split("=+");
				return valueArray[1].trim();
			}
		}
        return null;	
    }
    
    // input : name=light,state=close,brightness:0
    // output should be : state=close,brightness:0
    public  static  String  getRealMessageFromMessage(String message)
    {

    	return message.substring(message.indexOf(',')+1);
    }
    public  static  String  getParentNameByName(HashMap<String, Object> mylist,String name)
    {
    	HashMap<String, Object> map=null;
		if(mylist.containsKey(name))
		{
			map=(HashMap<String, Object>)mylist.get(name);
		    return (String) map.get("parentname");

		}
    	return null;
    }

}
