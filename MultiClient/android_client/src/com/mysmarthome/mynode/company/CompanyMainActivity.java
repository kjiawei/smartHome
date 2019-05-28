package com.mysmarthome.mynode.company;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;
import java.util.Set;
import java.util.Map.Entry;

import com.mysmarthome.mynode.R;
import com.mysmarthome.mynode.R.layout;
import com.mysmarthome.mynode.R.menu;
import com.mysmarthome.mynode.AllNode;
import com.mysmarthome.mynode.MyParse;
import com.mysmarthome.mynode.chat.ChatActivity;
import com.mysmarthome.mynode.node.NodetemperatureActivity;
import com.mysmarthome.mynode.node.SpecialNodeLight;

import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.GridView;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.Spinner;
import android.widget.AdapterView.OnItemClickListener;

public class CompanyMainActivity extends Activity {

	private String TAG="CompanyMainActivity";
	
	private ListView  listViewInformation;
	private ListView  listViewMore;
	private ListView  listViewDevice;
	
	private GridView gridView;   
	private String[] menufrom = { "ItemImage","ItemImageSelect","ItemTitle",  }; 
	private int[] menuto =  {R.id.company_main_item_image,R.id.company_main_item_select,R.id.company_main_item_title}; 
	
    private static ArrayList<HashMap<String, Object>> menuListItem;
    private SimpleAdapter menulistItemAdapter;
    
    
	public  static  ArrayList<String> informationList = new ArrayList<String>();
	static final String[] informationArray = new String[] { 
		                                                    "公司代言人",
		                                                    "公司官网", 
		                                                    "公司商场" }; 
	static final String[] informationArrayDetail = new String[] { 
		                                                          "我为自己代言，节省广告费",
		                                                          "http://www.******.com", 
		                                                          "http://www.******.com" }; 
	
	static final String[] moreArray = new String[] { "添加设备",
		                                             "帮助" ,
		                                             "升级"}; 
	static final String[] moreArrayDetail = new String[] { "", "",""}; 
	
	static final String[] deviceArray = new String[] { "灯", 
		                                               "电视" ,
		                                               "空调"}; 
	
	static final String[] deviceArrayDetail = new String[] { "", "",""}; 
	
	public  static  ArrayList<String> moreList = new ArrayList<String>();
	
	private SimpleAdapter listItemAdapter;
	private static ArrayList<HashMap<String, Object>> listItem;
	private static ArrayList<HashMap<String, Object>> listItemMore;
	
	private String[] from = { "ItemTitle", "ItemText" }; 
	private int[] to =  {R.id.title_company_information,R.id.text_company_information}; 
		
    static
    {
    	informationList.add("公司官网");
    	informationList.add("公司商场");

    	moreList.add("添加设备");
    	moreList.add("帮助向导");
    	moreList.add("更新");	
    	
    }
    
