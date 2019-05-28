package com.mysmarthome.mynode.node;


import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;
import java.util.Set;
import java.util.Map.Entry;

import org.achartengine.ChartFactory;
import org.achartengine.model.TimeSeries;
import org.achartengine.model.XYMultipleSeriesDataset;
import org.achartengine.renderer.SimpleSeriesRenderer;
import org.achartengine.renderer.XYMultipleSeriesRenderer;
import org.achartengine.renderer.XYSeriesRenderer;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.app.Activity;
import android.graphics.Color;
import android.util.Log;
import android.view.View;
import android.graphics.Paint.Align;
import org.achartengine.chart.PointStyle;

import com.mysmarthome.mynode.R;
import com.mysmarthome.mynode.MyConfig;
import com.mysmarthome.mynode.MyParse;
import com.mysmarthome.mynode.MyParseCommon;

public class NodetemperatureActivity extends Activity {

	  
	private Thread mThread; 
	private static final String TAG = NodetemperatureActivity.class.getSimpleName();
    private  View myview;
    
    XYMultipleSeriesDataset dataset = new XYMultipleSeriesDataset();
    TimeSeries series = new TimeSeries("室内温度");
    
    List<double[]> x = new ArrayList<double[]>();
    private String talkToWho;
    
    
    
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		
		
        Bundle bundle=getIntent().getExtras();  
        talkToWho=bundle.getString("name"); 
        setTitle("设备名 : "+talkToWho); 

	    int[] colors = new int[] { Color.BLUE };
	    PointStyle[] styles = new PointStyle[] { PointStyle.CIRCLE };
	    XYMultipleSeriesRenderer renderer = buildRenderer(colors, styles);

	    int length = renderer.getSeriesRendererCount();
	    for (int i = 0; i < length; i++) {
	      ((XYSeriesRenderer) renderer.getSeriesRendererAt(i)).setFillPoints(true);
	    }
	
	    setChartSettings(renderer, "温度曲线", "时间", "温度", 0.5, 12.5, -10, 40,
	            Color.LTGRAY, Color.LTGRAY);
	    renderer.setXLabels(10);
	    renderer.setYLabels(10);
	    renderer.setShowGrid(true);
	    renderer.setXLabelsAlign(Align.CENTER);
	    renderer.setYLabelsAlign(Align.RIGHT);
	    dataset.addSeries(series);

	    try
	    {
	        myview = ChartFactory.getLineChartView(this, dataset,renderer);
	    }
	    catch(Exception e)
	    {
	    	Log.e(TAG, e.toString());
	    }
	    
	    setContentView(myview);
	    Log.e(TAG, "执行：onCreate()"); 
	    
