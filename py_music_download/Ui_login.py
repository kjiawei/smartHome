# -*- coding: utf-8 -*-

# Form implementation generated from reading ui file 'E:\python\PyQt\music_download\login.ui'
#
# Created by: PyQt5 UI code generator 5.11.2
#
# WARNING! All changes made in this file will be lost!

from PyQt5 import QtCore, QtGui, QtWidgets

class Ui_Dialog(object):
    def setupUi(self, Dialog):
        Dialog.setObjectName("Dialog")
        Dialog.resize(1063, 733)
        Dialog.setSizeGripEnabled(True)
        self.startSearch = QtWidgets.QPushButton(Dialog)
        self.startSearch.setGeometry(QtCore.QRect(160, 70, 75, 23))
        self.startSearch.setObjectName("startSearch")
        self.searchName = QtWidgets.QLineEdit(Dialog)
        self.searchName.setGeometry(QtCore.QRect(10, 70, 121, 21))
        self.searchName.setObjectName("searchName")
        self.musicName = QtWidgets.QLabel(Dialog)
        self.musicName.setGeometry(QtCore.QRect(30, 50, 51, 16))
        self.musicName.setObjectName("musicName")
        self.musicName_2 = QtWidgets.QLabel(Dialog)
        self.musicName_2.setGeometry(QtCore.QRect(30, 100, 51, 16))
        self.musicName_2.setObjectName("musicName_2")
        self.musicList = QtWidgets.QListView(Dialog)
        self.musicList.setGeometry(QtCore.QRect(10, 130, 551, 581))
        self.musicList.setObjectName("musicList")
        self.resultNum = QtWidgets.QLineEdit(Dialog)
        self.resultNum.setGeometry(QtCore.QRect(400, 100, 71, 21))
        self.resultNum.setObjectName("resultNum")
        self.musicName_3 = QtWidgets.QLabel(Dialog)
        self.musicName_3.setGeometry(QtCore.QRect(330, 100, 51, 16))
        self.musicName_3.setObjectName("musicName_3")
        self.startDownload = QtWidgets.QPushButton(Dialog)
        self.startDownload.setGeometry(QtCore.QRect(480, 100, 75, 23))
        self.startDownload.setObjectName("startDownload")
        self.musicName_4 = QtWidgets.QLabel(Dialog)
        self.musicName_4.setGeometry(QtCore.QRect(260, 50, 51, 16))
        self.musicName_4.setObjectName("musicName_4")
        self.chooseDirectoryPath = QtWidgets.QLineEdit(Dialog)
        self.chooseDirectoryPath.setGeometry(QtCore.QRect(260, 70, 211, 21))
        self.chooseDirectoryPath.setObjectName("chooseDirectoryPath")
        self.chooseDirectory = QtWidgets.QPushButton(Dialog)
        self.chooseDirectory.setGeometry(QtCore.QRect(480, 70, 75, 23))
        self.chooseDirectory.setObjectName("chooseDirectory")

        self.retranslateUi(Dialog)
        QtCore.QMetaObject.connectSlotsByName(Dialog)

    def retranslateUi(self, Dialog):
        _translate = QtCore.QCoreApplication.translate
        Dialog.setWindowTitle(_translate("Dialog", "Dialog"))
        self.startSearch.setText(_translate("Dialog", "开始搜索"))
        self.musicName.setText(_translate("Dialog", "歌曲名称"))
        self.musicName_2.setText(_translate("Dialog", "搜索结果"))
        self.musicName_3.setText(_translate("Dialog", "下载编号"))
        self.startDownload.setText(_translate("Dialog", "开始下载"))
        self.musicName_4.setText(_translate("Dialog", "下载路径"))
        self.chooseDirectory.setText(_translate("Dialog", "选择"))


if __name__ == "__main__":
    import sys
    app = QtWidgets.QApplication(sys.argv)
    Dialog = QtWidgets.QDialog()
    ui = Ui_Dialog()
    ui.setupUi(Dialog)
    Dialog.show()
    sys.exit(app.exec_())

