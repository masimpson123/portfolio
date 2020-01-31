def application(env, start_response):
	start_response('200 OK', [
	('Content-Type','text/html')
	])
	print(env)

def writeToFile():
	import random

	newContent = str(random.randrange(1,10000))

	f = open("pythonReadWrite.txt", "a")
	f.write(newContent + "\n")
	f.close()

writeToFile()