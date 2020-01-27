import cgi

def application(env, start_response):
	start_response('200 OK', [
	('Content-Type','text/html'),
	('Access-Control-Allow-Origin', '*')
	])

	POST={}
	args=sys.stdin.read().split('&')

	for arg in args: 
		t=arg.split('=')
		if len(t)>1: k, v=arg.split('='); POST[k]=v

	form = cgi.FieldStorage().getvalue("firstName")
	print(form)
	print("BINGO")
	print("BINGO")
	print("BINGO")
	return "HELLO WORLD!"
	return form