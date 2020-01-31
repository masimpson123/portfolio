def readFirstLine():
    f.write(newContent)
    f = open("pythonReadWrite.txt", "r")
    for x in f:
        print(x)
    f.close()

readFirstLine()