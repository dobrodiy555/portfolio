from selenium import webdriver
from selenium.webdriver.common.by import By
import math
import time

try:
    browser = webdriver.Chrome()
    browser.get("http://suninjuly.github.io/alert_accept.html")
    button = browser.find_element(By.CLASS_NAME, "btn-primary")
    button.click()
    confirm = browser.switch_to.alert
    confirm.accept()
    x_elem = browser.find_element(By.ID, "input_value")
    x = x_elem.text
    def calc(x):
      return math.log(abs(12*math.sin(int(x))))
    y = calc(x)
    input = browser.find_element(By.CLASS_NAME, "form-control")
    input.send_keys(y)
    button1 = browser.find_element(By.CLASS_NAME, "btn-primary")
    button1.click()

       

finally:
    time.sleep(7)
    browser.quit()

