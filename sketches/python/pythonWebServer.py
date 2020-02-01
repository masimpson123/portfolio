# THIS WEB SERVER MUST BE HOSTED AT LOCALHOST:5020 TO BE COMPATIBLE WITH API.PHP

import mysql.connector
import json

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  passwd="theEarth123$",
  database="python",
  auth_plugin='mysql_native_password'
)

mycursor = mydb.cursor()

def application(env, start_response):
	start_response('200 OK', [
	('Content-Type','text/html'),
	('Access-Control-Allow-Origin', '*'),
	('Access-Control-Allow-Headers', '*')
	])

	if env["REQUEST_METHOD"] == "OPTIONS":
		print("CORS requires an pre-flight options request")
	else:
		insertNewEntry(env)
		# ShowTables()
		# deleteEntriesByName()
		# updateOccupation()

def insertNewEntry(env):
	name = env['HTTP_FIRSTNAME']
	occupation = env['HTTP_OCCUPATION']
	sql = "INSERT INTO users (name, occupation) VALUES ('" + name + "','" + occupation + "');"
	mycursor.execute(sql)
	mydb.commit()
	print(mycursor.rowcount, "record inserted.")
	injectedData = json.dumps([{'name':name,'occupation':occupation}])    
	injectedDataEncoded = bytes(injectedData, 'utf-8')
	return [injectedDataEncoded]

def showTables():
	mycursor.execute("SHOW TABLES")
	for x in mycursor:
		print(x)

def deleteEntriesByName():
	sql = "DELETE FROM users WHERE name = %s" # %s has a security feature that prevents SQL Injection. It 'escapes' the characters.
	nam = ("Kate", )
	mycursor.execute(sql, nam)
	mydb.commit()

def updateOccupation():
	sql = "UPDATE users SET occupation = 'Dog Superhero' WHERE occupation = 'Dog Sidekick'"
	mycursor.execute(sql)
	mydb.commit()

# KNOWN ISSUES:
# A non-fatal error appears in the uWSGI terminal (TypeError: 'NoneType' object is not iterable).
# Each request results in two requests.
# I believe this is because I'm using custom headers. No.
# We want to avoid Cross Origin Resource Sharing (CORS).
# CORS necessitates a 'pre-flight' request that confirms it is safe to send the real request.
# We avoid CORS by hosting everything on the same server.
#
# The return function seems to only work with data that has been converted to bytes.