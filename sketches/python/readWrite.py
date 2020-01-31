import random

newContent = str(random.randrange(1,10000))

def application(env, start_response):
	start_response('200 OK', [
	('Content-Type','text/html'),
	('Access-Control-Allow-Origin', '*'),
	('Access-Control-Allow-Headers', '*')
	])

	
	f = open("pythonReadWrite.txt", "a")
	f.write(newContent + "\n")
	f.close()

	f = open("pythonReadWrite.txt", "r")
	for x in f:
		print(x)
	f.close()