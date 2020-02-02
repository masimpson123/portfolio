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
		mydict = { "name": "Peter", "address": "Lowstreet 27" } # data
		x = mycol.insert_one(mydict)
		print(x.inserted_id)