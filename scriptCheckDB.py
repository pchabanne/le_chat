import mysql.connector
import time

conn = mysql.connector.connect(host="127.0.0.1",user="root",password="toto", database="le_chat")
cursor = conn.cursor()
cursor.execute("select min(id) from Auteurs");

for x in cursor:
	mini = x

cursor.execute("select max(id) from Auteurs");

for x in cursor:
	maxi = x

for i in range(mini[0], maxi[0]+1):
	try:
		cursor.execute("select derniereActivite from Auteurs where id="+str(i))
		for x in cursor:
			if( x[0] + 600 < time.time()):
				cursor.execute("Delete from auteurs where id =' "+str(i)+"'")
				conn.commit()
	except:

print(conn)
