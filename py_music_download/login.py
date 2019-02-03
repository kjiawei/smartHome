# -*- coding: utf-8 -*-

"""
Module implementing Login.
Update Log:
8.15 多行下载,需要修改
间隔一段时间可不重启软件进行下载
"""
from selenium import webdriver
from bs4 import BeautifulSoup
import urllib.request
from selenium.webdriver.common.action_chains import ActionChains
#https://www.cnblogs.com/wulisz/p/7640468.html

import sqlite3
import sys
import os

#Selenium WebDriver的使用  https://www.cnblogs.com/sammyzhang/p/5280416.html
#from pyvirtualdisplay import Display #为了验证firefox加进来
#微盘下载思路 https://blog.csdn.net/jclian91/article/details/77113594
#缓存下载队列

from PyQt5.QtCore import *
from PyQt5.QtGui import *
from PyQt5.QtWidgets import *
from PyQt5.QtSql import QSqlDatabase , QSqlQuery
from Ui_login import Ui_Dialog #Ui前面有个.被去掉,eric 6的一个bug!!!

def createDB():
    global searchHistoryDb
    # 添加数据库
    searchHistoryDb =  QSqlDatabase.addDatabase('QSQLITE')
	# 设置数据库名称
    searchHistoryDb.setDatabaseName('./searchHistory.db')
	# 判断是否打开
    if not searchHistoryDb.open():
        QMessageBox.critical(None,  ("Cannot open database"),
        ("Unable to establish a database connection. \n"
        "This example needs SQLite support. Please read "
        "the Qt SQL driver documentation for information "
        "how to build it.\n\n"
        "Click Cancel to exit."),
        QMessageBox.Cancel)
        return False
		
	# 声明数据库查询对象
        query = QSqlQuery()
	# 创建表
        query.exec("create table musicLike(id int primary key,name vchar, createdTime TimeStamp NOT NULL DEFAULT (datetime('now', 'localtime')))")#name vchar, sex vchar, age int, deparment vchar
	#添加记录
        #,datetime                #(datetime('now','localtime')) 
        return True

