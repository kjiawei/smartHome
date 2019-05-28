package com.tcl.homemonitor;

import java.io.BufferedOutputStream;
import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.Date;

import org.apache.http.HttpEntity;   
import org.apache.http.HttpResponse;     
import org.apache.http.HttpVersion; 
import org.apache.http.client.HttpClient;   
import org.apache.http.client.methods.HttpPost;   
import org.apache.http.entity.mime.MultipartEntity;   
import org.apache.http.entity.mime.content.FileBody;     
import org.apache.http.impl.client.DefaultHttpClient;   
import org.apache.http.params.CoreProtocolPNames;
import org.apache.http.util.EntityUtils;
import org.apache.commons.mail.Email;
import org.apache.commons.mail.EmailException;  
import org.apache.commons.mail.HtmlEmail; 
import org.apache.commons.mail.SimpleEmail;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.R.integer;
import android.app.Activity;
import android.content.pm.ActivityInfo;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.PixelFormat;
import android.hardware.Camera;
import android.hardware.Camera.AutoFocusCallback;
import android.hardware.Camera.Parameters;
import android.hardware.Camera.PictureCallback;
import android.os.Bundle;
import android.os.Environment;
import android.os.Handler;
import android.os.Message;
import android.util.DisplayMetrics;
import android.view.Display;
import android.view.SurfaceHolder;
import android.view.SurfaceView;
import android.view.Window;
import android.view.WindowManager;
import android.widget.Toast;

public class MainActivity extends Activity implements SurfaceHolder.Callback 
{
	private String TAG = "HomeMonitor";
    private SurfaceView mSurfaceView;
    private SurfaceHolder mSurfaceHolder;
    private Camera mCamera;
    private String mSavePath;
    private Handler mHandler;
    
    private int mScreenWidth;
    private int mScreenHeight;
    
    private final int mTimerSleep = 5000;
    private String mUrlString = "http://115.29.235.211/monitor/upload.php";
    
