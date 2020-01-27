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

	if "HTTP_FIRSTNAME" in env and "HTTP_OCCUPATION" in env:
		name = env['HTTP_FIRSTNAME']
		occupation = env['HTTP_OCCUPATION']
		sql = "INSERT INTO users (name, occupation) VALUES ('" + name + "','" + occupation + "');"
		mycursor.execute(sql)
		mydb.commit()
		print(mycursor.rowcount, "record inserted.")
		injectedData = json.dumps([{'name':name,'occupation':occupation}])    
		injectedDataEncoded = injectedData.encode('utf-8')
		return [test1]