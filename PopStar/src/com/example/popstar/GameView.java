package com.example.popstar;

import java.util.ArrayList;
import java.util.Collections;
import java.util.HashMap;
import java.util.LinkedList;
import java.util.List;
import java.util.Map;

import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.Paint;
import android.media.AudioManager;
import android.media.SoundPool;
import android.view.MotionEvent;
import android.view.SurfaceHolder;
import android.view.SurfaceView;

public class GameView extends SurfaceView implements SurfaceHolder.Callback {
	private Bitmap background; // ��Ϸ����ͼ
	private Bitmap words;// ����ͼ
	private Bitmap word1;// ����ͼ
	private Bitmap word2;// ����ͼ
	private Bitmap word3;// ����ͼ
	private Bitmap ui1;// ����ͼ
	private Bitmap ui2;// ����ͼ
	private Bitmap ui3;// ����ͼ
	private Bitmap gameover; // ��Ϸ����ͼ

	private Bitmap[] starpic = new Bitmap[5]; // �洢����ͼƬ

	private double p; // ���ǵı߳�
	private int screenW;// ��
	private int screenH;// ��
	private int mark;

	private int score = 0; // ����
	private int rank = 1; // �ؿ�
	private int asking = 1000; // ÿ��Ҫ��
	private boolean game = true; // ��Ϸ�Ƿ����

	private SoundPool soundPool; // ��Ч�غ���Ч��Դ
	private Map<Integer, Integer> soundMap;
	private final int SOUND_PT = 1;

	private SurfaceHolder holder;
	private boolean finished;
	Bitmap[] bmps = null;
	final float FRAME_TIME = 1.0F / 60; // �ٶ�ÿ�����60֡
	float stateTime = 0F;
	List<Animation> sprites = Collections
			.synchronizedList(new LinkedList<Animation>());

	public int[][] matrix = null;

	private List<Node> list = new ArrayList<Node>();

	private Paint paint; // ���Ƽ���ͼ�εĻ���
	private Paint p_text; // ���Ƽ���ͼ�εĻ���

	public GameView(Context context) {
		super(context);
		// ���û������ԣ���ɫ���޾��ƽ����ʵ����
		paint = new Paint();
		paint.setColor(Color.RED);
		paint.setAntiAlias(true);
		paint.setStyle(Paint.Style.STROKE);

		p_text = new Paint();
		p_text.setColor(Color.WHITE);
		p_text.setTextSize(25);
		p_text.setAntiAlias(true);
		p_text.setStyle(Paint.Style.STROKE);
		// ��Ч��ʼ��
		initSounds();

		// ��ȡholder���Ա����ǿ�����Ϸ�����ˢ�¹���
		holder = this.getHolder();
		holder.addCallback(this);
		// ������Ϸ����ɴ���
		setFocusable(true);
		setFocusableInTouchMode(true);
		requestFocus();

		if (matrix == null) {
			matrix = new int[10][10];
			for (int i = 0; i < 10; i++) {
				for (int j = 0; j < 10; j++) {
					matrix[i][j] = 1 + (int) (Math.random() * 5);
				}
			}
		}
	}

	public Animation makeAnimation(float playDuration, float x, float y) {
		if (bmps == null) {
			// ���ض�����Դ��������������
			bmps = new Bitmap[10];
			bmps[0] = BitmapFactory.decodeResource(getResources(), R.raw.p1);
			bmps[1] = BitmapFactory.decodeResource(getResources(), R.raw.p2);
			bmps[2] = BitmapFactory.decodeResource(getResources(), R.raw.p3);
			bmps[3] = BitmapFactory.decodeResource(getResources(), R.raw.p4);
			bmps[4] = BitmapFactory.decodeResource(getResources(), R.raw.p5);
			bmps[5] = BitmapFactory.decodeResource(getResources(), R.raw.p6);
			bmps[6] = BitmapFactory.decodeResource(getResources(), R.raw.p7);
			bmps[7] = BitmapFactory.decodeResource(getResources(), R.raw.p8);
			bmps[8] = BitmapFactory.decodeResource(getResources(), R.raw.p9);
			bmps[9] = BitmapFactory.decodeResource(getResources(), R.raw.p10);
		}
		return new Animation(playDuration, x, y, bmps);
	}

