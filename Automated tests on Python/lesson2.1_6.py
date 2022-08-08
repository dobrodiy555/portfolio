from selenium import webdriver
from selenium.webdriver.common.by import By
import time
import math

try: 
    link = "http://suninjuly.github.io/get_attribute.html"
    browser = webdriver.Chrome()
    browser.get(link)

    def calc(x):
      return math.log(abs(12*math.sin(int(x))))

    elem_image = browser.find_element(By.ID, "treasure")
    elem_image_attr = elem_image.get_attribute("valuex")  # ищем значение в самом селекторе, а не в тексте на сайте
    x = elem_image_attr # это можно не делать, а сразу подставлять в функцию
    y = calc(x)
    
    input1 = browser.find_element(By.ID, "answer")
    input1.send_keys(y)

    option1 = browser.find_element(By.ID, "robotCheckbox")
    option1.click()

    option2 = browser.find_element(By.ID, "robotsRule")
    option2.click()

    button = browser.find_element(By.CLASS_NAME, "btn.btn-default")
    button.click()

  
finally:
    # ожидание чтобы визуально оценить результаты прохождения скрипта
    time.sleep(10)
    # закрываем браузер после всех манипуляций
    browser.quit()



