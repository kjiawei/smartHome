
package com.mysmarthome.mynode.chat;

import android.app.Activity;
import android.graphics.Color;
import android.graphics.drawable.GradientDrawable;
import android.graphics.drawable.GradientDrawable.Orientation;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.Window;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.Spinner;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.HashMap;

import com.mysmarthome.mynode.R;
import com.iflytek.cloud.ErrorCode;
import com.iflytek.cloud.InitListener;
import com.iflytek.cloud.RecognizerResult;
import com.iflytek.cloud.SpeechConstant;
import com.iflytek.cloud.SpeechError;
import com.iflytek.cloud.SpeechRecognizer;
import com.iflytek.cloud.SpeechUtility;
import com.iflytek.cloud.ui.RecognizerDialog;
import com.iflytek.cloud.ui.RecognizerDialogListener;
import com.mysmarthome.mynode.MyConfig;
import com.mysmarthome.mynode.MyParse;
import com.mysmarthome.mynode.MyParseCommon;

public class ChatActivityCommon extends Activity {
    private static final String TAG = ChatActivityCommon.class.getSimpleName();
    
    private String   mRevText;
    private String   talkToWho;
    private String   chatmode;
    public  String  sendMessage="";
    public  ListView talkView;
    protected EditText edittextSendMessage;
    
    protected Button sendButton;
    protected Button speechRecognizeButton;
    
    protected RecognizerDialogListener recognizerDialogListener;
    
  
    public    ArrayList<ChatMsgEntity> chatlist = new ArrayList<ChatMsgEntity>();
    public    HashMap<String, Object> userNodeList;
    
	// 语音听写对象
	private SpeechRecognizer mIat;
	// 语音听写UI
	private RecognizerDialog iatDialog;
    

    protected void onStart() {  
        // TODO Auto-generated method stub  
        super.onStart();  
        Log.e(TAG, "执行：onStart()");  
        MyConfig.myClient.setHandle(mHandler);
    }  
    
    public void  myPreInit()
    {
    	Bundle bundle=getIntent().getExtras();  
        talkToWho=bundle.getString("name"); 
        
        chatmode=bundle.getString("mode");
        if(chatmode.equalsIgnoreCase("node"))
        {
        	//Log.v(TAG, "onCreate node mode >>>>>>");
        	userNodeList=MyParse.nodeList;
        }
        if(chatmode.equalsIgnoreCase("user"))
        {
        	//Log.v(TAG, "onCreate user mode >>>>>>");
        	userNodeList=MyParse.userList;
        }
        setTitle("正在同 "+talkToWho+" 聊天"); 
        
        Log.e(TAG, "正在同 "+talkToWho+" 聊天"); 
        
        try
        {
        	if(userNodeList.containsKey(talkToWho))
            {
            	HashMap<String, Object> map = (HashMap<String, Object>)userNodeList.get(talkToWho);
            	ArrayList<String> messageList = (ArrayList<String>)map.get("messages");
            	for(int j=0;j<messageList.size();j++)
            	{
            		Log.e(TAG, "message_"+j+" is "+messageList.get(j)); 
            		mRevText=messageList.get(j);
            		chatUpdate("other");
            	}
            	// 阅后即焚
            	messageList.clear();
            	map.put("messagesize","0");
            }
        }
        catch(Exception e)
        {
        	Log.e(TAG, e.toString()); 
        }
        //added by yongming.li for speech recognize
        SpeechUtility.createUtility(this, SpeechConstant.APPID +"=53a7d172");
		// 初始化识别对象
		mIat = SpeechRecognizer.createRecognizer(this, mInitListener);
		// 设置参数
		setParam();
		// 初始化听写Dialog,如果只使用有UI听写功能,无需创建SpeechRecognizer
		iatDialog = new RecognizerDialog(this,mInitListener);
		//////////////////////////////////////////////////////////////////////
    }
    public void onCreate(Bundle savedInstanceState) {
        Log.v(TAG, "onCreate >>>>>>");
        super.onCreate(savedInstanceState);
    }
    public void chatUpdate(String fromWho)
    {
    	int RId=0;
        String name = getName();
        String date = getDate();
        String msgText = getSendMessage();
        if(fromWho=="me")
        {
        	RId = R.layout.list_say_me_item;
        	name = "me";
        }
        else
        {
        	RId = R.layout.list_say_he_item;    
        	msgText=getRevText();
        	name=getFromwho();
        }

        ChatMsgEntity newMessage = new ChatMsgEntity(name, date, msgText, RId);
        chatlist.add(newMessage);
        // list.add(d0);
        
        talkView.setAdapter(new ChatMsgViewAdapter(ChatActivityCommon.this, chatlist));
        //messageText.setText("");
        talkView.setSelection(chatlist.size()-1);

        // myAdapter.notifyDataSetChanged();
     	return;
    }

