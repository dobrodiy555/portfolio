from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium import webdriver
import math

browser = webdriver.Chrome()

browser.get("http://suninjuly.github.io/explicit_wait2.html")

price = WebDriverWait(browser, 10).until(
        EC.text_to_be_present_in_element((By.ID, "price"), "$100"))
    
button = browser.find_element(By.ID, "book")
button.click()

browser.execute_script("window.scrollBy(0, 130);")  # проскролим страницу чуть вниз чтобы всё было видно

x_elem = browser.find_element(By.ID, "input_value")
x = x_elem.text
def calc(x):
  return math.log(abs(12*math.sin(int(x))))
y = calc(x)
input = browser.find_element(By.CLASS_NAME, "form-control")
input.send_keys(y)
button1 = browser.find_element(By.ID, "solve")
button1.click()