	private static  int MENU_DEVICE=0;
	private static  int MENU_INFOMATION=1;
	private static  int MENU_MORE=2;
	private static  int MenuSelectIndex=MENU_DEVICE;
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_company_main);
		
		gridView = (GridView)this.findViewById(R.id.gridView_company_main);
		
		listViewMore = (ListView) findViewById(R.id.listView_company_more);
		listViewDevice=(ListView) findViewById(R.id.listView_company_device);
		listViewInformation = (ListView) findViewById(R.id.listView_company_information);
		
		gridView.setOnItemClickListener(new OnItemClickListener() {  
			   
            @Override  
            public void onItemClick(AdapterView<?> arg0, View arg1, int arg2,  
                    long arg3) { 

           	    int index=arg2;
              	myMenuInit(index);

            }  
        }); 
       
		myMenuInit(MenuSelectIndex);
		myDeviceInit();
		myInformationInit();
		myMoreInit();
		setTitle("  某某******公司   "); 

	}
	public void  myUpdate(int index)
	{
		listViewMore.setVisibility(View.INVISIBLE);
		listViewInformation.setVisibility(View.INVISIBLE);
		listViewDevice.setVisibility(View.INVISIBLE);
        if(index==MENU_DEVICE)
        {
        	listViewDevice.setVisibility(View.VISIBLE);
        }
        if(index==MENU_INFOMATION)
        {
        	listViewInformation.setVisibility(View.VISIBLE);
        }
        if(index==MENU_MORE)
        {
        	listViewMore.setVisibility(View.VISIBLE);
        }
	}
	public void  myMenuInit(int index)
	{		 
		String[] menuItem = new String[] { "设备", "资讯","更多" }; 
		int[] menuItemImage = new int[] { R.drawable.company_device, R.drawable.company_information,R.drawable.company_more }; 
		//public static final int node_air=0x7f020014;
        //生成动态数组，加入数据  
		menuListItem = new ArrayList<HashMap<String, Object>>();  
		menuListItem.clear();
         
		menulistItemAdapter = new SimpleAdapter(this, menuListItem,  
                R.layout.activity_company_main_item, menufrom, menuto);  
        gridView.setAdapter(menulistItemAdapter);  
        
    	HashMap<String, Object> map = new HashMap<String, Object>(); 
    	for(int i=0;i<menuItem.length;i++)
    	{
    		map = new HashMap<String, Object>(); 
    		map.put("ItemTitle", menuItem[i]); 
            map.put("ItemImage", menuItemImage[i]);//图像资源的ID  
            if(i==index)
            {
            	map.put("ItemImageSelect", R.drawable.company_menu_select);//图像资源的ID  
            }
            menuListItem.add(map); 
            
    	}
        menulistItemAdapter.notifyDataSetChanged();   
        myUpdate(index);
         //添加并且显示  
	}

	public void  myDeviceInit()
	{
		int i=0;
		
        listItem = new ArrayList<HashMap<String, Object>>();  
        listItem.clear();
 	    listItemAdapter = new SimpleAdapter(this, listItem,  
                R.layout.activity_company_information_item, from, to);  
        
 	    HashMap<String, Object> map;
 	    for(i=0;i<deviceArray.length;i++)
 	    {
 	    	map = new HashMap<String, Object>(); 
 	        map.put("ItemTitle", deviceArray[i]);  
 	        map.put("ItemText",deviceArrayDetail[i]);  
 	        listItem.add(map); 
 	    }		    
 	   listViewDevice.setAdapter(listItemAdapter);  
		           
	}
	
	public void  myInformationInit()
	{
		int i=0;
		
        listItem = new ArrayList<HashMap<String, Object>>();  
        listItem.clear();
 	    listItemAdapter = new SimpleAdapter(this, listItem,  
                R.layout.activity_company_information_item, from, to);  
        
 	   HashMap<String, Object> map;
 	    for(i=0;i<informationArray.length;i++)
 	    {
 	    	map = new HashMap<String, Object>(); 
 	        map.put("ItemTitle", informationArray[i]);  
 	        map.put("ItemText",informationArrayDetail[i]);  
 	        listItem.add(map); 
 	    }		    
 	   listViewInformation.setAdapter(listItemAdapter);  
		           
	}

	public void  myMoreInit()
	{
		int i=0;
		
        listItem = new ArrayList<HashMap<String, Object>>();  
        listItem.clear();
 	    listItemAdapter = new SimpleAdapter(this, listItem,  
                R.layout.activity_company_information_item, from, to);  
        
 	   HashMap<String, Object> map;
 	    for(i=0;i<moreArray.length;i++)
 	    {
 	    	map = new HashMap<String, Object>(); 
 	        map.put("ItemTitle", moreArray[i]);  
 	        map.put("ItemText",moreArrayDetail[i]);  
 	        listItem.add(map); 
 	    }		    
 	   listViewMore.setAdapter(listItemAdapter);             
	}
}
