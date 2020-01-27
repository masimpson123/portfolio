def application(env, start_response):
	start_response('200 OK', [
	('Content-Type','text/html'),
	('Access-Control-Allow-Origin', '*')
	])

	print(env)
	print(env.REQUEST_METHOD)

	return [b"HELLO WORLD!"]