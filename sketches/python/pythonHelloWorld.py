name = input("What is your name? ")

def checkName(name):  
	checkName = input("Is your name " + name + "? ") 
    
	if checkName.lower() == "yes":    
		print("Hello,", name)  
	else:    
		print("We're sorry about that.")

def  occupation():
	name = input("What is your job? ") 

occupation()
checkName(name)