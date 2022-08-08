# юзер вводит четыре символа и получает их в обратном порядке в графическом интерфейсе
# почему-то не получилось сделать это через цикл while, пришлось захардкодить

import sys
from PyQt5 import QtWidgets, uic

form_class = uic.loadUiType("Gui1.ui")[0]

class SymbolsViceVersaWindow(QtWidgets.QMainWindow, form_class):
    def __init__(self, parent=None):
        QtWidgets.QMainWindow.__init__(self,parent)
        self.setupUi(self)
        self.btnTransform.clicked.connect(self.transformInput)
        
    def transformInput(self):
      list = []
      ele = self.lineEdit.text()
      for x in ele:
        list.append(x)
      self.textBrowser.setText(list[3] + list[2] + list[1] + list[0])
      
app = QtWidgets.QApplication(sys.argv)
myWindow = SymbolsViceVersaWindow(None)
myWindow.show()
app.exec_()