class Login(QDialog, Ui_Dialog):
    """
    Class documentation goes here.
    """
    global directory1
    global directory2
    directory1 = 'E:/python_music'
    directory2 = 'E:/python_music'
	
    def __init__(self, parent=None):
        """
        Constructor

        @param parent reference to the parent widget
        @type QWidget
        """
        super(Login, self).__init__(parent)
        self.setupUi(self)

        self.searchName.setPlaceholderText("请输入音乐名或歌手名")
        self.searchName.setAlignment( Qt.AlignCenter )

        self.resultNum.setPlaceholderText("音乐编号")
        self.resultNum.setAlignment( Qt.AlignCenter )
        global directory1
        self.chooseDirectoryPath.setText(directory1)
        self.chooseDirectoryPath.setReadOnly(True)
        self.resultNum.setValidator(QIntValidator())
        self.setWindowTitle("音乐免费下载器")
		
        self.pbar = QProgressBar(self)
        self.pbar.setGeometry(100, 95, 200, 25)
        self.timer = QBasicTimer()
        self.step = 0
        self.startDownload.setEnabled(False)
        pc_chromedriver_path = "C:/Users/keji01/AppData/Local/Google/Chrome/Application/chromedriver.exe" #"E:/python/geckodriver.exe"#“
        chromedriver = pc_chromedriver_path
        global browser 
        browser= webdriver.Chrome(chromedriver)#代码创建时要写目录-客户机自动搜寻对应路径或使用网络的
        #
		#browser = Display(visible=0, size=(1920, 1080))
        #browser.start()
        #browser= webdriver.Firefox()    #
        #browser= webdriver.Ie()  #IE驱动可能要系统设置和注册表
		#edge浏览器 https://blog.csdn.net/qq_29720415/article/details/53521746

    def timerEvent(self, event):
        if self.step >=100:
            self.timer.stop()
            return
        self.step = self.step + 1
        self.pbar.setValue(self.step)
		
    @pyqtSlot()
    def on_startSearch_clicked(self):#把搜索历史添加到数据库 加一个正在操作的进度条
        #self.timer.start(10, self)
		#隐藏掉网页或关闭上一个页面
        if self.timer.isActive(): 
            self.timer.stop()
        else:
            self.timer.start(10, self)

        
        musicName = self.searchName.text()
        '''
        query = QSqlQuery("",searchHistoryDb)
        query= 'insert into student values (?,?,?)'
        query.prepare(query)
        query.addBindValue(2)
        query.addBindValue(musicName)
        query.addBindValue(datetime())
        if not query.exec_():
            print(query.lastError())
        else:
            print('inserted')
        #QString queryStr;
		
		'''
        '''
		queryStr.append("INSERT INTO ")
        .append(DBTABLE_RECORD)
        .append("(time, type, isEffect)")
        .append(" values('")
        .append(QString::number(record.time))
        .append("', '")
        .append(QString::number(record.type))
		.append("', '")
        .append(QString::number(record.isEffect))
        .append("')");
    return query.exec(queryStr);
	
        query.exec("insert into musicLike values(1,'test',datetime())")
		'''
        self.startDownload.setEnabled(True)
        #global browser
        browser.get('http://www.kugou.com/')
        #browser.manage().window().minimize()
        a = browser.find_element_by_xpath(# 酷狗音乐路径结构
        '/html/body/div[1]/div[1]/div[1]/div[1]/input'
        )
        a.send_keys(musicName)
        browser.find_element_by_xpath(
        '/html/body/div[1]/div[1]/div[1]/div[1]/div/i').click(
        )
        for handle in browser.window_handles:  # 方法二，始终获得当前最后的窗口，所以多要多次使用
            browser.switch_to_window(handle)#browser.window_handles[0]
            
        #输出返回结果
        musicStringList = QStringListModel();
        soup = BeautifulSoup(browser.page_source, 'lxml')#获取页面源码
        PageAll = len(soup.select('ul.list_content.clearfix > li'))#
        print(PageAll)
        ml = []
        for i in range(1, PageAll + 1):#为什么只显示30首
            j = browser.find_element_by_xpath('/html/body/div[4]/div[1]/div[2]/ul[2]/li[%d]/div[1]/a' % i).get_attribute('title')
            ml.append(str(i)+j)
        print('%d.' % i + j)
        
        musicStringList.setStringList(ml)
        self.musicList.setModel(musicStringList)
        #self.musicList.setEditTriggers(QAbstractItemView::NoEditTriggers)
        self.musicList.clicked.connect(self.clicked)
        if self.searchName.text() != musicName:
            browser.quit()
			
    def clicked(self, qModelIndex):
        self.resultNum.setText(str(qModelIndex.row()+1))

    @pyqtSlot()
    def on_startDownload_clicked(self):
        if self.searchName.text() == musicName:
            self.startSearch.click()
			
        if self.resultNum.text()=='':
            QMessageBox.information(self, "QListView", "请输入歌曲编号!")#QToast
        else:
            choice = self.resultNum.text()
            #global browser
            a = browser.find_element_by_xpath('/html/body/div[4]/div[1]/div[2]/ul[2]/li[%s]/div[1]/a' % choice)  # 定位
            b = browser.find_element_by_xpath('/html/body/div[4]/div[1]/div[2]/ul[2]/li[%s]/div[1]/a' % choice).get_attribute('title')

            actions = ActionChains(browser)  # selenium中定义的一个类 动作链
            actions.move_to_element(a)  # 将鼠标移动到指定位置
            actions.click(a)  # 点击
            actions.perform()

            for handle in browser.window_handles:  # 方法二，始终获得当前最后的窗口，所以多要多次使用
                browser.switch_to_window(handle) #窗口操作参考:https://www.cnblogs.com/wulisz/p/7640468.html

            Local = browser.find_element_by_xpath('//*[@id="myAudio"]').get_attribute('src')
		
            def cbk(a, b, c):
                per = 100.0 * a * b / c
                if per > 100:
                    per = 100
		
            soup = BeautifulSoup(b)
            name = soup.get_text()
            global directory2
            path = directory2+'\%s.mp3' % name
            urllib.request.urlretrieve(Local, path, cbk)
            #QMessageBox.information(self, "下载结果", "下载成功")#换成有按键处理的来刷新下载按钮
            #文件IO
            self.startDownload.setEnabled(False)#页面刷出逻辑移到单独函数 执行流程
            #browser.quit() #搜索与上次结果不同或新下载开始了才执行这句
			#self.startSearch.setEnabled(False)
            #多次下载

    @pyqtSlot()
    def on_chooseDirectory_clicked(self):
        global directory1
	global directory2
        directory2 = QFileDialog.getExistingDirectory(self,"选取下载目录",directory1)#起始路径
	if(directory2==""):
	    directory2=directory1
		
        self.chooseDirectoryPath.setText(directory2)
		
    @pyqtSlot()
    def on_selectMusicList_clicked(self):
        file,ok= QFileDialog.getOpenFileName(self,"打开","C:/","All Files (*);;Text Files (*.txt)") 
        #raise NotImplementedError
    
    @pyqtSlot()
    def on_outPutMusicList_clicked(self):
        directory2 = QFileDialog.getExistingDirectory(self,"选取文件夹","C:/")  # 起始路径

if __name__ == '__main__':
    import sys
    from PyQt5.QtWidgets import QApplication
    
    app = QApplication(sys.argv)
    createDB()
    dlg = Login()
    dlg.show()
    sys.exit(app.exec_())
