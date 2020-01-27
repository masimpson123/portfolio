from cgi import parse_qs

def application(env, start_response):

	try:
		request_body_size = int(env.get('CONTENT_LENGTH', 0))
	except (ValueError):
		request_body_size = 0

	request_body = env['wsgi.input'].read(request_body_size)
	d = parse_qs(request_body)

	firstName = d.get('firstName', [''])[0]
	occupation = d.get('occupation', [''])[0]

	response_body = {
		'firstName': firstName or 'Empty',
		'occupation': occupation or 'Empty',
	}

	start_response('200 OK', [
	('Content-Type','text/html'),
	('Access-Control-Allow-Origin', '*')
	])

	#return [b"Hello World!"]
	return response_body