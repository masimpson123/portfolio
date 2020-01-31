def application(env, start_response):
	start_response('200 OK', [('Content-type', 'text/plain')])
	if env["REQUEST_URI"] == "/":
		writeToFile()
		readTheFile()
	else:
		pass

def writeToFile():
	import random
	newContent = str(random.randrange(1,10000))
	f = open("pythonReadWrite.txt", "a")
	f.write(newContent + "\n")
	f.close()

def readTheFile():
	f = open("demofile.txt", "r")
	for x in f:
		print(x)
	f.close()