	/**
	 * ��ʼ����Ч
	 */
	private void initSounds() {
		// ��ʼ����Ч�ء�SoundPool�ĸ������ֱ���ͬʱ�ɲ�����Ч������Ч���ͺ�����
		soundPool = new SoundPool(4, AudioManager.STREAM_MUSIC, 100);
		// ������Ч��Դ
		int soundId = soundPool.load(getContext(), R.raw.broken, 1);
		soundMap = new HashMap<Integer, Integer>();
		soundMap.put(SOUND_PT, soundId);
	}

	/**
	 * ����ָ������Ч
	 */
	public void playSound(int sound) {
		// ��ȡϵͳ��������
		AudioManager mgr = (AudioManager) getContext().getSystemService(
				Context.AUDIO_SERVICE);
		// ��ȡϵͳ��ǰ�������������ֵ
		float currVol = mgr.getStreamVolume(AudioManager.STREAM_MUSIC);
		float maxVol = mgr.getStreamMaxVolume(AudioManager.STREAM_MUSIC);
		float volume = currVol / maxVol;
		// ������Ч���ĸ���������Чid�����������������������������ȼ���ѭ�����ط�ֵ
		soundPool.play(sound, volume, volume, 1, 0, 1.0f);
	}

	@Override
	protected void onSizeChanged(int w, int h, int oldw, int oldh) {
		// ������Ļ��С����ʹ��͸߷�������Ҫ��
		screenW = (w > h) ? h : w;
		screenH = (w > h) ? w : h;
		// ----------------
		// ˮƽ����10p = screenW
		p = screenW / 10;
		// ���ر���ͼƬ�������յ�ǰ��Ļ��С����
		background = Bitmap.createScaledBitmap(BitmapFactory.decodeResource(
				getResources(), R.drawable.bg_main), screenW, screenH, false);
		gameover = Bitmap.createScaledBitmap(BitmapFactory.decodeResource(
				getResources(), R.drawable.gameover), 300, 300, false);
		starpic[0] = Bitmap
				.createScaledBitmap(BitmapFactory.decodeResource(
						getResources(), R.drawable.star_b), (int) p, (int) p,
						false);
		starpic[1] = Bitmap
				.createScaledBitmap(BitmapFactory.decodeResource(
						getResources(), R.drawable.star_g), (int) p, (int) p,
						false);
		starpic[2] = Bitmap
				.createScaledBitmap(BitmapFactory.decodeResource(
						getResources(), R.drawable.star_p), (int) p, (int) p,
						false);
		starpic[3] = Bitmap
				.createScaledBitmap(BitmapFactory.decodeResource(
						getResources(), R.drawable.star_r), (int) p, (int) p,
						false);
		starpic[4] = Bitmap
				.createScaledBitmap(BitmapFactory.decodeResource(
						getResources(), R.drawable.star_y), (int) p, (int) p,
						false);
		words = Bitmap.createScaledBitmap(BitmapFactory.decodeResource(
				getResources(), R.drawable.character), (int) (4.2 * p),
				(int) (2.5 * p), false);
		double ww = words.getWidth();
		double hh = words.getHeight() / 4;
		ui3 = Bitmap.createScaledBitmap(
				BitmapFactory.decodeResource(getResources(), R.drawable.ui3),
				(int) (5 * p), (int) hh, false);
		ui2 = Bitmap.createScaledBitmap(
				BitmapFactory.decodeResource(getResources(), R.drawable.ui2),
				(int) (3.2 * p), (int) hh, false);
		ui1 = Bitmap.createScaledBitmap(
				BitmapFactory.decodeResource(getResources(), R.drawable.ui1),
				(int) (1.1 * p), (int) hh, false);

		word1 = Bitmap.createBitmap(words, 0, 0, (int) ww, (int) hh);
		word2 = Bitmap.createBitmap(words, 0, (int) (hh), (int) (ww * 0.5),
				(int) hh);
		word3 = Bitmap.createBitmap(words, (int) (ww * 0.5), (int) (hh),
				(int) (ww * 0.5), (int) hh);

		super.onSizeChanged(w, h, oldw, oldh);
	}

