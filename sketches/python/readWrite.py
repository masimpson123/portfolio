import random

newContent = str(random.randrange(1,10000))

def application():
    f = open("pythonReadWrite.txt", "r")
    #f.write(newContent)
    for x in f:
        print(x)
    f.close()