/*******************************************************************************
 * Copyright 2011 See AUTHORS file.
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 ******************************************************************************/

package com.example.popstar;

import android.graphics.Bitmap;
import android.graphics.Canvas;


public class Animation {
	final Bitmap[] keyFrames; // 动画图像帧
	final float frameDuration; // 每帧图像显示的时间
	final float playDuration; // 播放整个动画所花时间
	float tick0; // 动画播放开始的时钟节拍
	boolean stopped;
	float x, y; //动画播放的位置

	public boolean isStopped() {
		return stopped;
	}

	/**
	 * @param frameDuration 动画播放的持续时间，单位为秒
	 * @param x 动画播放的位置
	 * @param y
	 * @param keyFrames 帧图像
	 */
	public Animation (float playDuration, float x, float y, Bitmap... keyFrames) {
		this.playDuration = playDuration;
		this.keyFrames = keyFrames;
		this.stopped = false;
		this.frameDuration = playDuration / keyFrames.length;
		this.x = x;
		this.y = y;

		tick0 = -1F;
	}

	/**
	 * 根据游戏运行的时间获取动画关键帧
	 * @param stateTime 游戏从开始运行的累积时间，可以理解为时间轴，单位为秒
	 * @param looping 是否需要重复播放动画
	 * @return
	 */
	public Bitmap getKeyFrame (float stateTime, boolean looping) {
		// 记录动画播放的起始时间戳
		if (tick0 == -1F) {
			tick0 = stateTime;
		}
		
		// 根据经历的时间，获取某个图像帧
		int frameNumber = (int)((stateTime - tick0) / frameDuration);

		if (!looping) {
			frameNumber = Math.min(keyFrames.length - 1, frameNumber);
			if (stateTime - tick0 >= playDuration) {
				stopped = true;
			}
		} else {
			frameNumber = frameNumber % keyFrames.length;
		}
		
		return keyFrames[frameNumber];
	}
	
	public void draw(float stateTime, Canvas canvas) {
		Bitmap bmp = getKeyFrame(stateTime, false);
		canvas.drawBitmap(bmp, x, y, null);
	}
}
