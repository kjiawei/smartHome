package net.neilgoodman.android.fragmenttabstutorial.fragment;


import net.neilgoodman.android.fragmenttabstutorial.activity.FragmentTabActivity;
import net.neilgoodman.android.fragmenttabstutorial.adapter.LocationModelGridAdapter;
import net.neilgoodman.android.fragmenttabstutorial.application.FragmentTabTutorialApplication;
import net.neilgoodman.android.fragmenttabstutorial.model.LocationModel;
import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.GridView;
import android.widget.Toast;

import com.mysmarthome.mynode.R;

import com.mysmarthome.mynode.*;
import com.mysmarthome.mynode.company.CompanyDeviceMainActivity;
import com.mysmarthome.mynode.company.CompanyMainActivity;
import com.mysmarthome.mynode.node.SpecialNodeLight;
import com.mysmarthome.mynode.onlineupdate.OnlineUpdate;
import com.mysmarthome.mynode.rssreader.RssReader;
import com.mysmarthome.mynode.setting.MySetting;
import com.mysmarthome.mynode.setting.MySettingActivity;
import com.mysmarthome.mynode.wizard.MyWizard;

public class LocationGridFragment extends Fragment {
    
    private GridView                 mGridView;
    private LocationModelGridAdapter mGridAdapter;
    
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_location_grid, container, false);
        
        // Store a pointer to the GridView that powers this grid fragment.
        mGridView = (GridView) view.findViewById(R.id.grid_view);
        
        return view;
    }
    
    @Override
    public void onActivityCreated(Bundle savedInstanceState) {
        super.onActivityCreated(savedInstanceState);
        Activity activity = getActivity();
        
        if (activity != null) {
            // Create an instance of the custom adapter for the GridView. A static array of location data
            // is stored in the Application sub-class for this app. This data would normally come
            // from a database or a web service.
            mGridAdapter = new LocationModelGridAdapter(activity, FragmentTabTutorialApplication.sLocations);
            
            if (mGridView != null) {
                mGridView.setAdapter(mGridAdapter);
            }
            
            // Setup our onItemClickListener to emulate the onListItemClick() method of ListFragment.
            mGridView.setOnItemClickListener(new OnItemClickListener() {

                @Override
                public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                    onGridItemClick((GridView) parent, view, position, id);
                }
                
            });
        }
    }
    
    public void onGridItemClick(GridView g, View v, int position, long id) {
    	
        Activity activity = getActivity();
        Log.e("LocationGridFragment",String.format("onGridItemClick position is %d",position));
    	Intent intent =null;  
    	// yongming.li for ...
    	intent = new Intent(activity,NoFinish.class); 
    	if(position==0)
    	{
    		intent = new Intent(activity,LoginActivity.class); 
    	}
	
    	if(position==1)
    	{
    		intent = new Intent(activity,AllUser.class); 
    	}
	    if(position==2)
    	{
    		intent = new Intent(activity,AllNode.class); 
    	}
	    if(position==3)
    	{
    		intent = new Intent(activity,MySettingActivity.class); 
    	}

	    
	     if(position==4)
    	{
    		intent = new Intent(activity,RssReader.class); 
    		intent = new Intent(activity,CompanyDeviceMainActivity.class); 
    		
    	}
	     
	    if(position==5)
    	{
    		intent = new Intent(activity,OnlineUpdate.class); 
    	}
	    
	    if(position==6)
    	{
    		intent = new Intent(activity,CompanyMainActivity.class); 
    	}
	    
	    if(position==7)
    	{
    		intent = new Intent(activity,MyWizard.class); 
    	}
	    
	    
	    
	    try
	    {
	    	startActivity(intent); 	    	
	    }
        catch(Exception e)
        {
        	Log.e("main", e.toString());
        }
  
	
        if (activity != null) {
            LocationModel locationModel = (LocationModel) mGridAdapter.getItem(position);
            
            // Display a simple Toast to demonstrate that the click event is working. Notice that Fragments have a
            // getString() method just like an Activity, so that you can quickly access your localized Strings.
            //Toast.makeText(activity, getString(R.string.toast_item_click) + locationModel.address, Toast.LENGTH_SHORT).show();
        }
    }

}
