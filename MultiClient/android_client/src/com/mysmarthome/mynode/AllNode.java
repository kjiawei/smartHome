package com.mysmarthome.mynode;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;
import java.util.Set;
import java.util.Map.Entry;

import com.mysmarthome.mynode.R;
import com.mysmarthome.mynode.chat.ChatActivity;
import com.mysmarthome.mynode.node.NodetemperatureActivity;
import com.mysmarthome.mynode.node.SpecialNodeLight;

import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.provider.ContactsContract;
import android.app.Activity;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Adapter;
import android.widget.ArrayAdapter;
import android.widget.GridView;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.SimpleAdapter;
import android.widget.Spinner;
import android.widget.TextView;
import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.BaseAdapter;
import android.widget.ListAdapter;
import android.widget.Toast;

public class AllNode extends Activity {
	private GridView gridView;   
	private String[] from = { "ItemImage","ItemTitle", "ItemText" }; 
	private int[] to =  {R.id.image_allnode,R.id.title_allnode,R.id.text_allnode }; 
	
	public  static  HashMap<String, Object> pictureList = new HashMap<String, Object>();
	
	
	
    private static ArrayList<HashMap<String, Object>> listItem;
    private SimpleAdapter listItemAdapter;
	private Spinner mModeSpinner;
	private String TAG="AllNode";

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_all_node);
		gridView = (GridView)this.findViewById(R.id.gridView_allnode);

		
		mModeSpinner = (Spinner) findViewById(R.id.spineer_mode_allnode);
		ArrayAdapter<String> adapter;
        adapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        adapter.add("图表模式");
        adapter.add("聊天模式");
        mModeSpinner.setAdapter(adapter);
        mModeSpinner.setPrompt("选择模式(默认为图表模式)");
        //int phoneType = mContactPhoneTypes.get(
        //        mContactPhoneTypeSpinner.getSelectedItemPosition());
        
		//添加点击  
		gridView.setOnItemClickListener(new OnItemClickListener() {  
		   
		             @Override  
		             public void onItemClick(AdapterView<?> arg0, View arg1, int arg2,  
		                     long arg3) { 
		            	Log.e(TAG,"mode is :"+mModeSpinner.getSelectedItemPosition());
		            	int nodeMode=mModeSpinner.getSelectedItemPosition();
		            	
		            	HashMap<String,Object> map = (HashMap<String,Object>)arg0.getItemAtPosition(arg2);
		                setTitle("选择"+arg2+"个"+map.get("ItemTitle")); 
		                Intent intent=null;
		            	//  0 means chart mode (show datas)
		                String name = (String)map.get("ItemTitle");
		            	if(nodeMode==0)
		            	{
			                intent = new Intent(AllNode.this,NodetemperatureActivity.class); 
				            intent.putExtra("name",name);
		            	}
		            	//  1 means chat mode (control the node)
		            	if(nodeMode==1)
		            	{
			                intent = new Intent(AllNode.this,ChatActivity.class); 
				            intent.putExtra("name",name);
				            intent.putExtra("mode", "node");
		            	}
		            	if(name.equalsIgnoreCase("light"))
		            	{
		            		
			                intent = new Intent(AllNode.this,SpecialNodeLight.class); 
				            intent.putExtra("name",(String)map.get("ItemTitle"));
				            intent.putExtra("mode", "node");
		            	}
			            startActivity(intent); 
		             }  
		         }); 
		myinit();
		
	}
	 	
	public void  myinit()
	{		 
        //生成动态数组，加入数据  
        listItem = new ArrayList<HashMap<String, Object>>();  
        listItem.clear();
         
 	    listItemAdapter = new SimpleAdapter(this, listItem,  
                R.layout.activity_all_node_item, from, to);  
        gridView.setAdapter(listItemAdapter);  
        
        pictureList.put("light", R.drawable.node_light);
        pictureList.put("temperature", R.drawable.node_temperature);
        pictureList.put("air", R.drawable.node_air);
        pictureList.put("tv", R.drawable.node_tv);
        pictureList.put("noise", R.drawable.node_noise);
        pictureList.put("car", R.drawable.node_car);
        

         //添加并且显示  
	}
	public void  myupdate()
	{
		listItem.clear();
    	int i=0;
    	Set<String> username= MyParse.nodeList.keySet();
    	Iterator<Entry<String,Object>> it = MyParse.nodeList.entrySet().iterator();  
    	  while(it.hasNext()){  
    	   Map.Entry<String,Object> m = it.next();  
    	   String key =  m.getKey();
    	   HashMap<String, Object> value= (HashMap<String, Object>)m.getValue();
    	   HashMap<String, Object> map = new HashMap<String, Object>(); 
    	   if(pictureList.containsKey(value.get("name")))
    	   {
    		   map.put("ItemImage", pictureList.get(value.get("name")));//图像资源的ID
    	   }
    	   else
    	   {
    		   map.put("ItemImage", R.drawable.node_other);//图像资源的ID  
    	   }
    	   
           map.put("ItemTitle", value.get("name"));  
           map.put("ItemText","接收到 "+value.get("messagesize")+"条消息" 
           		+"   当前状态：" + value.get("line")+" line");  
           listItem.add(map); 
    	  }   
 
        listItemAdapter.notifyDataSetChanged();
        return;		
	}
    protected void onStart() {  
        // TODO Auto-generated method stub  
        super.onStart();  
        Log.e(TAG, "执行：onStart()"); 
        MyConfig.myClient.setHandle(mHandler);
        myupdate();
    }  
	private  Handler mHandler = new Handler() {  
        public void handleMessage (Message msg) {//此方法在ui线程运行  
            switch(msg.what) {  
            case MyConfig.MSG_USER_NODE_INFO_UPDATE: 
            case MyConfig.MSG_CHAT_UPDATE:
            	myupdate();
                break;  
           }  
         }  
     }; 
     
     
     
     
     
     
     
     
     
     
    /*
 	public List<Map<String, Object>> getList() {  
        List<Map<String, Object>> list = new ArrayList<Map<String, Object>>();  
        Map<String, Object> map = null;  
  
        String [] titles = new String[] { "电灯","温度", "空气环境", "电视", "噪声", "汽车" };  
        Integer[] images = { R.drawable.node_light,R.drawable.node_temperature, R.drawable.node_air,  
                R.drawable.node_tv, R.drawable.node_noise, R.drawable.node_car};  
  
        for (int i = 0; i < images.length; i++) {  
            map = new HashMap<String, Object>();  
            map.put("image", images[i]);  
            map.put("title", titles[i]);  
            list.add(map);  
        }  
        return list;  
    } 
    */


}
