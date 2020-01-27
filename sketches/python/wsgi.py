import os, sys, json
import cgi

def application(env, start_response):
	start_response('200 OK', [
	('Content-Type','text/html'),
	('Access-Control-Allow-Origin', '*')
	])

	raw_data = sys.stdin.read()

	form = cgi.FieldStorage().getvalue("firstName")
	
	print("raw POST data:")
	print(raw_data)

	return [b"HELLO WORLD!"]