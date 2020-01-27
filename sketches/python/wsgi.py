import requests
import cgi

def application(env, start_response):
	start_response('200 OK', [
	('Content-Type','text/html'),
	('Access-Control-Allow-Origin', '*')
	])

	form = cgi.FieldStorage().getvalue("firstName")
	
	print("raw POST data:")
	print(request.POST.get("firstName", "default"))

	return [b"HELLO WORLD!"]