	    //mThread = new Thread(runnable);  
	    //mThread.start();
	    
	}

	  protected XYMultipleSeriesDataset buildDateDataset(String[] titles, List<Date[]> xValues,
		      List<double[]> yValues) { 
		    dataset.clear();
		    int length = titles.length;
		    for (int i = 0; i < length; i++) {
		      TimeSeries series = new TimeSeries(titles[i]);
		      Date[] xV = xValues.get(i);
		      double[] yV = yValues.get(i);
		      int seriesLength = xV.length;
		      for (int k = 0; k < seriesLength; k++) {
		        series.add(xV[k], yV[k]);
		      }
		      dataset.addSeries(series);
		    }
		    return dataset;
		  }
	  
	  protected XYMultipleSeriesRenderer buildRenderer(int[] colors, PointStyle[] styles) {
		    XYMultipleSeriesRenderer renderer = new XYMultipleSeriesRenderer();
		    setRenderer(renderer, colors, styles);
		    return renderer;
		  }
	  protected void setRenderer(XYMultipleSeriesRenderer renderer, int[] colors, PointStyle[] styles) {
		    renderer.setAxisTitleTextSize(16);
		    renderer.setChartTitleTextSize(20);
		    renderer.setLabelsTextSize(15);
		    renderer.setLegendTextSize(15);
		    renderer.setPointSize(5f);
		    renderer.setMargins(new int[] { 20, 30, 15, 20 });
		    int length = colors.length;
		    for (int i = 0; i < length; i++) {
		      XYSeriesRenderer r = new XYSeriesRenderer();
		      r.setColor(colors[i]);
		      r.setPointStyle(styles[i]);
		      renderer.addSeriesRenderer(r);
		    }
		  }
	  protected XYMultipleSeriesRenderer buildBarRenderer(int[] colors) {
		    XYMultipleSeriesRenderer renderer = new XYMultipleSeriesRenderer();
		    renderer.setAxisTitleTextSize(16);
		    renderer.setChartTitleTextSize(20);
		    renderer.setLabelsTextSize(15);
		    renderer.setLegendTextSize(15);
		    int length = colors.length;
		    for (int i = 0; i < length; i++) {
		      SimpleSeriesRenderer r = new SimpleSeriesRenderer();
		      r.setColor(colors[i]);
		      renderer.addSeriesRenderer(r);
		    }
		    return renderer;
		  }
	  protected void setChartSettings(XYMultipleSeriesRenderer renderer, String title, String xTitle,
		      String yTitle, double xMin, double xMax, double yMin, double yMax, int axesColor,
		      int labelsColor) {
		    renderer.setChartTitle(title);
		    renderer.setXTitle(xTitle);
		    renderer.setYTitle(yTitle);
		    renderer.setXAxisMin(xMin);
		    renderer.setXAxisMax(xMax);
		    renderer.setYAxisMin(yMin);
		    renderer.setYAxisMax(yMax);
		    renderer.setAxesColor(axesColor);
		    renderer.setLabelsColor(labelsColor);
		  }
	  
	  Runnable runnable = new Runnable() {   
	    	public void run() {
	    	List<double[]> values = new ArrayList<double[]>();
			values.add(new double[] { 11.2, 31.5, 21.7, 51.5, 21.4, 11.4, 31.3, 1.1, 20.6, 30.3, 20.2 ,
					1.2, 11.5, 28.7, 31.5, 44.4, 11.4, 51.3, 21.1, 20.6, 20.3, 20.2
					});
			double[] yV =  values.get(0);
			int i=0;
	    	while(i<values.get(0).length)
	    	{
	    		  Log.e(TAG, "i is : "+i);
		          try {
						Thread.sleep(500);
					} catch (InterruptedException e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
					}
		          dataset.clear();
			      series.add(i, yV[i]);
			      dataset.addSeries(series);
			      myview.postInvalidate();
			      i++;
		     }
		      //如果在非UI主线程中，需要调用postInvalidate()，具体参考api
		      //chart.invalidate(); 
	    }

	};
	
	public void  myupdate()
	{
		try
		{
		if(MyParse.nodeList.containsKey(talkToWho))
        {
        	HashMap<String, Object> map = (HashMap<String, Object>)MyParse.nodeList.get(talkToWho);
        	ArrayList<String> messageList = (ArrayList<String>)map.get("messages");
        	for(int j=0;j<messageList.size();j++)
        	{
        		Log.e(TAG, "message_"+j+" is "+messageList.get(j)); 
		        dataset.clear();
			    //series.add(j,Double.parseDouble(messageList.get(j)));
			    
			    series.add(j,Double.parseDouble(MyParseCommon.getValueFromMessageByName(messageList.get(j),"value")));
			
			    
			    dataset.addSeries(series);
        	}
        	myview.postInvalidate();
        	// 阅后即焚
        	messageList.clear();
        	map.put("messagesize","0");
        }
		}
		catch(Exception e)
		{
			Log.e(TAG,e.toString()); 
		}
        return;		
	}
	protected void onStart() {  
        // TODO Auto-generated method stub  
        super.onStart();  
        Log.e(TAG, "执行：onStart()"); 
        MyConfig.myClient.setHandle(mHandler);
        myupdate();
    }  
	private  Handler mHandler = new Handler() {  
        public void handleMessage (Message msg) {//此方法在ui线程运行  
            switch(msg.what) {  
            case MyConfig.MSG_USER_NODE_INFO_UPDATE: 
            case MyConfig.MSG_CHAT_UPDATE:
            	myupdate();
                break;  
           }  
         }  
     }; 

}
