from selenium import webdriver
from selenium.webdriver.common.by import By
import os 
import time

try:
    browser = webdriver.Chrome()
    browser.get("http://suninjuly.github.io/file_input.html")
    current_dir = os.path.abspath(os.path.dirname(__file__))    # получаем путь к директории текущего исполняемого файла 
    file_path = os.path.join(current_dir, 'file.txt')  # указываем имя файла лежащего в нашей папке
    
    input1 = browser.find_element(By.NAME, "firstname")
    input1.send_keys("blabla")
    input2 = browser.find_element(By.NAME, "lastname")
    input2.send_keys("blabla")
    input3 = browser.find_element(By.NAME, "email")
    input3.send_keys("blabla@gmail.com")
    input4 = browser.find_element(By.CSS_SELECTOR, "[type='file']")
    input4.send_keys(file_path)  # загружаем файл из нашей директории

    button = browser.find_element(By.CLASS_NAME, "btn-primary")
    button.click()

finally:
    time.sleep(7)
    browser.quit()

