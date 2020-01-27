import requests

def application(env, start_response):
	start_response('200 OK', [
	('Content-Type','text/html'),
	('Access-Control-Allow-Origin', '*')
	])

	form = cgi.FieldStorage().getvalue("firstName")
	
	print("raw POST data:")
	print(sys.stdin.read())

	return [b"HELLO WORLD!"]