	protected void drawCanvas(Canvas canvas) {
		// ���Ʊ���ͼ
		canvas.drawBitmap(background, 0, 0, null);
		canvas.drawBitmap(word1, 5, 70, null);
		canvas.drawBitmap(ui3, (int) (5 + 4 * p), 65, null);
		canvas.drawBitmap(word2, 10, (int) (70 + 0.6 * p), null);
		canvas.drawBitmap(ui1, (int) (10 + 2 * p), (int) (70 + 0.6 * p), null);
		canvas.drawBitmap(word3, (int) (20 + 3.2 * p), (int) (70 + 0.6 * p),
				null);
		canvas.drawBitmap(ui2, (int) (40 + 5.2 * p), (int) (70 + 0.6 * p), null);

	}

	@Override
	public boolean onTouchEvent(MotionEvent event) {
		// ��ȡ�����������ͺʹ���λ�õ�����
		int act = event.getAction();
		int x = (int) event.getX();
		int y = (int) event.getY();

		switch (act) {
		case MotionEvent.ACTION_DOWN:
			int col = (int) (x / p);
			int row = (int) ((y - (screenH - 10 * p)) / p);
			if (col >= 0 && row >= 0) {
				if (matrix[row][col] != 0) {// �жϵ��е��Ƿ�Ϊ0
					mark = matrix[row][col];

					list.add(new Node(row, col));
					List<Node> nodepoint = getRoundNode(list.get(0));
					if (nodepoint.size() > 0) { // ��������Ĵ�����ͬ�㣬��
						matrix[row][col] = 0;
						for (int i = 0; i < list.size(); i++) {
							List<Node> nodes = getRoundNode(list.get(i));

							for (int j = 0; j < nodes.size(); j++) {
								if (matrix[nodes.get(j).row][nodes.get(j).col] == mark) {
									matrix[nodes.get(j).row][nodes.get(j).col] = 0;
									if (!list.contains(nodes.get(j))) {
										list.add(nodes.get(j));
									}
								}
							}
						}
						sprites.add(makeAnimation(0.5F, (float) (x -1.2*p),
								(float) (y-1.2*p)));
						score = list.size() * list.size() * 5 + score;
						playSound(SOUND_PT);
					}
					list.clear();
					// ���Ӷ���Ч��
					sortStar();
					// invalidate();
					ifClear();
				}
			}
		}

		return super.onTouchEvent(event);
	}

	private List<Node> getRoundNode(Node sameNode) {// Ѱ�����������ĸ�����
		List<Node> nodes = new ArrayList<Node>();

		int col = sameNode.col;
		int row = sameNode.row;

		if ((row - 1) >= 0 && matrix[row - 1][col] == mark) {
			nodes.add(new Node(row - 1, col));// ��
		}

		if ((row + 1) <= 9 && matrix[row + 1][col] == mark) {
			nodes.add(new Node(row + 1, col));// ��
		}

		if ((col - 1) >= 0 && matrix[row][col - 1] == mark) {
			nodes.add(new Node(row, col - 1));// ��
		}

		if ((col + 1) <= 9 && matrix[row][col + 1] == mark) {
			nodes.add(new Node(row, col + 1));// ��
		}

		return nodes;
	}

	/**
	 * �ԸĶ�����������������
	 */
	private void sortStar() {
		for (int i = 0; i < 10; i++) {
			for (int j = 0; j < 10; j++) {
				if (matrix[i][j] == 0) {
					for (int k = i; k > 0; k--) {
						matrix[k][j] = matrix[k - 1][j];
					}
					matrix[0][j] = 0;
				}
			}
		}// 0���ϸ�����

		for (int i = 8; i >= 0; i--) {
			if (matrix[9][i] == 0) {
				for (int local = i; local <= 8; local++) {
					for (int j = 0; j < 10; j++) {
						matrix[j][local] = matrix[j][local + 1];
					}
				}
				for (int j = 0; j < 10; j++) {
					matrix[j][9] = 0;
				}
			}
		}// ������󿿽�����
	}

