import cgi
import cgitb
cgitb.enable()

def application(env, start_response):
	start_response('200 OK', [
	('Content-Type','text/html'),
	('Access-Control-Allow-Origin', '*')
	])
	form = cgi.FieldStorage()
	test = b"BINGO"
	#print form["username"].value
	#return(b"HELLO WORLD!")
	return(test)