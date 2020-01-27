import cgi

def application(env, start_response):
	start_response('200 OK', [
	('Content-Type','text/html'),
	('Access-Control-Allow-Origin', '*')
	])
	data = cgi.FieldStorage()
	print("Content-Type: text/html\n")
	print("The foo firstName is: " + data["firstName"].value)
	print("<br />")
	print("The bar occupation is: " + data["occupation"].value)
	print("<br />")
	return(data)