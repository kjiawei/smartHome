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

	// �������������Ϣ��TAG
	public static final String TAG = "Pop_GAME";
	// �����洢����ͨ�����ֿ��ҵ�SharedPreferences����
	public static final String PREFS_STRING = "Pop_GAME_PROGRESS";
	private Button btn_start;
	private Button btn_resume;
	private Button btn_exit;
	private int state[][];
	private String ss;

	// �������ֲ���MediaPlayer����
	private MediaPlayer player;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		// ��ȥAndroid����״̬��
		getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
				WindowManager.LayoutParams.FLAG_FULLSCREEN);
		// ��ȥ���������
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		// ������ʾGameView����
		setContentView(R.layout.ac_start);
		// ��raw�ļ����л�ȡһ��������Դ�ļ�
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
	 * ������ǰ�������Ϸ����
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
	 * ���浱ǰ��Ϸ����
	 */
	private void saveGameProgress() {
		SharedPreferences settings = getSharedPreferences(PREFS_STRING,
				MODE_PRIVATE);
		SharedPreferences.Editor editor = settings.edit();

		String progress = ss;
		// �����ݱ���
		editor.putString("PROGRESS", progress);
		editor.commit();
	}

	@Override
	protected void onResume() {
		super.onResume();
		// ��������ѭ����Ȼ����������
		player.setLooping(true);
		player.start();
	}

	@Override
	protected void onPause() {
		super.onPause();
		// ��ͣ����
		if (player.isPlaying()) {
			player.pause();
		}
	}

	@Override
	protected void onDestroy() {
		super.onDestroy();
		// ֹͣ����,�ͷ���Դ
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
