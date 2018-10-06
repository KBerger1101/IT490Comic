#!/usr/bin/python3
import requests
import pika
import json
import random
import datetime

RABBIT_HOST = '127.0.0.1'
RABBIT_PORT = 5672
RABBIT_Q = '*'
RABBIT_USER = 'test'
RABBIT_PASS = 'test'
RABBIT_VH = 'testHost'
RABBIT_EX = 'testExchange'

apiKey = '?api_key=afbe58eef9e2d34188a29ebf707d671bde76e1a1&format=json'
url = 'https://comicvine.gamespot.com/api/publisher/4010-31/' + apiKey
headers = {'User-Agent':'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36'}
#result = requests.get(url, headers=headers)
#print(result.status_code)
#print(result.text)

with open("DCJSON.json", "r") as read_file:
    data = json.load(read_file)
with open("MarvelJSON.json","r") as read_file:
    mData= json.load(read_file)

print("Here are 5 DC characters")
for x in range(5):
    offset= random.randint(1,3000)
    dcCharacterName = data["results"]["characters"][offset]["name"]
    dcCharacterURL = data["results"]["characters"][offset]["api_detail_url"]
    fullCharDetailURL = dcCharacterURL + apiKey
    print(dcCharacterName)
    print(dcCharacterURL)
    print (fullCharDetailURL)
print("Here are 5 Marvel characters")
for x in range(5):
    offset= random.randint(1,3000)
    marvelCharacterName=mData["results"]["characters"][offset]["name"]
    marvelCharacterURL= mData["results"]["characters"][offset]["api_detail_url"] 
    print (marvelCharacterName)
     
print("Who Would Win")
