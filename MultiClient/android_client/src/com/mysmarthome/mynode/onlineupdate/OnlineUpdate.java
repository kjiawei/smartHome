// auther : yongming.li 

package com.mysmarthome.mynode.onlineupdate;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.UnsupportedEncodingException;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;

import com.mysmarthome.mynode.R;
import com.mysmarthome.mynode.R.layout;
import com.mysmarthome.mynode.R.menu;
import com.mysmarthome.mynode.LoginActivity;
import com.mysmarthome.mynode.MyConfig;

import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.os.Handler;
import android.os.Message;
import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.content.pm.PackageManager.NameNotFoundException;
import android.text.method.ScrollingMovementMethod;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

public class OnlineUpdate extends Activity implements OnClickListener{

	private static final String TAG = "OnlineUpdate";
	
	private  Button get_version_button;
	private  Button sure_to_update_button;
	private  TextView  current_version_textview;
	private  TextView  last_version_textview;
	private  TextView  changelog_textview;
	
	
	private  static final int  state_down_normal=0;
	private  static final int  state_down_version=1;
	private  static final int  state_down_changelog=2;
	private  static final int  state_down_apk=3;
	public   static int  state_down=state_down_normal;
	
	StringBuilder sb_changelog = new StringBuilder("");
	
	// 参考 AndroidManifest.xml ， 还是避免解析xml
	// verCode = context.getPackageManager().getPackageInfo("com.update.apk", 0).versionCode;
	// verName = context.getPackageManager().getPackageInfo("com.update.apk", 0).versionName;
    // android:versionCode="1"
    // android:versionName="1.0" 
	private  String  currentVersion="";
	private  String  lastVersion="";
	
