import cgi

def application(env, start_response):
	start_response('200 OK', [
	('Content-Type','text/html'),
	('Access-Control-Allow-Origin', '*')
	])
	form = cgi.FieldStorage()
	test = form["firstName"]
	return [b"BINGO"]