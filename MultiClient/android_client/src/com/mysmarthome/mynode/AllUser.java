package com.mysmarthome.mynode;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;
import java.util.Map.Entry;
import java.util.Set;

import com.mysmarthome.mynode.R;
import com.mysmarthome.mynode.chat.ChatActivity;

import net.neilgoodman.android.fragmenttabstutorial.activity.FragmentTabActivity;



import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.app.Activity;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.view.Window;
import android.view.View.OnClickListener;
import android.widget.*;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.AdapterView.OnItemSelectedListener;

//public class AllUser extends Activity {
public class AllUser extends	Activity   {

	private ListView  listview;
	private TextView  textview;

    private Thread mThread;
    private static ArrayList<HashMap<String, Object>> listItem;
    private SimpleAdapter listItemAdapter;

    private static final String TAG = AllUser.class.getSimpleName();
    private static final String ACTION_ALLUSER_UPDATE =
            "com.example.mynode.action.ALLUSER.UPDATE";

    /* 开始阶段 */
    protected void onStart() {
        // TODO Auto-generated method stub
        super.onStart();
        Log.e("AllUser", "执行：onStart()");
        MyConfig.myClient.setHandle(mHandler);
        myupdate();
    }

    /* 重启  */
    protected void onRestart() {
        // TODO Auto-generated method stub
        super.onRestart();
        //Log.e("MainActivity", "执行：onRestart()");
    }

    /* 运行 */
    protected void onResume() {
        // TODO Auto-generated method stub
        super.onResume();
        //Log.e("MainActivity", "执行：onResume()");
    }

     /* 暂停阶段 *//* 使用这准备离开activity的地方  */
    protected void onPause() {
        // TODO Auto-generated method stub
        super.onPause();
        //Log.e("MainActivity", "执行：onPause()");
    }

    /* 停止阶段 */
    protected void onStop() {
        // TODO Auto-generated method stub
        super.onStop();
        //Log.e("MainActivity", "执行：onStop()");
    }

    /* 销毁阶段 */
    protected void onDestroy() {
        // TODO Auto-generated method stub
        super.onDestroy();
        unregisterReceiver(mReceiver);
        //Log.e("MainActivity", "执行：onDestroy()");
    }

    /* 覆写该方法，对广播事件执行响应的动作  */
    public void onReceive(Context context, Intent intent) {
        /* 获取Intent对象中的数据 */
        String msg = intent.getStringExtra("msg");
        Toast.makeText(context, msg, 1000).show();
        Log.d("shit", "hehe , boradcast");
    }

    private final BroadcastReceiver mReceiver = new BroadcastReceiver() {
        @Override
        public void onReceive(Context context, Intent intent) {
            Log.d("shit", "hehe , boradcast");
            if (ACTION_ALLUSER_UPDATE.equals(intent.getAction())) {
                Log.d("shit", "hehe , boradcast equal");
            }
        }
    };

