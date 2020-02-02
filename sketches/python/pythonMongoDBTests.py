def application(env, start_response):
	start_response('200 OK', [
	('Content-Type','text/html'),
	('Access-Control-Allow-Origin', '*'),
	('Access-Control-Allow-Headers', '*')
	])

	if env["REQUEST_METHOD"] == "OPTIONS" or env["REQUEST_URI"] != "/":
		pass
	else:
		import pymongo
		myclient = pymongo.MongoClient("mongodb://localhost:27017/") # connect to mongodb
		mydb = myclient["mydatabase"] # create/select database
		mycol = mydb["customers"] # create collection
		mylist = [
			{ "name": "Amy", "address": "Apple st 652"},
			{ "name": "Hannah", "address": "Mountain 21"},
			{ "name": "Michael", "address": "Valley 345"},
			{ "name": "Sandy", "address": "Ocean blvd 2"},
			{ "name": "Betty", "address": "Green Grass 1"},
			{ "name": "Richard", "address": "Sky st 331"},
			{ "name": "Susan", "address": "One way 98"},
			{ "name": "Vicky", "address": "Yellow Garden 2"},
			{ "name": "Ben", "address": "Park Lane 38"},
			{ "name": "William", "address": "Central st 954"},
			{ "name": "Chuck", "address": "Main Road 989"},
			{ "name": "Viola", "address": "Sideway 1633"}
		]
		x = mycol.insert_many(mylist)
		for x in mycol.find({},{ "_id": 0, "name": 1, "address": 1 }):
  			print(x)