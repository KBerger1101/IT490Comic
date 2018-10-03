#!/usr/bin/python3
import requests
import json
import random

#url = 'https://comicvine.gamespot.com/api/publisher/4010-31/?api_key=afbe58eef9e2d34188a29ebf707d671bde76e1a1'
#headers = {'User-Agent':'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36'}
#result = requests.get(url, headers=headers)
#print(result.status_code)
#print(result.text)
apiCode= "?api_key=afbe58eef9e2d34188a29ebf707d671bde76e1a1&format=json"
with open("DCJSON.json", "r") as read_file:
    data = json.load(read_file)
with open("MarvelJSON.json","r") as read_file:
    mData= json.load(read_file)

print("Here are 5 DC characters")
for x in range(5):
    dcCharacterName = data["results"]["characters"][random.randint(1,3000)]["name"]
    dcCharacterURL = data["results"]["characters"][random.randint(1,3000)]["api_detail_url"]
    print(dcCharacterName)
print("Here are 5 Marvel characters")
for x in range(5):
    marvelCharacterName=mData["results"]["characters"][random.randint(1,3000)]["name"]
    marvelCharacterURL= mData["results"]["characters"][random.randint(1,3000)]["api_detail_url"] 
    print (marvelCharacterName)
     
print("Who Would Win")
