package com.mysmarthome.mynode;

import android.os.Bundle;
import android.widget.TabHost;
import android.app.TabActivity;


public class MyTabHost extends TabActivity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		//setContentView(R.layout.activity_my_tab_host);
		TabHost tabHost = this.getTabHost();
        /*
        tabHost.addTab(tabHost.newTabSpec("tab1")
                .setIndicator("tab1")
                .setContent(R.id.tab1));
        */
	}
}
