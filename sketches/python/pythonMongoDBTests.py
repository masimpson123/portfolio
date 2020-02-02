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

	if env["REQUEST_METHOD"] == "OPTIONS" or env["REQUEST_URI"] != "/":
		pass
	else:
		pass