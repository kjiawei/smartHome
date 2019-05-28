package com.example.popstar;

import java.io.Serializable;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.Window;
import android.view.WindowManager;

public class MainActivity extends Activity {

	// 游戏进度数据传给GameView
	private GameView myView;
	private int[][] mat;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		// 隐去Android顶部状态栏
		getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
				WindowManager.LayoutParams.FLAG_FULLSCREEN);
		// 隐去程序标题栏
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		// 加载游戏进度数据给GameView
		myView = new GameView(this);
		Intent intent = getIntent();
		Serializable matrix =  intent.getSerializableExtra("matrix");
		Object[] b;
		int[] c;
		if (matrix!= null && matrix instanceof Object[]) {
			mat = new int[10][10];
			b = (Object[]) matrix;
			for (int i=0; i<b.length; i++) {
				if (b[i] instanceof int[]) {
					c = (int[]) b[i];
					for (int j=0; j<c.length; j++) {
						mat[i][j] = c[j];
					}
				}
			}
			
			myView.matrix = mat;
		}

		// 设置显示GameView界面
		setContentView(myView);
	}

	@Override
	public void onBackPressed() {
		Intent intent = new Intent();
		intent.putExtra("PROGRESS", Utils.array2str(myView.matrix));

		setResult(1, intent);

		super.onBackPressed();
	}

}
