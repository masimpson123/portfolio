import cgi
form = cgi.FieldStorage()
test = form["firstName"]
return [test]

def application(env, start_response):
	start_response('200 OK', [
	('Content-Type','text/html'),
	('Access-Control-Allow-Origin', '*')
	])
	return [b"Hello World!"]