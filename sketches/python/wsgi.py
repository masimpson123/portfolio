import os

def application(env, start_response):
	start_response('200 OK', [
	('Content-Type','text/html'),
	('Access-Control-Allow-Origin', '*'),
	('Access-Control-Allow-Headers', '*')
	])

	print(env)
	print(os.environ)
	print(env['HTTP_FIRSTNAME'])
	print(env['HTTP_OCCUPATION'])

	return [b"HELLO WORLD!"]