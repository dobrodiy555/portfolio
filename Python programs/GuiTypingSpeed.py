# пока что програмка не засекает время, т.е. это не на скорость, а на внимательность
# нужно добавить еще одну кнопку и функцию которая будет засекать время, а потом передавать это значение для расчетов


import sys
from PyQt5 import QtWidgets, uic
import time, datetime, random

form_class = uic.loadUiType("forTypeSpeed.ui")[0]

messages = ["Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet. Dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation.", 
"Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Eget nullam non nisi est. Fermentum posuere urna nec tincidunt praesent semper. Arcu bibendum at varius vel pharetra vel turpis nunc.",
"Mauris rhoncus aenean vel elit scelerisque mauris pellentesque. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Augue lacus viverra vitae congue eu. Est usus legentis in iis qui facit eorum claritatem.",
"Aliquam id diam maecenas ultricies mi eget mauris pharetra et. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim.",
"Qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam.",
"Phasellus imperdiet, nulla et dictum interdum, nisi lorem egestas odio, vitae scelerisque enim ligula venenatis dolor. Maecenas nisl est, ultrices nec congue eget, auctor vitae massa. Fusce luctus vestibulum augue ut aliquet.",
"Mauris ante ligula, facilisis sed ornare eu, lobortis in odio. Praesent convallis urna a lacus interdum ut hendrerit risus congue. Nunc sagittis dictum nisi, sed ullamcorper ipsum dignissim ac ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat."]

message = random.choice(messages)

class TypingSpeedWindow(QtWidgets.QMainWindow, form_class):
    def __init__(self, parent=None):
        QtWidgets.QMainWindow.__init__(self, parent)
        self.setupUi(self)
        self.startButton.clicked.connect(self.showText)
        self.checkButton.clicked.connect(self.calculateResult)


    def showText(self):
        # message = random.choice(messages)
        self.placeForText.setText(message)

    def calculateResult(self):
        start_time = datetime.datetime.now()
        typing = self.placeForTyping.toPlainText()
        if typing == message:
            self.placeForResult.setText("Congratulations! You didn't make any mistakes.")
        else:
            self.placeForResult.setText("You made some mistakes. Try again and be more attentive.")

app = QtWidgets.QApplication(sys.argv)
myWindow = TypingSpeedWindow(None)
myWindow.show()
app.exec_()