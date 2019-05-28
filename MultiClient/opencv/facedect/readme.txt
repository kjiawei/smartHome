 time:
Processing 4m
In image read
detection time = 6137.38 ms

30k
detection time = 97.9046 ms



CMake Error at /local/sdb/job10/opencv/opencv-2.4.9/cmake/cl2cpp.cmake:50 (string):
 string does not recognize sub-command MD5
 #string(MD5 hash "${lines}")
 make error

http://www.rosoo.net/a/list_47_1.html

OpenCV 2 Computer Vision Application Programming Cookbook


sudo apt-get install cmake
sudo apt-get install libcppunit-dev
apt-get install build-essential
sudo apt-get install cmake-curses-gui (ccmake)



cd ../opencv/
cmake .  (构建Makefile)

make
make check
make install



./facedetect: error while loading shared libraries: libopencv_calib3d.so.2.4: cannot open shared object file: No such file or directory
sudo ldconfig  ()

If you are on Ubuntu or Debian, install libgtk2.0-dev and pkg-config, then re-run cmake or configure script in function cvNamedWindow
! cd opencv  root dir 
* cmake ./
* make
* make install

!!!!!!!!!!!! use this is best
./facedetect --cascade="../../data/haarcascades/haarcascade_frontalface_alt.xml" --nested-cascade="../../data/haarcascades/haarcascade_mcs_mouth.xml" --scale=1.0 ./liu.jpg 

sudo  apt-get install libgtk2.0-dev

rebuild :
./build_all.sh 



./facedetect  --cascade="../../data/haarcascades/haarcascade_frontalface_alt.xml" --scale=1.5 ./lena.jpg

./facedetect: error while loading shared libraries: libopencv_objdetect.so.2.4: cannot open shared object file: No such file or directory



/////////////////////////////////////////////////

#include "opencv2/core/core.hpp"

#include "opencv2/highgui/highgui.hpp"

#include <stdio.h>

using namespace cv;

int main( int argc, char** argv ){
    Mat image;
    image = imread( argv[1]);

    if( argc != 2 || !image.data ){
        printf("没有图片\n");
        return -1;
    }

    namedWindow( "显示图片", CV_WINDOW_AUTOSIZE );
    imshow( "显示图片", image );
    waitKey(0);

    return 0;
}
新建一个CMakeLists.txt，内容大概是这样的：

project( DisplayImage )
find_package( OpenCV REQUIRED )
add_executable( DisplayImage DisplayImage )
target_link_libraries( DisplayImage ${OpenCV_LIBS} ) 

生成可执行文件

cd <DisplayImage_directory>
cmake .
make

./DisplayImage lena.jpg



例程测试 
--------------------------------------------------------------------------------

拷贝步骤2中解压的的/OpenCV-2.4.3/samples/c 将c文件夹拷贝出来，下面运行一下这里面的一个例程，初步体验下OpenCV。拷贝完成后进入这个文件夹：

chmod +x build_all.sh

./build_all.sh

这样就对例程目录下的源文件进行了编译，这里运行一个人脸检测的程序，下面摘录自本文参考资料3。

Some of the training data for object detection is stored in /usr/local/share/opencv/haarcascades. You need to tell OpenCV which training data to use. I will use one of the frontal face detectors available. Let’s find a face:

终端中运行：


./facedetect --cascade="/usr/local/share/OpenCV/haarcascades/haarcascade_frontalface_alt.xml" --scale=1.5 lena.jpg
得到的结果如下图：


ldconfig 使修改后的配置生效 


opencv :

1  AT&T Facedatabase 

If you are on Ubuntu or Debian, install libgtk2.0-dev and pkg-config,


1、Face detection 人脸识别，即识别出这是人的脸，而不管他是谁的。

2、Face preprocessing 面部预处理，即提取出脸部图像。

3、Collect and learn faces 脸部的特征采集和学习

4、Face recognition 脸部识别，找出最相近的相近脸部图像。


人脸检测算法的可靠性很大程度上依赖于分类器的设计，
在2001年，Viola和Jones两位大牛发表了经典的《Rapid Object Detection using a Boosted Cascade of Simple Features》
【1】和《Robust Real-Time Face Detection》
【2】，在AdaBoost算法的基础上，使用Haar-like小波特征和积分图方法进行人脸检测，
他俩不是最早使用提出小波特征的，但是他们设计了针对人脸检测更有效的特征，
并对AdaBoost训练出的强分类器进行级联。这可以说是人脸检测史上里程碑式的一笔了，
也因此当时提出的这个算法被称为Viola-Jones检测器。
又过了一段时间，Rainer Lienhart和Jochen Maydt两位大牛将这个检测器进行了扩展【3】，
最终形成了OpenCV现在的Haar分类器。在OpenCV2.0中又扩充了基于LBP特征的人脸检测器，
某些情况下LBP特征比Haar来的更为快速。







 



