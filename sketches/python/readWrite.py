def application(env, start_response):
	start_response('200 OK', [('Content-type', 'text/plain')])
	if env["REQUEST_URI"] == "/":
		writeToFile()
		readTheFile()
		#deleteTheFile()
		analyzeRelationship()
	else:
		pass

def writeToFile():
	import random
	newContent = str(random.randrange(1,10000))
	f = open("pythonReadWrite.txt", "a")
	f.write(newContent + "\n")
	f.close()

def readTheFile():
	f = open("pythonReadWrite.txt", "r")
	for x in f:
		print(x)
	f.close()

def deleteTheFile():
	import os
	if os.path.exists("pythonReadWrite.txt"):
		os.remove("pythonReadWrite.txt")
	else:
		print("The file does not exist")

def analyzeRelationship():