	/**
	 * �ж��Ƿ��Ѿ����������Ϸover
	 */
	private void ifClear() {
		int count = 0;

		for (int i = 0; i < 10; i++) {
			for (int j = 0; j < 10; j++) {
				boolean flag1 = false, flag2 = false, flag3 = false, flag4 = false;
				if (matrix[i][j] == 0) {
					count++;
				} else {
					if (i - 1 >= 0) {
						if (matrix[i - 1][j] != matrix[i][j]) {
							flag1 = true;
						}
					} else {
						flag1 = true;
					}
					if (i + 1 <= 9) {
						if (matrix[i + 1][j] != matrix[i][j]) {
							flag2 = true;
						}
					} else {
						flag2 = true;
					}
					if (j - 1 >= 0) {
						if (matrix[i][j - 1] != matrix[i][j]) {
							flag3 = true;
						}
					} else {
						flag3 = true;
					}
					if (j + 1 <= 9) {
						if (matrix[i][j + 1] != matrix[i][j]) {
							flag4 = true;
						}
					} else {
						flag4 = true;
					}
					if (flag1 == true && flag2 == true && flag3 == true
							&& flag4 == true) {
						count++;
					}
				}
			}
		}
		if (count == 100) {

			if (score >= asking) {
				for (int i = 0; i < 10; i++) {
					for (int j = 0; j < 10; j++) {
						matrix[i][j] = 1 + (int) (Math.random() * 5);
					}
				}

				rank++;
				asking = ((rank + 1) % 2 + 1) * 1000 + asking;
			} else {
				game = false;
			}

		}
	}

	@Override
	public void surfaceChanged(SurfaceHolder holder, int format, int width,
			int height) {
		// TODO Auto-generated method stub

	}

	@Override
	public void surfaceCreated(SurfaceHolder holder) {
		// ��������ˢ���߳�
		Thread render = new Thread(new GameRender());
		finished = false;
		render.start();
	}

	@Override
	public void surfaceDestroyed(SurfaceHolder holder) {
		// ֪ͨ����ˢ���߳���ֹ�˳�
		finished = true;

	}

	/**
	 * �ڲ���GameRender������ˢ����Ϸ����
	 */
	private class GameRender implements Runnable {

		@Override
		public void run() {
			long tick0, tick1;
			float deltaTime;
			List<Animation> stoppedAnims = new ArrayList<Animation>();
			Animation sprite;

			while (!finished) {
				// ��ȡ����ˢ�´���ִ��֮ǰ��ʱ�䣬��λ����
				tick0 = System.currentTimeMillis();

				// ˢ����Ϸ����
				try {
					// ��������
					Canvas canvas = holder.lockCanvas(null);
					if (canvas != null) {
						drawCanvas(canvas);
						canvas.drawText(asking + "", (int) (6 * p), 90, p_text);
						canvas.drawText(score + "", (int) (90 + 5.2 * p),
								(int) (95 + 0.6 * p), p_text);
						canvas.drawText(rank + "", (int) (25 + 2 * p),
								(int) (95 + 0.6 * p), p_text);

						for (int i = 0; i < 10; i++) {
							for (int j = 0; j < 10; j++) {
								if (matrix[i][j] != 0) {
									canvas.drawBitmap(
											starpic[matrix[i][j] - 1],
											(float) (j * p), (float) (screenH
													- 10 * p + i * p), paint);
								}
							}
						}
						if (!game) {
							canvas.drawBitmap(gameover, 90, 300, paint);
						}
						// ==================================
						// ���ƶ���֡
						stoppedAnims.clear();
						// ע�����ﲻ��ʹ��for-eachѭ������Ϊѭ�������п��ܻ��д����¼���������̬�����Ԫ�ظ������
						for (int i = 0; i < sprites.size(); i++) {
							sprite = sprites.get(i);
							sprite.draw(stateTime, canvas);
							// ���ĳ�������󲥷��꣬�������ɾ������
							if (sprite.isStopped()) {
								stoppedAnims.add(sprite);
							}
						}
						sprites.removeAll(stoppedAnims);
						// =======================================
						// ��ȡ����ˢ�´���ִ��֮���ʱ�䣬��λ����
						tick1 = System.currentTimeMillis();
						// �����ͼ����ʱ��(��)��ȷ��֡�ʲ�����60
						deltaTime = (tick1 - tick0) / 1000F;
						if (deltaTime < FRAME_TIME) {
							Thread.sleep((long) (1000 * (FRAME_TIME - deltaTime)));
							deltaTime = FRAME_TIME;
						}
						// �����������Ա㻭������Ļ����ʾ
						holder.unlockCanvasAndPost(canvas);

						// ������Ϸ���е��ۻ�ʱ��
						tick1 = System.currentTimeMillis();
						stateTime = stateTime + (tick1 - tick0) / 1000F;
					}
				} catch (Exception e2) {

				}
			} // of while
		}// of run()
	}// of class GameRender

}
