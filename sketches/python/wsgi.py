import os, sys, json
import cgi

def application(env, start_response):
	start_response('200 OK', [
	('Content-Type','text/html'),
	('Access-Control-Allow-Origin', '*')
	])

	totalBytes=int(os.environ.get('HTTP_CONTENT_LENGTH'))
	reqbin=io.open(sys.stdin.fileno(),"rb").read(totalBytes)
	reqstr=reqbin.decode("utf-8")
	thejson=json.loads(reqstr)

	print(thejson)

	form = cgi.FieldStorage().getvalue("firstName")
	
	print("raw POST data:")
	print("")

	return [b"HELLO WORLD!"]