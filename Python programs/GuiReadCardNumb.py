# програмка принимает неразделенный 16 цифровой номер карточки
# и делает его удобным для чтения (большим и разделенным по четыре цифры)

import sys
from PyQt5 import QtWidgets, uic

form_class = uic.loadUiType("Gui1.ui")[0]

class ReadCardNumberWindow(QtWidgets.QMainWindow, form_class):
    def __init__(self, parent=None):
        QtWidgets.QMainWindow.__init__(self,parent)
        self.setupUi(self)
        self.btnTransform.clicked.connect(self.transformInput)
        
    def transformInput(self):
        x = self.lineEdit.text()
        y = (x[:4] + "  " + x[4:8] + "  " + x[8:12] + "  " + x[12:16])
        self.textBrowser.setText(y)


app = QtWidgets.QApplication(sys.argv)
myWindow = ReadCardNumberWindow(None)
myWindow.show()
app.exec_()