	private String  apkName ="MyNode.apk";
	public   ProgressDialog  pBar;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_online_update);
		
    	pBar = new ProgressDialog(OnlineUpdate.this);   
        pBar.setTitle("正在下载");   
        pBar.setMessage("喝杯咖啡，请稍候...");   
        pBar.setProgressStyle(ProgressDialog.STYLE_SPINNER);
		
		get_version_button = (Button) findViewById(R.id.button_onlineupdate_get_version_info);
		get_version_button.setOnClickListener(this);
		
		sure_to_update_button = (Button) findViewById(R.id.button_onlineupdate_sure_to_update);
		sure_to_update_button.setOnClickListener(this);
				
		changelog_textview=(TextView) findViewById(R.id.textview_onlineupdate_changelog);
		changelog_textview.setMovementMethod(ScrollingMovementMethod.getInstance());  
		
		
		current_version_textview = (TextView) findViewById(R.id.textview_onlineupdate_current);
		currentVersion=MyConfig.CURRENT_VERSION;
		
		try {
			currentVersion=String.format("%d",getPackageManager().getPackageInfo("com.mysmarthome.mynode", 0).versionCode);
		} catch (NameNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		current_version_textview.setText(currentVersion);
		
		last_version_textview = (TextView) findViewById(R.id.textview_onlineupdate_last);
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.online_update, menu);
		return true;
	}
	 public void onClick(View v) {
			//Log.e("main","id is"+R.id.signin_button); 
			
		    if (v.getId()==R.id.button_onlineupdate_get_version_info)
		    {
		    	state_down=state_down_version;
		    	downFile(MyConfig.SERVER_FILE_VERSION,"version");
		    }
		    
		    if (v.getId()==R.id.button_onlineupdate_sure_to_update)
		    {
		    	state_down=state_down_apk;
		    	Log.e(TAG,"realUpdate"); 
		    	if(checkNeedUpdate(lastVersion,currentVersion)==0)
		    	{
		    		Toast.makeText(getApplicationContext(),
		    				"目前已是最新版本，你太着急了...",Toast.LENGTH_LONG).show();//没有新版本
			        return;	
		    	}
		    	    
                pBar.show();
		    	downFile(MyConfig.SERVER_FILE_APK,apkName);
		    }

		}
	 public  Handler mHandler = new Handler() {  
	        public void handleMessage (Message msg) {//此方法在ui线程运行  
	        	
	            switch(msg.what) {  
	            
	            case MyConfig.MSG_ONLINEUPDATE_GET_VERSION:  
	    			Toast.makeText(OnlineUpdate.this, "获取版本信息",
	    					Toast.LENGTH_SHORT).show(); 
	    			//lastVersion=(String)msg.obj;
	    			last_version_textview.setText(lastVersion);
	    			
	    			state_down=state_down_changelog;
	    			downFile(MyConfig.SERVER_FILE_CHANGELOG,"changelog");
	                break;  
	                
	            case MyConfig.MSG_ONLINEUPDATE_GET_CHANGELOG:  
	    			Toast.makeText(OnlineUpdate.this, "获取版本更新细节",
	    					Toast.LENGTH_SHORT).show(); 
	    			changelog_textview.setMaxHeight(200);
	    			
	    			String path = Environment.getExternalStorageDirectory()+ "/"+"changelog";  
                    try {
						FileInputStream  fis=new FileInputStream(path);  
							//	openFileInput(path);
						byte[] buff_detail = new byte[2048];
						int hasRead=0;
						if(sb_changelog.length()==0)
						{
							Log.e(TAG, "sb_changelog  is :"+sb_changelog.length()); 
							while((hasRead=fis.read(buff_detail)) > 0)
							{
								Log.e(TAG, "hasRead is :"+hasRead); 
								sb_changelog.append(new String(buff_detail,0,hasRead));
							}
							Log.e(TAG, "sb_changelog  is :"+sb_changelog.length()); 
							changelog_textview.setText(sb_changelog.toString());
						}

						fis.close();
					} catch (FileNotFoundException e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
					} catch (IOException e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
					}
                            
                    
	    			state_down=state_down_normal;
	    			
	                break; 	   
	                
	            case MyConfig.MSG_ONLINEUPDATE_GET_APK:  
	    			Toast.makeText(OnlineUpdate.this, "APK下载完成",
	    					Toast.LENGTH_SHORT).show(); ;
	    			state_down=state_down_normal;
	    			pBar.cancel();
	    			realUpdate();
	                break;
	                
	            case MyConfig.MSG_ONLINEUPDATE_GET_FAIL:  
	    			Toast.makeText(OnlineUpdate.this, "获取升级信息或者APK失败，请检查网络！",
	    					Toast.LENGTH_SHORT).show(); 
	                break;
	           }  
	         }  
	     };  
	void downFile(final String url ,final String fileName) {
	    //pBar.show();
	    new Thread() {
	        public void run() {
	        	//Log.e(TAG, "run"); 
	        	HttpClient client = new DefaultHttpClient();
	            HttpGet get = new HttpGet(url);
	            HttpResponse response;
	            try {
	                response = client.execute(get);
	                HttpEntity entity = response.getEntity();
	                long length = entity.getContentLength();
	                //Log.e(TAG, "length is :"+length); 
	                InputStream is = entity.getContent();
	                FileOutputStream fileOutputStream = null;
	                byte[] buf = new byte[4096];
	                if (is != null) {
	
	                    File file = new File(
	                            Environment.getExternalStorageDirectory(),
	                            fileName);
	                    fileOutputStream = new FileOutputStream(file);
	 
	                    
	                    int ch = -1;
	                    int count = 0;
	                    while ((ch = is.read(buf)) != -1) {	   
	                    	//Log.e(TAG, "ch is :"+ch); 
	                        fileOutputStream.write(buf, 0, ch);
	                        count += ch;
	                        if (length > 0) {
	                        }
	                    }
	                    //added by yongming.li for show update details 
                    	if(state_down==state_down_version)
                    	{
                    		lastVersion=new String(buf,"utf-8");
	                    	 mHandler.obtainMessage(MyConfig.MSG_ONLINEUPDATE_GET_VERSION,new String(buf,"utf-8")).sendToTarget();
                    	}

	 
	                }
	                fileOutputStream.flush();
	                if (fileOutputStream != null) {
	                    fileOutputStream.close();
	                }
	                
                	if(state_down==state_down_changelog)
                	{
                    	mHandler.obtainMessage(MyConfig.MSG_ONLINEUPDATE_GET_CHANGELOG,new String(buf,"utf-8")).sendToTarget();
                	}
                	
                	if(state_down==state_down_apk)
                	{
                    	mHandler.obtainMessage(MyConfig.MSG_ONLINEUPDATE_GET_APK,"MyNode.apk").sendToTarget();
                	}
	                //down();
	            } catch (IOException e) {
	            	mHandler.obtainMessage(MyConfig.MSG_ONLINEUPDATE_GET_FAIL,"http failed").sendToTarget();
	                e.printStackTrace();
	            }
	        }
	 
	    }.start();
   }
  void realUpdate() {	 
	    Intent intent = new Intent(Intent.ACTION_VIEW);
	    String apkPath = Environment.getExternalStorageDirectory()+ "/"+apkName;   
	    intent.setDataAndType(Uri.fromFile(new File(Environment.getExternalStorageDirectory(), apkName)),"application/vnd.android.package-archive");
	    startActivity(intent);
	}
  int checkNeedUpdate(String last , String current)
  {
    // 注意是否  0x0a 0x0c
	if(currentVersion=="" || lastVersion=="")
	{
		return 0;
	}
	
	try {
		if(Integer.parseInt(last.trim())>Integer.parseInt(current.trim()))
		{
			return 1;
		}
	} catch (Exception e) {
		Log.e(TAG,e.toString());
	}
	return 0;
  }
}
