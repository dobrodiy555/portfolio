from selenium import webdriver
from selenium.webdriver.common.by import By
import time

browser = webdriver.Chrome()
browser.implicitly_wait(5)
browser.get("http://suninjuly.github.io/cats.html")

button = browser.find_element(By.ID, "button")
button.click()

time.sleep(5)
browser.quit()

