def application(env, start_response):
	start_response('200 OK', [
	('Content-Type','text/html')
	])

	#import random

	#newContent = str(random.randrange(1,10000))

	newContent = "BINGO"

	f = open("pythonReadWrite.txt", "a")
	f.write(newContent + "\n")
	f.close()