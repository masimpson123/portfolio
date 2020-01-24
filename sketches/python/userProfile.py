from sqlalchemy import create_engine
from sqlalchemy_utils import database_exists, create_database

engine = create_engine("mysql+pymysql://%s:%s@localhost:3306/%s"%("root","theEarth123$","python"),echo=False)

if not database_exists(engine.url): 
    create_database(engine.url)
    
con = engine.connect()

# CREATE TABLE
#command = """create table users (
#guid int auto_increment key, 
#name varchar(100),
#hometown varchar(100)
#);"""

nameInput = input("What is your name? ")
hometownInput = input("What is your hometown? ")

# WRITE TO TABLE
command = "insert into users (name, hometown) values ('" + nameInput + "','" + hometownInput + "');"

con.execute(command)