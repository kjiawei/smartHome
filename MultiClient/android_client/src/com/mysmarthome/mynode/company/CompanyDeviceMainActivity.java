package com.mysmarthome.mynode.company;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;

import com.mysmarthome.mynode.R;
import com.mysmarthome.mynode.R.layout;
import com.mysmarthome.mynode.R.menu;
import com.mysmarthome.mynode.LoginActivity;
import com.mysmarthome.mynode.MyConfig;

import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.app.Activity;
import android.app.DatePickerDialog;
import android.app.TimePickerDialog;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.util.Log;
import android.util.TypedValue;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup.LayoutParams;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.view.animation.TranslateAnimation;
import android.view.ext.SatelliteMenu;
import android.view.ext.SatelliteMenu.SateliteClickedListener;
import android.view.ext.SatelliteMenuItem;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.LinearLayout;
import android.widget.Toast;

public class CompanyDeviceMainActivity extends Activity implements OnClickListener{

	private Thread mThread; 
	public Calendar  c;
	public DatePickerDialog datePicker;
	public TimePickerDialog timePicker;
	
	public Button timerButton;
	public Button lightnessButton;
	public Button lightnessButtonOther;
	public Button colorButton;
	
	public LinearLayout  lightnessLayout;
	public LinearLayout  lightnessLayoutOther;
	public LinearLayout  colorLayout;
	public Button  indexButton;
	public int lastIndex=0;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_company_device_main);
		          
		 c = Calendar.getInstance();
		 datePicker = new DatePickerDialog(CompanyDeviceMainActivity.this,
				new DatePickerDialog.OnDateSetListener() {
					
					@Override
					public void onDateSet(DatePicker view, int year, int monthOfYear,
							int dayOfMonth) {
						// TODO Auto-generated method stub						
					}
				}
				             ,c.get(Calendar.YEAR),
				              c.get(Calendar.MONTH),
				              c.get(Calendar.DAY_OF_MONTH));
		 
		lightnessButton = (Button) findViewById(R.id.company_device_lightness_button);
		lightnessButton.setOnClickListener(this);
		
		lightnessButtonOther = (Button) findViewById(R.id.company_device_lightness_other_button);
		lightnessButtonOther.setOnClickListener(this);
		
		
		indexButton =  (Button)findViewById(R.id.company_device_action_divider);

			
			
	    colorButton = (Button) findViewById(R.id.company_device_color_button);
	    colorButton.setOnClickListener(this);
		
		timerButton = (Button) findViewById(R.id.company_device_timer_button);
		timerButton.setOnClickListener(this);
		
		colorLayout = (LinearLayout) findViewById(R.id.company_device_color_layout);
		lightnessLayout = (LinearLayout) findViewById(R.id.company_device_lightness_layout);
		
		lightnessLayoutOther= (LinearLayout) findViewById(R.id.company_device_lightness_other_layout);

		
		showIndex(0);

	}

    public void showIndex(int index)
    {
		colorLayout.setVisibility(View.GONE);
		lightnessLayout.setVisibility(View.GONE);
		lightnessLayoutOther.setVisibility(View.GONE);
		
		if(index==0)
		{
			lightnessLayout.setVisibility(View.VISIBLE);
		}
		if(index==1)
		{
			lightnessLayoutOther.setVisibility(View.VISIBLE);
		}
		if(index==2)
		{
			colorLayout.setVisibility(View.VISIBLE);
		}
		if(lastIndex==index)
		{
			return;
		}
		int indexWidth=80+20;
		int x=0;
		TranslateAnimation  a=null;
		if(index>lastIndex)
		{
		    x=lastIndex*indexWidth+(lastIndex)*30;
			a = new TranslateAnimation(0+x,x+(index-lastIndex)*indexWidth+(index-lastIndex)*30,0,0); 
		}
		if(index<lastIndex)
		{
			x=lastIndex*indexWidth+(lastIndex)*30;
			a = new TranslateAnimation(0+x,x+(index-lastIndex)*indexWidth+(index-lastIndex)*30,0,0); 
		}

		a.setDuration(1000);
	    a.setFillAfter(true);
		indexButton.setAnimation(a);
		lastIndex=index;
		return;
    }
	@Override
	public void onClick(View v) {
				switch (v.getId()) {
				case R.id.company_device_lightness_button:
					showIndex(0);
					break;
				case R.id.company_device_lightness_other_button:
					showIndex(1);
					break;
				case R.id.company_device_color_button:	
					showIndex(2);
					break;
				case R.id.company_device_timer_button:	
					datePicker.show();
					break;
				default:
					break;
				}
	}	
} 