    // shuold be redefine in the future
    public String getName() {
        //return getResources().getString(R.string.myDisplayName);
    	return "other";
    	
    }
    
    // shuold be redefine in the future
    public String getDate() {
        Calendar c = Calendar.getInstance();
        String date = String.valueOf(c.get(Calendar.YEAR)) + "-"
                + String.valueOf(c.get(Calendar.MONTH)) + "-" + c.get(Calendar.DAY_OF_MONTH);
        return date;
    }

    public String getSendMessage() {
        return sendMessage;
    }
    public String getRevText() {
        return mRevText;
    }
    public String getFromwho() {
        return talkToWho;
    }
    
    public void onDestroy() {
        Log.v(TAG, "onDestroy>>>>>>");
        super.onDestroy();
    }
    public Handler mHandler = new Handler() {  
        public void handleMessage (Message msg) {//此方法在ui线程运行  
            switch(msg.what) {  
            case MyConfig.MSG_CHAT_UPDATE: 
            	String str = (String)msg.obj;
            	//Log.e(TAG, "handleMessage>>>>>> str is"+str);
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
     
     public OnClickListener messageButtonListener = new OnClickListener() {

         @Override
         public void onClick(View arg0) {
             // TODO Auto-generated method stub
        	 
        	 
         	    if(arg0==speechRecognizeButton)
         	    {
 				    iatDialog.setListener(recognizerDialogListener);
 				    iatDialog.show();
 				    return;
         	    }


         		String name = getFromwho();
         		String parentname = MyParseCommon.getParentNameByName(userNodeList,name);
         		String str = String.format("user say %s %s NULL  0",parentname,sendMessage);
         		
                 if(chatmode.equalsIgnoreCase("node"))
                 {
                 	str = String.format("node say %s  name=%s,value=%s NULL  0",parentname,name,sendMessage);
                 }
         		Log.e(TAG, str); 	
         		MyConfig.myClient.runCmd(str);
         	    chatUpdate("me");
         	    return;

         }

     };
     
     //added by yongming.li for speech recognize
     /**
 	 * 初始化监听器。
 	 */
 	private InitListener mInitListener = new InitListener() {

 		@Override
 		public void onInit(int code) {
 			Log.d(TAG, "SpeechRecognizer init() code = " + code);
 			if (code == ErrorCode.SUCCESS) {
 				//findViewById(R.id.iat_recognize).setEnabled(true);
 				Log.e(TAG, "ErrorCode.SUCCESS"); 	
 			}
 		}
 	};
 	
 	public void setParam(){
 	
 		mIat.setParameter(SpeechConstant.DOMAIN, "iat");
 		mIat.setParameter(SpeechConstant.LANGUAGE, "zh_cn");
 		mIat.setParameter(SpeechConstant.ACCENT, "mandarin");
 		// 设置语音前端点
 		mIat.setParameter(SpeechConstant.VAD_BOS, "4000");
 		// 设置语音后端点
 		mIat.setParameter(SpeechConstant.VAD_EOS,  "1000");
 		// 设置标点符号
 		mIat.setParameter(SpeechConstant.ASR_PTT, "0");
 		// 设置音频保存路径
 		mIat.setParameter(SpeechConstant.ASR_AUDIO_PATH, "/sdcard/iflytek/wavaudio.pcm");
 	}
     

}
