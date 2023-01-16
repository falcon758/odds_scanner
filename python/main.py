from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from time import sleep
import pandas as pd

# Url to access
yahoo_url = 'https://finance.yahoo.com/quote/BTC-EUR/history/'

# Holds driver
driver = None

# Hold table
table_element = None

# Hold dates
list_dates = []

# Hold closed
list_closeds = []

# CSV filename
csv_filename = 'eur_btc_rates.csv'

def start_driver():
  global driver

  chomeService = Service('./chromedriver')
  driver = webdriver.Chrome(service=chomeService)
  driver.get(yahoo_url)

  # Waiting for cookies consent
  sleep(10)

def retrieve_data():
  global list_dates
  global list_closeds

  # Select rows
  rows = driver.find_elements(By.CSS_SELECTOR, 'table tbody tr')

  # Save data
  for row in rows:
    columns = row.find_elements(By.TAG_NAME, 'td')

    date = columns[0].text
    price = columns[1].text

    if date == '' or price == '':
      continue

    list_dates.append(columns[0].text)
    list_closeds.append(columns[4].text)

def save_csv():
  # Converting to a csv
  dict = {'Date': list_dates[0:11], 'BTC Closing Value': list_closeds[0:11]} 
  df = pd.DataFrame(dict)
  df.to_csv(csv_filename)

start_driver()
retrieve_data()
save_csv()

