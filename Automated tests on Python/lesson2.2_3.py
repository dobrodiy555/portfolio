from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
import time


try: 
    link = "http://suninjuly.github.io/selects2.html"
    browser = webdriver.Chrome()
    browser.get(link)
       
    num1_elem = browser.find_element(By.ID, "num1")
    num2_elem = browser.find_element(By.ID, "num2")
    num1 = num1_elem.text  # сначала переводим значение в строку чтобы потом можно было перевести в integer
    num2 = num2_elem.text
    x = int(num1) + int(num2)  # теперь считаем переводя в integer
    x_str = str(x)  # переводим обратно в строку чтобы можно было прочитать это значение в select.select_by_value
    
    select = Select(browser.find_element(By.TAG_NAME, "select"))
    select.select_by_visible_text(x_str)
     
    button = browser.find_element(By.CLASS_NAME, "btn.btn-default")
    button.click()

  
finally:
    # ожидание чтобы визуально оценить результаты прохождения скрипта
    time.sleep(10)
    # закрываем браузер после всех манипуляций
    browser.quit()



