def application(env, start_response):
	start_response('200 OK', [('Content-type', 'text/plain')])
	if env["REQUEST_URI"] == "/":
		#writeToFile()
		#readTheFile()
		#deleteTheFile()
		analyzeRelationship()
	else:
		pass

def writeToFile():
	import random
	newContent = str(random.randrange(1,10000))
	f = open("pythonReadWrite.txt", "a")
	f.write(newContent + "\n")
	f.close()

def readTheFile():
	f = open("pythonReadWrite.txt", "r")
	for x in f:
		print(x)
	f.close()

def deleteTheFile():
	import os
	if os.path.exists("pythonReadWrite.txt"):
		os.remove("pythonReadWrite.txt")
	else:
		print("The file does not exist")

def analyzeRelationship():
	import pandas
	from sklearn import linear_model

	df = pandas.read_csv("cars.csv")

	X = df[['Weight', 'Volume']]
	y = df['CO2']

	regr = linear_model.LinearRegression()

	regr.fit(X, y) # Inject our data into the linear regression object

	# The relationship between 1 unit of engine volume and 1 unit of carbon emissions:
	# The relationship between 1 unit of vehicle volume and 1 unit of carbon emissions:
	print(regr.coef_)

	# We provide values for our independent variables:
	# SKLearn provides a prediction of what the dependent variable would equal:
	predictedCO2 = regr.predict([[2300, 1300]])
	print(predictedCO2)
	