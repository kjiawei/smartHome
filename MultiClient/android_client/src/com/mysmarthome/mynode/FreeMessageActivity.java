package com.mysmarthome.mynode;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.ArrayList;

import com.mysmarthome.mynode.R;

import android.net.Uri;
import android.os.Bundle;
import android.provider.CallLog;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.database.Cursor;
import android.telephony.PhoneNumberUtils;
import android.telephony.PhoneStateListener;
import android.telephony.TelephonyManager;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.TextView;

public class FreeMessageActivity extends Activity {

	private ListView  listview;
	private TextView  textview;
	private Button    sendbutton;
	private  ArrayList<String> messageList = new ArrayList<String>();
	private String  TAG="FreeMessageActivity";
	private Thread mThread; 
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_free_message);
        listview = (ListView)this.findViewById(R.id.listView_freemessage);
		//textview = (TextView)this.findViewById(R.id.textView_freemessage);
		
		messageList.add("你妈叫你回去吃饭0.");
		messageList.add("你妈叫你回去吃饭1.");
		messageList.add("你妈叫你回去吃饭2.");
		messageList.add("你妈叫你回去吃饭3.");
		messageList.add("你妈叫你回去吃饭4.");
		messageList.add("你妈叫你回去吃饭5.");
		messageList.add("你妈叫你回去吃饭6.");
		messageList.add("你妈叫你回去吃饭7.");
		messageList.add("你妈叫你回去吃饭8.");
		messageList.add("你妈叫你回去吃饭9.");
		messageList.add("你妈叫你早点回家10.");
		messageList.add("打球，晚点回家11.");
        ArrayAdapter<String> arrayAdapter = new ArrayAdapter<String>(this,
       		 android.R.layout.simple_list_item_1,messageList);
        listview.setAdapter(arrayAdapter);
        
        /* 取得电话服务 */  
        TelephonyManager telManager = (TelephonyManager)getSystemService(Context.TELEPHONY_SERVICE);  
        //监听电话的状态  
        telManager.listen(listener, PhoneStateListener.LISTEN_CALL_STATE); 
        
        sendbutton = (Button)this.findViewById(R.id.button_call_freemessage);
        
  
        OnClickListener buttonListener = new OnClickListener() {

            @Override
            public void onClick(View arg0) {
            	
            		Log.e(TAG, "Button onclick >>>>>>>>");
            		//Intent intent=new Intent(Intent.ACTION_CALL,Uri.parse("tel:18925993137"));
            		Intent intent=new Intent(Intent.ACTION_CALL,Uri.parse("tel:13809661605"));
            		startActivity(intent);
            		return;
            	}
        };
		sendbutton.setOnClickListener(buttonListener);

		mThread = new Thread(runnable);
		
		mThread.start();
	}
    PhoneStateListener listener = new PhoneStateListener(){   
		         @Override  public void onCallStateChanged(int state, String incomingNumber) {  
		               switch (state){  
		                 case TelephonyManager.CALL_STATE_IDLE: /* 无任何状态时 */  
		                     //if(onCreateFlag){  
		                         Log.e(TAG,"idle number is :"+incomingNumber);//如果挂断  
		                     //}  
		                     break;  
	                    case TelephonyManager.CALL_STATE_OFFHOOK: /* 接起电话时 */  
		                     //if(onCreateFlag && curentTime >= 1){  
		                         Log.e(TAG,"running number is :"+incomingNumber);//如果被接起  
		                         //mThread.start();
		                     //}  
		                       
		                     break;    
		                 case TelephonyManager.CALL_STATE_RINGING: /* 电话进来时 */  
		                      Log.e(TAG,"coming number is :"+incomingNumber);  
		                      //mThread.start();
		                     break;  
		                 default:  
		                	 Log.e(TAG,"else state");
		             break;  
		               }  
		         super.onCallStateChanged(state, incomingNumber);  
		         }             
		     };  

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.free_message, menu);
		return true;
	}
	
	Runnable runnable = new Runnable() {
		public void run() {
			while(true)
			{
				try {
					Cursor cursor = FreeMessageActivity.this.managedQuery(
							CallLog.Calls.CONTENT_URI, new String[] { "name",
									"number", "duration","date" },
									"number=13809661605 and type=2 ", 
									null, " date  DESC limit 1");
					if (cursor.moveToNext()) {
						do {
							String strName = cursor.getString(cursor
									.getColumnIndex("name"));
							String strNumber = cursor.getString(cursor
									.getColumnIndex("number"));
							long lDuration = cursor.getLong(cursor
									.getColumnIndex("duration"));

							String strDate = cursor.getString(cursor
									.getColumnIndex("date"));
							Log.e(TAG,"date:"+strDate+ " name : " + strName + " number: "
									+ strNumber + " duration:" + lDuration);

						} while (cursor.moveToNext());
					}
				} catch (Exception e) {
					Log.e("Myparse", e.toString());
				}
				try {
					Thread.sleep(500);
				} catch (InterruptedException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
					Log.e("Myparse", e.toString());
				}
				
			}
			
		}

	};
	/*
	 * Runnable runnable = new Runnable() {
	 * 
	 * 
	 * } public void run() { int mytime=0;
	 * 
	 * TelephonyManager telManager =
	 * (TelephonyManager)getSystemService(Context.TELEPHONY_SERVICE); int
	 * callState = telManager.getCallState(); Log.e("TestService",
	 * "开始.........." + Thread.currentThread().getName()); //记录拨号开始时间 long
	 * threadStart = System.currentTimeMillis(); Process process; InputStream
	 * inputstream; BufferedReader bufferedreader;
	 * 
	 * try { process = Runtime.getRuntime().exec("logcat -v time -b radio");
	 * inputstream = process.getInputStream(); InputStreamReader
	 * inputstreamreader = new InputStreamReader( inputstream); bufferedreader =
	 * new BufferedReader(inputstreamreader); String str = ""; long dialingStart
	 * = 0; boolean enableVibrator = false; boolean isAlert = false; while ((str
	 * = bufferedreader.readLine()) != null) { //如果话机状态从摘机变为空闲,销毁线程 if
	 * (callState == TelephonyManager.CALL_STATE_OFFHOOK &&
	 * telManager.getCallState() == TelephonyManager.CALL_STATE_IDLE) { break; }
	 * // 线程运行5分钟自动销毁 if (System.currentTimeMillis() - threadStart > 300000) {
	 * break; } Log.i("TestService", Thread.currentThread().getName() + ":" +
	 * str); // 记录GSM状态DIALING if (str.contains("GET_CURRENT_CALLS") &&
	 * str.contains("DIALING")) { // 当DIALING开始并且已经经过ALERTING或者首次DIALING if
	 * (!isAlert || dialingStart == 0) { //记录DIALING状态产生时间 dialingStart =
	 * System.currentTimeMillis(); isAlert = false; } continue; } if
	 * (str.contains("GET_CURRENT_CALLS") &&
	 * str.contains("ALERTING")&&!enableVibrator) {
	 * 
	 * long temp = System.currentTimeMillis() - dialingStart; isAlert = true;
	 * //这个是关键,当第一次DIALING状态的时间,与当前的ALERTING间隔时间在1.5秒以上并且在20秒以内的话
	 * //那么认为下次的ACTIVE状态为通话接通. if (temp > 1500 && temp < 20000) { enableVibrator
	 * = true; Log.i("TestService", "间隔时间....." + temp + "....." +
	 * Thread.currentThread().getName()); } continue; } if
	 * (str.contains("GET_CURRENT_CALLS") && str.contains("ACTIVE") &&
	 * enableVibrator) { enableVibrator = false; break; } } Log.i("TestService",
	 * "结束.........." + Thread.currentThread().getName()); } catch (Exception e)
	 * { // TODO: handle exception }
	 * 
	 * while(true) { Log.e(TAG,"time slip is "+mytime); try { Thread.sleep(500);
	 * } catch (InterruptedException e) { // TODO Auto-generated catch block
	 * e.printStackTrace(); } mytime++; }
	 * 
	 * 
	 * } };
	 */

}
