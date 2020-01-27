import cgi

def application(env, start_response):
	start_response('200 OK', [
	('Content-Type','text/html'),
	('Access-Control-Allow-Origin', '*')
	])
	form = cgi.FieldStorage()
	firstName = form.getvalue("firstName","(no firs name)")
	#test = b"BINGO"
	#print form["username"].value
	#return(b"HELLO WORLD!")
	#return(test)
	return(firstName)