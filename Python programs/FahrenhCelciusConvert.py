import sys
from PyQt5 import QtWidgets, uic

form_class = uic.loadUiType("MyFirstGui1.ui")[0]

class TemperatureConverterWindow(QtWidgets.QMainWindow, form_class):
    def __init__(self, parent=None):
        QtWidgets.QMainWindow.__init__(self,parent)
        self.setupUi(self)
        self.btnCtoF.clicked.connect(self.btnCtoF_clicked)
        self.btnFtoC.clicked.connect(self.btnFtoC_clicked)
        self.actionCelsius_to_Fahrenheit.triggered.connect(self.btnCtoF_clicked)
        self.actionFahrenheit_to_Celsius.triggered.connect(self.btnFtoC_clicked)
        self.actionExit.triggered.connect(self.menuExit_selected)

    def btnCtoF_clicked(self):
        cel = float(self.editCel.text())
        fahr = cel * 9 / 5 + 32
        fahr_text = '%.2f' % fahr
        self.spinFahr.setText(fahr_text)
        print('cel = ', cel, '  fahr = ', fahr)

    def btnFtoC_clicked(self):
        fahr = float(self.spinFahr.text())
        cel = (fahr - 32) * 5 / 9
        cel_text = '%.2f' % cel
        self.editCel.setText(cel_text)
        print('fahr = ', fahr, '   cel = ', cel)

    def menuExit_selected(self):
        self.close()

app = QtWidgets.QApplication(sys.argv)
myWindow = TemperatureConverterWindow(None)
myWindow.show()
app.exec_()


