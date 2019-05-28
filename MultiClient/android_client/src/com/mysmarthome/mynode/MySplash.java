package com.mysmarthome.mynode;


import java.util.Timer;
import java.util.TimerTask;

import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.app.Activity;



import android.app.Activity;
import android.content.Intent;
import android.graphics.PixelFormat;

import android.util.Log;
import android.view.MotionEvent;
import android.view.Window;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.ImageView;
import android.widget.LinearLayout;

import com.mysmarthome.mynode.R;
import com.mysmarthome.mynode.*;


import net.neilgoodman.android.fragmenttabstutorial.activity.FragmentTabActivity;
import net.neilgoodman.android.fragmenttabstutorial.application.FragmentTabTutorialApplication;

public class MySplash extends Activity {
	private long startTime;  
	private boolean touched=false;  
	private Timer timer ;  
	
	 public void onAttachedToWindow() {
			super.onAttachedToWindow();
			Window window = getWindow();
			window.setFormat(PixelFormat.RGBA_8888);
	 }

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_my_splash);
        StartAnimations();
        //开启 定时器  
        timer = new Timer(true);  
        startTime = System.currentTimeMillis();  
        timer.schedule(task, 0, 1);  
    }
	private final TimerTask task = new TimerTask() {  
	         public void run() {  
	             if (task.scheduledExecutionTime() - startTime >= 2000 || touched) {  
	                 Message message = new Message();  
	                 message.what = 0;  
	                 timerHandler.sendMessage(message);  
	                 timer.cancel();  
	             }  
	   
	         }  
	 };  
	 private final Handler timerHandler = new Handler() {  
	         public void handleMessage(Message msg) {  
	             switch (msg.what) {  
	            case 0:  
	                  gotomain();
	                  
	                break;  
	            }  
	        }  
	 }; 
	 public boolean onTouchEvent(MotionEvent event) {  
	         if (event.getAction() == MotionEvent.ACTION_DOWN) {  
	            touched = true;  
	          }  
	            return true;  
	  }
	 
    private void StartAnimations() {
        Animation anim = AnimationUtils.loadAnimation(this, R.anim.alpha);
        anim.reset();
        LinearLayout l=(LinearLayout) findViewById(R.id.lin_lay);
        l.clearAnimation();
        l.startAnimation(anim);
        anim = AnimationUtils.loadAnimation(this, R.anim.translate);
        anim.reset();
        ImageView iv = (ImageView) findViewById(R.id.logo);
        iv.clearAnimation();
        iv.startAnimation(anim); 
    }
    private void gotomain()
    {
    	MySplash.this.finish();  
    	// 跳转到新的 activity  
    	//Intent intent = new Intent(MySplash.this,MainActivity.class);  
    	Intent intent = new Intent(MySplash.this,FragmentTabActivity.class);  
    	
    	//Intent intent = new Intent(MySplash.this,LoginActivity.class);  
    	
    	Log.e("login","startActivity");
    	MySplash.this.startActivity(intent);  
    }
}
