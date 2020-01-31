def application(env, start_response):
	start_response('200 OK', [('Content-type', 'text/plain')])
	print(start_response)
	print(env)
	writeToFile()

def writeToFile():
	import random
	newContent = str(random.randrange(1,10000))
	f = open("pythonReadWrite.txt", "a")
	f.write(newContent + "\n")
	f.close()