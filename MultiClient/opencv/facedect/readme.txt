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
cmake .  (����Makefile)

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
        printf("û��ͼƬ\n");
        return -1;
    }

    namedWindow( "��ʾͼƬ", CV_WINDOW_AUTOSIZE );
    imshow( "��ʾͼƬ", image );
    waitKey(0);

    return 0;
}
�½�һ��CMakeLists.txt�����ݴ���������ģ�

project( DisplayImage )
find_package( OpenCV REQUIRED )
add_executable( DisplayImage DisplayImage )
target_link_libraries( DisplayImage ${OpenCV_LIBS} ) 

���ɿ�ִ���ļ�

cd <DisplayImage_directory>
cmake .
make

./DisplayImage lena.jpg



���̲��� 
--------------------------------------------------------------------------------

��������2�н�ѹ�ĵ�/OpenCV-2.4.3/samples/c ��c�ļ��п�����������������һ���������һ�����̣�����������OpenCV��������ɺ��������ļ��У�

chmod +x build_all.sh

./build_all.sh

�����Ͷ�����Ŀ¼�µ�Դ�ļ������˱��룬��������һ���������ĳ�������ժ¼�Ա��Ĳο�����3��

Some of the training data for object detection is stored in /usr/local/share/opencv/haarcascades. You need to tell OpenCV which training data to use. I will use one of the frontal face detectors available. Let��s find a face:

�ն������У�


./facedetect --cascade="/usr/local/share/OpenCV/haarcascades/haarcascade_frontalface_alt.xml" --scale=1.5 lena.jpg
�õ��Ľ������ͼ��


ldconfig ʹ�޸ĺ��������Ч 


opencv :

1  AT&T Facedatabase 

If you are on Ubuntu or Debian, install libgtk2.0-dev and pkg-config,


1��Face detection ����ʶ�𣬼�ʶ��������˵���������������˭�ġ�

2��Face preprocessing �沿Ԥ��������ȡ������ͼ��

3��Collect and learn faces �����������ɼ���ѧϰ

4��Face recognition ����ʶ���ҳ���������������ͼ��


��������㷨�Ŀɿ��Ժܴ�̶��������ڷ���������ƣ�
��2001�꣬Viola��Jones��λ��ţ�����˾���ġ�Rapid Object Detection using a Boosted Cascade of Simple Features��
��1���͡�Robust Real-Time Face Detection��
��2������AdaBoost�㷨�Ļ����ϣ�ʹ��Haar-likeС�������ͻ���ͼ��������������⣬
������������ʹ�����С�������ģ���������������������������Ч��������
����AdaBoostѵ������ǿ���������м����������˵���������ʷ����̱�ʽ��һ���ˣ�
Ҳ��˵�ʱ���������㷨����ΪViola-Jones�������
�ֹ���һ��ʱ�䣬Rainer Lienhart��Jochen Maydt��λ��ţ������������������չ��3����
�����γ���OpenCV���ڵ�Haar����������OpenCV2.0���������˻���LBP�����������������
ĳЩ�����LBP������Haar���ĸ�Ϊ���١�







 



