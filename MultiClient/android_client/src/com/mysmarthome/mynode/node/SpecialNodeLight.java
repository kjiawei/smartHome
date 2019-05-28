package com.mysmarthome.mynode.node;

import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;
import java.util.Map.Entry;


import com.mysmarthome.mynode.R;
import com.mysmarthome.mynode.R.layout;
import com.mysmarthome.mynode.R.menu;
import com.iflytek.cloud.RecognizerResult;
import com.iflytek.cloud.SpeechError;
import com.iflytek.cloud.ui.RecognizerDialogListener;
import com.mysmarthome.mynode.LoginActivity;
import com.mysmarthome.mynode.MyConfig;
import com.mysmarthome.mynode.chat.ChatActivity;
import com.mysmarthome.mynode.chat.ChatActivityCommon;
import com.mysmarthome.mynode.chat.JsonParser;

import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.app.Activity;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.Window;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.CompoundButton;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.ProgressBar;
import android.widget.SeekBar;
import android.widget.Spinner;
import android.widget.SeekBar.OnSeekBarChangeListener;
import android.widget.Switch;
import android.widget.TextView;
import android.widget.Toast;

public class SpecialNodeLight extends ChatActivityCommon {
	private static final String TAG = ChatActivity.class.getSimpleName();

	private  Button login_button;
	
	//private  EditText edittextSendMessage;
    private SeekBar seekBarBrightness;
    private  Switch  switchState; 
    private  Spinner  spinnerMode;
    
    
    public   HashMap<String, Object> messageHashMap = new HashMap<String, Object>();
    
    private String mRevText;
    private String talkToWho;
    
 
    private Handler mHandler = new Handler() {  
        public void handleMessage (Message msg) {//此方法在ui线程运行  
        	
            switch(msg.what) {  
            case MyConfig.MSG_CHAT_UPDATE: 
            	String str = (String)msg.obj;
            	Log.e(TAG, "handleMessage>>>>>> str is"+str);
            	String temp[] = str.split(":");
            	String mFromWho=temp[0];
            	mRevText=temp[1];
            	if(!talkToWho.equalsIgnoreCase(mFromWho))
            	{
            		return;
            	}
            	chatUpdate("other");
                break;  
           }  
         }  
     }; 
    
    private void  updateMessage(String name , String value)
    {
    	messageHashMap.put(name, value);
    	sendMessage="";
    	Iterator<Entry<String,Object>> it = messageHashMap.entrySet().iterator();  
    	while(it.hasNext()){  
    	   Map.Entry<String,Object> m = it.next();  
    	   String myKey =  m.getKey();
    	   String myValue = (String)m.getValue();
    	   if(sendMessage.length()==0)
    	   {
    		   sendMessage=sendMessage+myKey+"="+myValue;
    	   }
    	   else
    	   {
    		   sendMessage=sendMessage+","+myKey+"="+myValue;
    	   }
    	   
    	  }   	
    	Log.e(TAG, "sendMessage  is : "+sendMessage); 
    	edittextSendMessage.setText(sendMessage);
    	return;
    }
    
    public void  myInit()
    {
    	//login_button = (Button) findViewById(R.id.signin_button);
    	
    	talkView = (ListView)findViewById(R.id.light_ChatList);
    	myPreInit();
    	
    	
    	
    	
    	sendButton = (Button) findViewById(R.id.SendMessageButton);
    	sendButton.setOnClickListener(messageButtonListener);
    	
    	speechRecognizeButton = (Button) findViewById(R.id.light_button_speechrecognize);
    	speechRecognizeButton.setOnClickListener(messageButtonListener);
    	
    	recognizerDialogListener=new RecognizerDialogListener(){
	 		public void onResult(RecognizerResult results, boolean isLast) {
	 			String text = JsonParser.parseIatResult(results.getResultString());
	 			//mResultText.append(text);
	 			//mResultText.setSelection(mResultText.length());
	 			if(text.length()<2)
	 			{
	 				return;
	 			}
	 			edittextSendMessage.setText(text);
	 			edittextSendMessage.setSelection(text.length());
	 			sendMessage="value="+text;
	 			if(text.contains("开"))
	 			{
	 				sendMessage="value=open";
	 			}
	 			if(text.contains("关") || text.contains("睡觉"))
	 			{
	 				sendMessage="value=close";
	 			}
	 			//state
	 			
	 			//Log.e(TAG, text); 	
	 		}
	 		public void onError(SpeechError error) {
	 			Log.e(TAG, error.getPlainDescription(true)); 	
	 		}
	 	};
    	
    	
    	seekBarBrightness = (SeekBar)findViewById(R.id.light_seekbarBar_brightness);
    	seekBarBrightness.setMax(255);
    	seekBarBrightness.setProgress(100);
    	seekBarBrightness.setOnSeekBarChangeListener(seekListerner);
    	
    	edittextSendMessage = (EditText)findViewById(R.id.light_edittext_send_message);
    	
    	
    	spinnerMode = (Spinner) findViewById(R.id.light_spinner_mode);
    	
    	
		ArrayAdapter<String> adapter;
        adapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
   
        adapter.add("auto");
        adapter.add("manual");

        spinnerMode.setAdapter(adapter);
        
        spinnerMode.setOnItemSelectedListener(new Spinner.OnItemSelectedListener()  
        {  
            public void onItemSelected(AdapterView<?> arg0, View arg1,  
                    int arg2, long arg3) {  
                // TODO Auto-generated method stub  
                //messageText.setText(normalMeassgelList.get(arg2));
                
                String mode = (String)arg0.getItemAtPosition(arg2);
                Log.e(TAG, "mode  is : "+mode); 
                updateMessage("mode",mode);
                //设置显示当前选择的项  
                //arg0.setVisibility(View.VISIBLE);  
            }

			@Override
			public void onNothingSelected(AdapterView<?> arg0) {
				// TODO Auto-generated method stub
				
			}  
              
        });  

    	switchState = (Switch)findViewById(R.id.light_switch_state);
    	switchState.setOnCheckedChangeListener(new Switch.OnCheckedChangeListener() {  
    		                @Override  
    		                public void onCheckedChanged(CompoundButton buttonView,  
    		                       boolean isChecked) {  
    		                  // TODO Auto-generated method stub  
    		                	String state="close";
    		                    if (isChecked) {  
    		                    	state="open";	
    		                    } 
    		                    updateMessage("state",state);
    		               }  
    		           });  	
    }

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_special_node_light);
		myInit();
	}
	
    // 拖动条事件  
	private OnSeekBarChangeListener seekListerner = new OnSeekBarChangeListener()
	{  
	         // 拖动条停止执行  
	         public void onStopTrackingTouch(SeekBar seekBar)
	         {  
	         }  
	         // 开始执行  
	         public void onStartTrackingTouch(SeekBar seekBar) 
	         {  
	         }  
	         // 拖动中  
	         public void onProgressChanged(SeekBar seekBar, int progress, boolean fromUser)
	         {  
	        	 updateMessage("brightness",String.format("%d",seekBar.getProgress() ));
	         }  
	 };
	 
           
	 

}