	/* (non-Javadoc)
	 * @see android.app.Activity#onCreate(android.os.Bundle)
	 */
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_all_user);
		//requestWindowFeature(Window.FEATURE_NO_TITLE);
		//requestWindowFeature(Window.FEATURE_NO_TITLE);
        //Thread clientthread = new Thread(new MyClient());
        //clientthread.start();
		//Log.e("MainActivity", "执行：onCreate()");
        IntentFilter filter = new IntentFilter(ACTION_ALLUSER_UPDATE);
        registerReceiver(mReceiver, filter);

        listview = (ListView)this.findViewById(R.id.listView_alluser);

		textview = (TextView)this.findViewById(R.id.textView_alluser);
		myinit();

              /*
		String str = MyClient.getCurrentNetStatus(getApplicationContext());
		   Toast.makeText(AllUser.this, str,
					Toast.LENGTH_SHORT).show();
		setTitle(str);
		*/

		//添加点击
		listview.setOnItemClickListener(new OnItemClickListener() {

		             @Override
		             public void onItemClick(AdapterView<?> arg0, View arg1, int arg2,
		                     long arg3) {
		                setTitle("选择"+arg2+"个用户");
			            Intent intent = new Intent(AllUser.this,ChatActivity.class);
			            HashMap<String,Object> map = (HashMap<String,Object>)arg0.getItemAtPosition(arg2);
			            intent.putExtra("name",(String)map.get("ItemTitle"));
			            intent.putExtra("mode", "user");
			            AllUser.this.startActivity(intent);
		                //mThread.start();
		             }
		         });

	}
	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.all_user, menu);
		return true;
	}
	public void  myinit()
	{

         Log.e("AllUser","myinit");

         //added by yongming.li for bug
         //MyConfig.myClient.start(mHandler,"");
    	 /*
         ArrayAdapter<String> arrayAdapter = new ArrayAdapter<String>(this,
        		 android.R.layout.simple_list_item_1,userList);
         listview.setAdapter(arrayAdapter);
         */

          //生成动态数组，加入数据
         listItem = new ArrayList<HashMap<String, Object>>();

         listItem.clear();


          //生成适配器的Item和动态数组对应的元素
          listItemAdapter = new SimpleAdapter(this,listItem,//数据源
              R.layout.iconlistview,//ListItem的XML实现
              //动态数组与ImageItem对应的子项
              new String[] {"ItemImage","ItemTitle", "ItemText"},
              //ImageItem的XML文件里面的一个ImageView,两个TextView ID
              new int[] {R.id.IconListItemImage,R.id.IconListItemTitle,R.id.IconListItemText}
          );
          //添加并且显示
          listview.setAdapter(listItemAdapter);

	}
	@SuppressWarnings("deprecation")
	public void  myupdate()
	{
		/*
        listview.setAdapter(new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1,
        		userList));

        //生成适配器的Item和动态数组对应的元素
        listItemAdapter = new SimpleAdapter(this,listItem,//数据源
            R.layout.iconlistview,//ListItem的XML实现
            //动态数组与ImageItem对应的子项
            new String[] {"ItemImage","ItemTitle", "ItemText"},
            //ImageItem的XML文件里面的一个ImageView,两个TextView ID
            new int[] {R.id.IconListItemImage,R.id.IconListItemTitle,R.id.IconListItemText}
        );
        //添加并且显示
        listview.setAdapter(listItemAdapter);
        */
		listItem.clear();
    	int i=0;
    	Set<String> username= MyParse.userList.keySet();

    	//方法一: 用entrySet()
    	Iterator<Entry<String,Object>> it = MyParse.userList.entrySet().iterator();
    	  while(it.hasNext()){
    	   Map.Entry<String,Object> m = it.next();
    	   String key =  m.getKey();
    	   HashMap<String, Object> value= (HashMap<String, Object>)m.getValue();
    	   HashMap<String, Object> map = new HashMap<String, Object>();
    	   map.put("ItemImage", R.drawable.userheadalluser);//图像资源的ID
           map.put("ItemTitle", value.get("name"));
           map.put("ItemText","接收到 "+value.get("messagesize")+"条消息"
           		+"   当前状态：" + value.get("line")+" line");
           listItem.add(map);
    	  }

        //Log.e("AllUser","MyParse.userList size "+MyParse.userList.size());
        //Log.e("AllUser","listItem size "+listItem.size());

        listItemAdapter.notifyDataSetChanged();
        //mThread.stop();
        return;
	}

	private  Handler mHandler = new Handler() {
	        public void handleMessage (Message msg) {//此方法在ui线程运行
	            switch(msg.what) {
	            case MyConfig.MSG_USER_NODE_INFO_UPDATE:
	            case MyConfig.MSG_CHAT_UPDATE:

	            	myupdate();
	                break;
	            case MyConfig.MSG_FAILURE:
	            	Log.e("AllUser","message failed");
	                break;
	           }
	         }
	     };
	Runnable runnable = new Runnable() {
	    	public void run() {

	    		   MyConfig.PROTOCOL_CODE=MyConfig.PROTOCOL_CODE_ALLUSER;
                   //MyConfig.myClient.open();
    		       //MyConfig.myClient.start(mHandler,"smembers alluser");
    		       Log.e("AllUser","thread run is end");
	    	}
	};

}
