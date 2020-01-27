import os

def application(env, start_response):
	start_response('200 OK', [
	('Content-Type','text/html'),
	('Access-Control-Allow-Origin', '*')
	])

	print(env['QUERY_STRING'])

	return [b"HELLO WORLD!"]