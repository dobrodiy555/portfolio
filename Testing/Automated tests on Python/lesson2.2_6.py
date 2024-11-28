from selenium import webdriver
from selenium.webdriver.common.by import By
import time
import math

try:
    browser = webdriver.Chrome()
    browser.get("http://suninjuly.github.io/execute_script.html")
    x_elem = browser.find_element(By.ID, "input_value")
    x = x_elem.text
    def calc(x):
      return math.log(abs(12*math.sin(int(x))))
    y = calc(x)

    input = browser.find_element(By.CLASS_NAME, "form-control")
    input.send_keys(y)

    browser.execute_script("window.scrollBy(0, 130);")  # проскролим страницу чуть вниз чтобы всё было видно
   
    option1 = browser.find_element(By.ID, "robotCheckbox")
    option1.click()
    option2 = browser.find_element(By.ID, "robotsRule")
    option2.click()

    button = browser.find_element(By.CLASS_NAME, "btn-primary")
    button.click()

finally:
    time.sleep(7)
    browser.quit()

