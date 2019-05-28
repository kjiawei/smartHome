package com.mysmarthome.mynode.setting;

import com.mysmarthome.mynode.R;
import com.mysmarthome.mynode.R.layout;
import com.mysmarthome.mynode.R.menu;

import android.os.Bundle;
import android.app.Activity;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.support.v4.app.NavUtils;
import android.annotation.TargetApi;
import android.content.SharedPreferences;
import android.os.Build;

import android.preference.PreferenceActivity;
import android.preference.PreferenceManager;

//
public class MySettingActivity extends PreferenceActivity {

	
	@Override
	@SuppressWarnings("deprecation")
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		//setContentView(R.layout.activity_my_setting);
		addPreferencesFromResource(R.xml.preferences);
		
	}
	
	

}
