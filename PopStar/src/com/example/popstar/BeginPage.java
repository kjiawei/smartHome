package com.example.popstar;

import android.app.Activity;
import android.content.Intent;
import android.content.SharedPreferences;
import android.media.MediaPlayer;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.Window;
import android.view.WindowManager;
import android.widget.Button;

public class BeginPage extends Activity {

	// 用于输出调试信息的TAG
	public static final String TAG = "Pop_GAME";
	// 给定存储名，通过名字可找到SharedPreferences对象
	public static final String PREFS_STRING = "Pop_GAME_PROGRESS";
	private Button btn_start;
	private Button btn_resume;
	private Button btn_exit;
	private int state[][];
	private String ss;

	// 背景音乐播放MediaPlayer对象
	private MediaPlayer player;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		// 隐去Android顶部状态栏
		getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
				WindowManager.LayoutParams.FLAG_FULLSCREEN);
		// 隐去程序标题栏
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		// 设置显示GameView界面
		setContentView(R.layout.ac_start);
		// 从raw文件夹中获取一个音乐资源文件
		player = MediaPlayer.create(this, R.raw.fire);

		btn_start = (Button) findViewById(R.id.btn_start);
		btn_resume = (Button) findViewById(R.id.btn_resume);
		btn_exit = (Button) findViewById(R.id.btn_exit);

		btn_start.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				Intent intent = new Intent();
				intent.setClass(BeginPage.this, MainActivity.class);
				startActivityForResult(intent, 100);
				overridePendingTransition(android.R.anim.fade_in,
						android.R.anim.fade_out);

			}
		});
		btn_resume.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				loadGameProgress();
				if (state != null) {
					Intent intent = new Intent();
					intent.putExtra("matrix", state);
					intent.setClass(BeginPage.this, MainActivity.class);
					startActivityForResult(intent, 101);
					overridePendingTransition(android.R.anim.fade_in,
							android.R.anim.fade_out);
				}

			}
		});
		btn_exit.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				finish();

			}
		});
	}

	/**
	 * 加载以前保存的游戏进度
	 */
	private void loadGameProgress() {
		try {
			SharedPreferences settings = getSharedPreferences(PREFS_STRING,
					MODE_PRIVATE);
			String progress = settings.getString("PROGRESS", "abc");
			if (!progress.equals("abc")) {
				state = new int[10][10];
				state = Utils.str2array(progress);
			}

		} catch (Exception e) {
			Log.e(TAG, e.getMessage());
		}
	}

	/**
	 * 保存当前游戏进度
	 */
	private void saveGameProgress() {
		SharedPreferences settings = getSharedPreferences(PREFS_STRING,
				MODE_PRIVATE);
		SharedPreferences.Editor editor = settings.edit();

		String progress = ss;
		// 将数据保存
		editor.putString("PROGRESS", progress);
		editor.commit();
	}

	@Override
	protected void onResume() {
		super.onResume();
		// 设置无限循环，然后启动播放
		player.setLooping(true);
		player.start();
	}

	@Override
	protected void onPause() {
		super.onPause();
		// 暂停播放
		if (player.isPlaying()) {
			player.pause();
		}
	}

	@Override
	protected void onDestroy() {
		super.onDestroy();
		// 停止播放,释放资源
		if (player.isPlaying()) {
			player.stop();
		}
		player.release();
	}

	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		if (resultCode == 1) {
			ss = data.getStringExtra("PROGRESS");
			saveGameProgress();
		}

		super.onActivityResult(requestCode, resultCode, data);
	}


}
