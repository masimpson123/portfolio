import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  passwd="theEarth123$",
  database="python"
)

mycursor = mydb.cursor()

nameInput = input("What is your name? ")
hometownInput = input("What is your hometown? ")

sql = "INSERT INTO users (name, hometown) VALUES ('" + nameInput + "','" + hometownInput + "');"

mycursor.execute(sql)

mydb.commit()

print(mycursor.rowcount, "record inserted.")