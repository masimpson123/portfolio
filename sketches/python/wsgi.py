import os, sys, json
import cgi

def application(env, start_response):
	start_response('200 OK', [
	('Content-Type','text/html'),
	('Access-Control-Allow-Origin', '*')
	])

	data = sys.stdin.read(int(os.environ.get('HTTP_CONTENT_LENGTH', 0)))

	if data:
		print(list(json.loads(data).keys())) # Prints out keys of json

	form = cgi.FieldStorage().getvalue("firstName")
	
	print("raw POST data:")
	print("")

	return [b"HELLO WORLD!"]