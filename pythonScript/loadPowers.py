#!/usr/bin/python3
import requests
import  json
import mysql.connector

mydb = mysql.connector.connect(
        host = '127.0.0.1',
        user = 'root',
        passwd = 'password',
        database= 'testdb'
        )

mycursor = mydb.cursor()

mycursor.execute("select * from PowerTable")
myresult = mycursor.fetchall()
for x in myresult:
    print(x)

#url = 'https://comicvine.gamespot.com/api/powers/?api_key=afbe58eef9e2d34188a29ebf707d671bde76e1a1'
#headers = {'User-Agent':'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36'}
#result= requests.get(url, headers=headers)
#print(result.status_code)
with open("powers.json", "r") as read_file:
    data = json.load(read_file)
with open("powers2.json", "r") as read_file:
    data2 = json.load(read_file)

sql = "INSERT INTO PowerTable Values (%s, %s)"
for x in range(100):
    powerID = data["results"][x]["id"]
    powerName= data["results"][x]["name"]
    val = (powerID, powerName)
    mycursor.execute(sql,val)
    mydb.commit()
    print(data["results"][x]["id"])
    print(data["results"][x]["name"])
#needed for offset
for x in range(28):
    powerID = data2["results"][x]["id"]
    powerName = data2["results"][x]["name"]
    val = (powerID, powerName)
    mycursor.execute(sql,val)
    mydb.commit()
    print(data2["results"][x]["id"])
    print(data2["results"][x]["name"])
