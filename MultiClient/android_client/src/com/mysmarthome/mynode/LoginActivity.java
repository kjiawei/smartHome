package com.mysmarthome.mynode;
  
import com.mysmarthome.mynode.R;

import android.app.Activity;  
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.os.Bundle;  
import android.os.Handler;
import android.os.Message;
import android.util.Log;
import android.view.View;
import android.view.Window;  
import android.view.View.OnClickListener;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

  
public class LoginActivity extends Activity implements OnClickListener{  
	private  Button login_button;
	private  Button send_fake_data_button;
	private  EditText send_fake_data_editText;
	private  EditText edittext_name;
	private  EditText edittext_password;
	public  TextView textview_userid;
	
	private String name="";
	private String password="";
	
    private ProgressBar proressBar;


	private Thread mThread; 
	private Thread mThreadHeartBeat; 
    @Override  
    
    public void onCreate(Bundle savedInstanceState) {  
        super.onCreate(savedInstanceState);  
        requestWindowFeature(Window.FEATURE_NO_TITLE);  
        //Log.e("login","onCreate");
        setContentView(R.layout.login); 
        
    	login_button = (Button) findViewById(R.id.signin_button);
    	login_button.setOnClickListener(LoginActivity.this);
    	
    	//added by yongming.li for send fake node data for test android client without control node
    	// 世界杯期间多看看cctv5吧
    	
        String sendData ="node ok light name=light,state=open,brightness:255;name=tv,state=close,channel=cctv5;name=temperature,value=30";
    	send_fake_data_button = (Button) findViewById(R.id.button_login_send_fake_data);
    	send_fake_data_button.setOnClickListener(LoginActivity.this);
    	send_fake_data_editText= (EditText)findViewById(R.id.editText_login_send_fake_data);
    	send_fake_data_editText.setText(sendData);
    	
    	
    	proressBar = (ProgressBar)findViewById(R.id.progressBar_login);
    	edittext_name=(EditText)findViewById(R.id.username_edit);
    	edittext_password=(EditText)findViewById(R.id.password_edit);
    	
    	textview_userid=(TextView)findViewById(R.id.login_getuserid_textview);
    	//textview_userid=(TextView)findViewById(R.id.login_real_top_layout_status_textview);
    	

    	textview_userid.setText(MyConfig.USERID);
    	
    	
		SharedPreferences  share = LoginActivity.this.getSharedPreferences("perference", MODE_PRIVATE);  
		//Editor editor = share.edit();//取得编辑器  
    	name = share.getString("name", "");//根据key寻找值 参数1 key 参数2 如果没有value显示的内容  
    	password  = share.getString("password", ""); 
    	edittext_name.setText(name);
    	edittext_password.setText(password);
    	proressBar.setIndeterminate(false);
    	proressBar.setVisibility(View.INVISIBLE);  
    	MyConfig.myClient.setHandle(mHandler);
    	connectServer();
    	
    }  
    
    private void connectServer()
    {
    	if(MyConfig.myClient.isRunning==true)
		{
			return;
		}
		//Intent serviceIntent = new Intent();
		//serviceIntent.setAction("Start.MyBatteryService");
		//startService(serviceIntent);
		
	    mThread = new Thread(runnable);  
	    mThread.start();
	    // added by yongming.li for heart beat
	    mThreadHeartBeat = new Thread(runnableHeartBeat);  
	    mThreadHeartBeat.start();
        return;     	
    }
    
    public void onClick(View v) {
		//Log.e("main","id is"+R.id.signin_button); 
		
		switch (v.getId()) {
		case R.id.button_login_send_fake_data:
			 String message = send_fake_data_editText.getText().toString().trim();
			 MyConfig.myClient.parseMessage(message);
			 return;
		case R.id.signin_button:
			//Toast.makeText(LoginActivity.this, "login begin",
			//		Toast.LENGTH_SHORT).show();  
			MyConfig.PROTOCOL_CODE=MyConfig.PROTOCOL_CODE_LOGIN;
			name=edittext_name.getText().toString().trim();
			password = edittext_password.getText().toString().trim();
			if(name.length()==0 || password.length()==0)
			{
    			Toast.makeText(LoginActivity.this, "用户名或密码为空",
    					Toast.LENGTH_SHORT).show(); 
    			// added by yongming.li for special ui 
				Animation shakeAnim = AnimationUtils.loadAnimation(this, R.anim.shake);  
				edittext_name.startAnimation(shakeAnim);
				edittext_password.startAnimation(shakeAnim);
				return;
			}
			SharedPreferences  share = LoginActivity.this.getSharedPreferences("perference", MODE_PRIVATE);  
			Editor editor = share.edit();//取得编辑器  
			editor.putString("name", name);//存储配置 参数1 是key 参数2 是值  
			editor.putString("password", password);  
			editor.commit();//提交刷新数据 
			proressBar.setVisibility(View.VISIBLE);  
			proressBar.setIndeterminate(true);
			
    		MyConfig.myClient.setHandle(mHandler);
    		String str = String.format("user login  %s  %s r r",
    				     name,password);
    		
    		MyConfig.myClient.runCmd(str);
    		//MyConfig.myClient.insertCmd(str);
    		
			break;
		default:
			break;
		}
	}
    
    private Handler mHandler = new Handler() {  
        public void handleMessage (Message msg) {//此方法在ui线程运行  
        	//Log.e("login","handleMessage");
            switch(msg.what) {  
            
            case MyConfig.MSG_LOGIN_SUCCESS:  
    			Toast.makeText(LoginActivity.this, "登录成功",
    					Toast.LENGTH_SHORT).show(); 
                break;  
            case MyConfig.MSG_LOGIN_FAILURE:  
            	// added by yongming.li for more info of login fail
    			Toast.makeText(LoginActivity.this, "登录失败,"+(String)msg.obj,
    					Toast.LENGTH_SHORT).show();  
                break; 
            case MyConfig.MSG_LOGIN_USERID:  
            	textview_userid.setText((String)msg.obj);
            	MyConfig.USERID=(String)msg.obj;
                break; 
                
            case MyConfig.MSG_NET_FAIL:  
            	MyConfig.USERID="";
            	textview_userid.setText(MyConfig.USERID);
                break; 
            
            case MyConfig.MSG_NET_NEXT_LOOP:  
            	MyConfig.USERID="";
            	textview_userid.setText(MyConfig.USERID);
    			Toast.makeText(LoginActivity.this,"循环进入下次网络连接",
    					Toast.LENGTH_SHORT).show();  
                break; 
            case MyConfig.MSG_NET_RUNCMD_FAIL:  
            	MyConfig.USERID="";
            	textview_userid.setText(MyConfig.USERID);
    			Toast.makeText(LoginActivity.this,"send cmd failed",
    					Toast.LENGTH_SHORT).show();  
                break;      
           }  
            proressBar.setVisibility(View.INVISIBLE);
         }  
     };  
	Runnable runnable = new Runnable() {
		public void run() {
			MyConfig.myClient.start();
			MyClient.isRunning=false;
		}
	};

	Runnable runnableHeartBeat = new Runnable() {
		public void run() {
			try {
				MyConfig.myHeartBeat.start();
			} catch (InterruptedException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
	};

}  

