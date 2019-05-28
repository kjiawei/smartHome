package com.mysmarthome.mynode;

import android.app.Service;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.net.wifi.p2p.WifiP2pManager;
import android.os.BatteryManager;
import android.os.IBinder;
import android.util.Log;
import android.widget.Toast;


public class MyBatteryService extends Service  {
    @Override
    public IBinder onBind(Intent intent) {
        return null;
    }

    @Override
    public void onCreate() {
        super.onCreate();
        Toast.makeText(this, "MyBatteryService created…", Toast.LENGTH_LONG).show();
        IntentFilter filter = new IntentFilter();
     
        filter.addAction(Intent.ACTION_SCREEN_OFF);
        filter.addAction(Intent.ACTION_SCREEN_ON);
        filter.addAction(Intent.ACTION_BATTERY_CHANGED);
        registerReceiver(mIntentReceiver, filter);
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        Toast.makeText(this, "MyBatteryService destroyed…", Toast.LENGTH_LONG).show();
    }
    
     //声明消息处理过程  
    private BroadcastReceiver mIntentReceiver = new BroadcastReceiver() {  
            @Override  
            public void onReceive(Context context, Intent intent) {  
               Log.e("MyBatteryService","recevive broadcast");
               String action = intent.getAction();  
                //要看看是不是我们要处理的消息  
                if (action.equals(Intent.ACTION_BATTERY_CHANGED)) {             
                    //电池电量，数字  
                    Log.e("Battery", "" + intent.getIntExtra("level", 0));       
                    //added by yongming.li for auto close the light
                    
                    
                    //////////////////////////////////////////////////////////////////////
                    Log.e("Battery", "" + intent.getIntExtra("scale", 0));                 
                    Log.e("Battery", "" + intent.getIntExtra("voltage", 0));                 
                    Log.e("Battery", "" + intent.getIntExtra("temperature", 0));  
                      
                    // 电池状态，返回是一个数字  
                    // BatteryManager.BATTERY_STATUS_CHARGING 表示是充电状态  
                    // BatteryManager.BATTERY_STATUS_DISCHARGING 放电中  
                    // BatteryManager.BATTERY_STATUS_NOT_CHARGING 未充电  
                    // BatteryManager.BATTERY_STATUS_FULL 电池满  
                    Log.e("Battery", "" + intent.getIntExtra("status", BatteryManager.BATTERY_STATUS_UNKNOWN));    
                }  
            }  
        };  
}
