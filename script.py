import mysql.connector

conn = mysql.connector.connect(host="localhost",user="root",password="toto", database="le_chat")
cursor = conn.cursor()
cursor.execute("""
CREATE TABLE IF NOT EXISTS visiteurs (
    id int(5) NOT NULL AUTO_INCREMENT,
    name varchar(50) DEFAULT NULL,
    age INTEGER DEFAULT NULL,
    PRIMARY KEY(id)
);
""")
conn.close()