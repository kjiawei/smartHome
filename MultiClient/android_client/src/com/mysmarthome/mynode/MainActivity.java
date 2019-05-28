package com.mysmarthome.mynode;

import android.os.Bundle;
import android.app.Activity;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TabHost.OnTabChangeListener;
import android.widget.TabHost.TabSpec;
import android.widget.Toast;
import java.lang.Runnable;
import android.widget.*;

import android.content.*;

import com.mysmarthome.mynode.R;
import com.mysmarthome.mynode.MyTabHost;




public class MainActivity extends Activity implements OnClickListener {

	private static final String DEBUG_TAG = "mynode";
	private Button start_button;
	private TabHost tabhost;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main);
		init();
	}
	public void init() {
		start_button = (Button) findViewById(R.id.button_start);
		start_button.setOnClickListener(MainActivity.this);
		
		TabHost tabHost=(TabHost)findViewById(android.R.id.tabhost);  
		//TabHost tabHost = new TabHost();  
		tabHost.setup();  
	   
	    TabSpec spec1=tabHost.newTabSpec("Tab 1");  
		spec1.setContent(R.id.tab1);  
		spec1.setIndicator("login");  
		   
	    TabSpec spec2=tabHost.newTabSpec("Tab 2");  
		spec2.setIndicator("manager");  
	    spec2.setContent(R.id.tab2);  
  
		TabSpec spec3=tabHost.newTabSpec("Tab 3");  
		spec3.setIndicator("alluser");  
		spec3.setContent(R.id.tab3);  

		tabHost.addTab(spec1);  
		tabHost.addTab(spec2);  
		tabHost.addTab(spec3);  
		//  ????
		tabHost.setOnTabChangedListener(new OnTabChangeListener()
		{
		    public void onTabChanged(String tabId)
		    {
			    
			    if(tabId=="Tab 1")
			    {
			    	Log.e("main","login"); 
			    }
			    if(tabId=="Tab 2")
			    {
			    	Log.e("main","manager"); 
			    }
			    if(tabId=="Tab 3")
			    {
			    	Log.e("main","alluser"); 
					Intent  intent= new Intent();
					intent.setClass(MainActivity.this, AllUser.class);
				    startActivity(intent);
			    }
		    }
		});
		
	}
    public void onTabChanged(String tabId) {
    	Log.e("main","create socket"); 
    }
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.main, menu);
		return true;
	}
	/*
	Runnable runnable = new Runnable()
	{  
		     public void run() 
		     {  
		    	 try   
		    	 {
		 			Log.e(DEBUG_TAG,"create socket"); 
		 			 Socket socket = new Socket("115.29.235.211",6379);  
		 			 Log.e(DEBUG_TAG,"create socket successful");
		 			 //Socket socket = new Socket("192.168.43.70",54321);  
		             //向服务器端发送消息  
		             PrintWriter out = new PrintWriter( new BufferedWriter( new OutputStreamWriter(socket.getOutputStream())),true);        
		             out.println("smembers alluser");   
		             Log.e(DEBUG_TAG,"send data"); 
		               
		             //接收来自服务器端的消息  
		             BufferedReader br = new BufferedReader(new InputStreamReader(socket.getInputStream()));   
		             String msg=br.readLine();   
		             while( msg != null )
		             {
		            	 Log.e(DEBUG_TAG,msg);
		            	 msg=br.readLine();
		             }
 		             
		             //关闭流  
		             out.close();  
		             br.close();  
		             //关闭Socket  
		             socket.close();   
		         }  
		         catch (Exception e)   
		         {  
		             // TODO: handle exception  
		             Log.e(DEBUG_TAG, e.toString());  
		         }  

		     }  
	};
	*/
	public void onClick(View v) {
		Toast.makeText(MainActivity.this, "onClick",
				Toast.LENGTH_SHORT).show();  
		Log.e("main","id is"+R.id.button_start); 
		switch (v.getId()) {
		case R.id.button_start:
			//socketClientStart();
			//new Thread(runnable).start(); 

			//Intent  intent= new Intent();
			//intent.setClass(MainActivity.this, AllUser.class);
		    //startActivity(intent);
		    //MainActivity.this.finish();

		    
			/*
			Intent List = new Intent(Intent.ACTION_MAIN, null);
			List.setClassName(this, "com.example.mynode.MyTabHost");
			startActivity(List);
			*/
		    
			break;
		default:
			break;
		}
	}
}
 
