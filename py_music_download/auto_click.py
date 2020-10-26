#!/usr/bin/env python
#-*- coding:UTF-8 -*-

'''
丰石公司用于自动浏览网页产生访问数据脚本
2020.10.26

linux deepin
chromedriver --version:84.0.4147.30 (48b3e868b4cc0aa7e8149519690b6f6949e110a8-refs/branch-heads/4147@{#310})
'''

from selenium import webdriver
from time import sleep

from selenium.webdriver.firefox.firefox_binary import FirefoxBinary
from selenium.webdriver.firefox.options import Options
import random

###Chrome
op = webdriver.ChromeOptions()
#op.add_argument('--headless')
op.add_argument('--no-sandbox')
op.add_argument('--disable-dev-shm-usage')
#op.add_argument('blink-settings=imagesEnabled=false')
#op.add_argument('--disable-gpu')
# 后面是你的浏览器驱动位置，记得前面加r'','r'是防止字符转义的
driver = webdriver.Chrome(r'/usr/local/bin/chromedriver',chrome_options=op)
#driver = webdriver.Chrome(r'/usr/local/bin/chromedriver')

#Firefox
# binary = FirefoxBinary('/opt/firefox/firefox')
# # fire_op = webdriver.FirefoxOptions()
# # fire_op.add_argument('--headless')
# fire_op = Options()
# fire_op.add_argument('-headless')
# driver = webdriver.Firefox(firefox_binary=binary,executable_path='/usr/local/bin/geckodriver',firefox_options=fire_op)

#driver.implicitly_wait(1)

#操作公司内部hadoop集群
'''
count =0
while (count<1):
    print ("start random")
    i = random.randint(0,9)
    #driver.get("http://172.16.55.139:8888/about/")
    #driver.get("http://172.16.55.139:8088/cluster")
    driver.get("http://192.168.108.163:8088/cluster") #公司内部hadoop集群页
    # 查找页面的“设置”选项，并进行点击
    ems = ["Applications","NEW","NEW_SAVING","SUBMITTED","ACCEPTED","RUNNING","FINISHED","FAILED","KILLED","Scheduler"]
    for i in range(len(ems)):
        driver.find_elements_by_link_text(ems[i])[0].click()
        sleep(1)

    driver.get("http://192.168.108.163:50070") #hadoop overview页 用get打开
    emss = ["Overview","Datanodes","Datanode Volume Failures","Snapshot","Startup Progress"]
    # print len(emss)
    for j in range(len(emss)):
        driver.find_elements_by_link_text(emss[j])[0].click()
        sleep(1)
    sleep(2)
''' 

# driver.find_elements_by_link_text('查询编辑器')[0].click()
# driver.find_elements_by_link_text('我的查询')[0].click()
# driver.find_element_by_id('u').clear()
# driver.find_element_by_id('id_username').send_keys('training')  # 这里填写你的QQ号
# # driver.find_element_by_id('p').clear()
# driver.find_element_by_id('id_password').send_keys('training')  # 这里填写你的QQ密码
# driver.find_element_by_class_name('btn-large btn-primary')[0].click()
#driver.find_element_by_id('login_button').click()


# sleep(2)
# # # 打开设置后找到“搜索设置”选项，设置为每页显示50条
# driver.find_elements_by_link_text('搜索设置')[0].click()
# sleep(2)
#
# # 选中每页显示50条
# m = driver.find_element_by_id('nr')
# sleep(2)
# m.find_element_by_xpath('//*[@id="nr"]/option[3]').click()
# m.find_element_by_xpath('.//option[3]').click()
# sleep(2)
#
# # 点击保存设置
# driver.find_elements_by_class_name("prefpanelgo")[0].click()
# sleep(2)
#
# # 处理弹出的警告页面   确定accept() 和 取消dismiss()
# driver.switch_to_alert().accept()
# sleep(2)

#访问百度 输入框内搜索浏览图片
driver.get("http://www.baidu.com")
site='美女'
s1 = unicode(site, 'utf-8')
#find_element_by_xpath
driver.find_element_by_id('kw').send_keys(s1)
driver.find_element_by_id('su').click() #点击搜索按钮
handle = driver.current_window_handle
sleep(2)

for i in range(3):
    driver.find_elements_by_link_text('美女_海量精选高清图片_百度图片')[0].click()
# 获取当前所有窗口句柄（窗口A、B）
    handles = driver.window_handles

# 对窗口进行遍历
    for newhandle in handles:
        if newhandle!=handle:# 筛选新打开的窗口B
# 切换到新打开的窗口B
            driver.switch_to_window(newhandle)
# 在新打开的窗口B中操作
        #driver.find_element_by_id('xx').click()
# 关闭当前窗口B
            sleep(5)
            driver.close()
#切换回窗口A
            driver.switch_to_window(handles[0]) 
            sleep(2)

sleep(2)
driver.quit() #关闭浏览器
'''
site2='nba'
s2 = unicode(site2, 'utf-8')
driver.find_element_by_id('kw').send_keys(s2)
sleep(2)
# # 点击搜索按钮
driver.find_element_by_id('su').click()
sleep(2)
# # 在打开的页面中找到“Selenium - 开源中国社区”，并打开这个页面
driver.find_elements_by_link_text('美女_海量精选高清图片_百度图片')[0].click()
sleep(5)
'''

# # 定位到table，并获得table中所有得tr元素
# menu_table = driver.find_element_by_xpath("//div id ='nav'")
# rows = menu_table.find_elements_by_tag_name('li')
# # python 得len()函数返回对象（字符、列表、元组）得长度或者元素得个数
# before_add_numbers = len(rows)
# print(before_add_numbers)

# driver.switch_to.frame('login_frame')  # login_frame 是ID值
# driver.find_element_by_id('switcher_plogin').click()