    private final int MESSAGE_TIMER = 1;
    private final int MESSAGE_SHUTTER = 2;
    private final int MESSAGE_UPLOAD = 3;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) 
	{
		super.onCreate(savedInstanceState);
		requestWindowFeature(Window.FEATURE_NO_TITLE);//没有标题
        this.getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN, WindowManager.LayoutParams.FLAG_FULLSCREEN);//设置全屏
        this.getWindow().addFlags(WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON);//拍照过程屏幕一直处于高亮
        this.setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_LANDSCAPE); //设置手机屏幕朝向-横屏
        setContentView(R.layout.activity_main);
        
        // 获取窗口管理器,获取屏幕的宽和高
		WindowManager wm = getWindowManager();
		Display display = wm.getDefaultDisplay();
		DisplayMetrics metrics = new DisplayMetrics();
		display.getMetrics(metrics);
		mScreenWidth = metrics.widthPixels;
		mScreenHeight = metrics.heightPixels;

        mSurfaceView = (SurfaceView) findViewById(R.id.camera_surface);
        mSurfaceHolder = mSurfaceView.getHolder();//获得句柄
        mSurfaceHolder.addCallback(this);//添加回调
        mSurfaceHolder.setFixedSize(mScreenWidth,mScreenHeight);
        
		//Timer Thread
        new Thread(new TimerThread()).start();  
        
        //Handle
        mHandler = new Handler() 
		{  
            public void handleMessage (Message msg) 
            { 
            	String strShow;
            	switch (msg.what) 
            	{
            	case MESSAGE_TIMER:
            		takePicture();
            		break;
				case MESSAGE_SHUTTER:
					strShow = "照片：" + (String)msg.obj + "  拍摄" + ((msg.arg1==1)?"成功":"失败");
					Toast.makeText(MainActivity.this, strShow, Toast.LENGTH_SHORT).show();
					break;
				case MESSAGE_UPLOAD:
					strShow = "照片：" + (String)msg.obj + "  上传" + ((msg.arg1==1)?"成功":"失败");
					Toast.makeText(MainActivity.this, strShow, Toast.LENGTH_SHORT).show();
					break;
				default:
					break;
				}
             }  
         }; 
	}
	
	public void takePicture()
	{
		try
		{
			mCamera.autoFocus(new AutoFocusCallback() 
	        {
	            @Override
	            public void onAutoFocus(boolean success, Camera camera) //自动对焦
	            {
	                if(success) 
	                {
	                    //设置参数，并拍照
	                    Parameters params = mCamera.getParameters();
	                    params.setPictureFormat(PixelFormat.JPEG);//图片格式
	                    params.setPreviewSize(mScreenWidth, mScreenHeight);//图片大小
	                    params.setPictureSize(mScreenWidth,mScreenHeight);
	                    camera.setParameters(params);//将参数设置到我的camera
	                    camera.takePicture(null, null, pictureCallback);//将拍摄到的照片给自定义的对象
	                }
	            }
	        });
		}
		catch(Exception e)
		{
			e.printStackTrace();
		}
	}
	
    @Override
    public void surfaceChanged(SurfaceHolder mSurfaceHolder, int format, int width, int height)
    {
    }

    @Override
    public void surfaceCreated(SurfaceHolder mSurfaceHolder) 
    {
        if(mCamera == null) 
        {
            try 
            {
            	mCamera = Camera.open();
                mCamera.setPreviewDisplay(mSurfaceHolder); //通过surfaceview显示取景画面
                mCamera.startPreview(); //开始预览
            } 
            catch (IOException e) 
            {
                e.printStackTrace();
            }
        }
    }

    @Override
    public void surfaceDestroyed(SurfaceHolder surfaceHolder) 
    {
        mCamera.stopPreview();
        mCamera.release();
        mCamera = null;
        mSurfaceView = null;
        surfaceHolder = null;
    }

    public class TimerThread implements Runnable
	{
		public void run()   
	    {    
			while (true) 
			{  
	            try 
	            {  
	                Thread.sleep(mTimerSleep);  
	                Message msg = new Message();
	            	msg.what = MESSAGE_TIMER;
	                mHandler.sendMessage(msg);  
	            }
	            catch (Exception e) 
	            {  
	                e.printStackTrace();  
	            }  
			}
        }
	}
    
    //创建jpeg图片回调数据对象
    PictureCallback pictureCallback= new PictureCallback() 
    {
        @Override
        public void onPictureTaken(byte[] data, Camera camera) 
        {
        	Message msg = new Message();
        	msg.what = MESSAGE_SHUTTER;
            try
            {
            	String strFileName ="PIC_"+ new SimpleDateFormat("yyyyMMddHHmmss").format(new Date())+".jpg";
            	mSavePath = Environment.getExternalStorageDirectory()+"/DCIM/" + strFileName;
                msg.obj = strFileName;
                
                Bitmap bitmap = BitmapFactory.decodeByteArray(data, 0, data.length);
                File file = new File(mSavePath);
                BufferedOutputStream bos = new BufferedOutputStream(new FileOutputStream(file));
                bitmap.compress(Bitmap.CompressFormat.JPEG, 100, bos);//将图片压缩的流里面
                bos.flush();// 刷新此缓冲区的输出流
                bos.close();// 关闭此输出流并释放与此流有关的所有系统资源
                camera.stopPreview();//关闭预览 处理数据
                camera.startPreview();//数据处理完后继续开始预览
                bitmap.recycle();//回收bitmap空间
                
                msg.arg1 = 1; //拍照成功
                new Thread(new UploadThread()).start();
            } 
            catch (Exception e) 
            {
            	msg.arg1 = 0; //拍照失败
                e.printStackTrace();
            }
            mHandler.sendMessage(msg);
        }
    };

    public class UploadThread implements Runnable
	{
		public void run()   
	    {     
			Message msg = new Message();
        	msg.what = MESSAGE_UPLOAD;
        	msg.obj = mSavePath.substring(mSavePath.lastIndexOf('/'));

			HttpClient httpclient = new DefaultHttpClient();  
	        httpclient.getParams().setParameter(CoreProtocolPNames.PROTOCOL_VERSION, HttpVersion.HTTP_1_1);  
	        HttpPost httppost = new HttpPost(mUrlString);  
	        MultipartEntity entity = new MultipartEntity();  
	        File file = new File(mSavePath);  
	        FileBody fileBody = new FileBody(file);  
	        entity.addPart("file", fileBody);  
	        httppost.setEntity(entity);  
	        try 
	        {
	        	HttpResponse response = httpclient.execute(httppost);   
		        HttpEntity resEntity = response.getEntity();  
		        if (resEntity != null) 
		        {              
		            //Toast.makeText(this, EntityUtils.toString(resEntity), Toast.LENGTH_LONG).show(); 
		        	String strJSON = EntityUtils.toString(response.getEntity());
		        	parseJsonString(strJSON);
		        }  
		        httpclient.getConnectionManager().shutdown();  
		        file.delete();
		        msg.arg1 = 1; //上传成功
			} 
	        catch (Exception e) 
	        {
	        	msg.arg1 = 0; //上传失败
				e.printStackTrace();
			}
	        mHandler.sendMessage(msg);
	    }
	}
    
    public int parseJsonString(String strJSON)
    {
    	try 
    	{  
    		JSONObject obj = new JSONObject(strJSON).getJSONObject("singer"); 
    		int id = obj.getInt("id"); 
    		String name = obj.getString("name"); 
    		String gender = obj.getString("gender"); 
    		return 1;
    	} 
    	catch (JSONException e) 
    	{  
    		System.out.println("Json parse error"); 
    		e.printStackTrace(); 
    	}  
    	return 0;
    }
    
    public void sendEmail(int nHeadCount)
    {
            try 
            {  
            	Email email = new SimpleEmail();
                //HtmlEmail email = new HtmlEmail();  
                // 这里是发送服务器的名字  
                email.setHostName("stmp.163.com");  
                // 编码集的设置  
                email.setTLS(true);  
                email.setSSL(true);  
                email.setCharset("gbk");  
                // 收件人的邮箱  
                email.addTo("j0yang@qq.com");  
                // 发送人的邮箱  
                email.setFrom("j0yang@163.com");  
                // 如果需要认证信息的话，设置认证：用户名-密码。分别为发件人在邮件服务器上的注册名称和密码  
                email.setAuthentication("j0yang", "wy&86528611");  
                email.setSubject("测试Email Apache");  
                // 要发送的信息  
                email.setMsg("测试Email Apache");  
                // 发送  
                email.send();  
            } 
            catch (EmailException e) 
            {  
                e.printStackTrace();
            }  
    }  
}