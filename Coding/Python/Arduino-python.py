import serial  # For serial communication
import mysql.connector  # For MySQL connection
from mysql.connector import Error

# Set up serial connection
ser = serial.Serial('COM5', 9600)  # Change 'COM5' to your Arduino's port
ser.flushInput()  # Ensure buffer is cleared

# MySQL Database connection parameters
host = "localhost"
port = 3306
user = "root"  # Replace with your database username
password = "3Musketiers!"  # Replace with your database password
database = "databaseduiken"  # Replace with your database name

# Function to insert data into MySQL
def insert_data(duration, ndl, depth):
    connection = None
    try:
        connection = mysql.connector.connect(host=host, port=port, user=user, password=password, database=database)
        
        if connection.is_connected():
            cursor = connection.cursor()
            sql_query = "INSERT INTO duiken (Datum, duur, No_decompression_time, diepte) VALUES (NOW(), %s, %s, %s)"
            cursor.execute(sql_query, (duration, ndl, depth))
            connection.commit()
            print(f"Inserted into DB: Duration: {duration}, NDL: {ndl}, Depth: {depth}")
    
    except Error as e:
        print(f"Error while connecting to MySQL: {e}")
    
    finally:
        if connection is not None and connection.is_connected():
            cursor.close()
            connection.close()

# Function to process incoming serial data
def process_serial_data(line):
    # Split the line on '; ' to separate different pieces of data
    data_parts = line.split('; ')
    
    # Initialize values
    duration = None
    ndl = None
    depth = None

    # Process each part of the data
    for part in data_parts:
        if part.startswith('Total Time:'):
            duration = part.split(': ')[1].strip()  # Get time value
            print(f"Time: {duration}")  # Display in terminal
            
        elif part.startswith('Max depth:'):
            depth = float(part.split(': ')[1].strip())  # Get depth value
            print(f"Max Depth: {depth}")  # Display in terminal
            
        elif part.startswith('Total NDL:'):
            ndl = int(part.split(': ')[1].strip())  # Get NDL value
            print(f"NDL: {ndl}")  # Display in terminal

    # Check if all data has been collected
    if duration is not None and ndl is not None and depth is not None:
        insert_data(duration, ndl, depth)  # Insert into database

# Main loop to read from serial and process data
try:
    while True:
        if ser.in_waiting > 0:
            line = ser.readline().decode('utf-8', errors='ignore').strip()  # Read the serial input
            print(f"Received: {line}")  # Print the raw data for debugging in terminal
            process_serial_data(line)  # Process and insert into MySQL

except KeyboardInterrupt:
    print("Exiting...")

finally:
    ser.close()  # Close serial port when exiting
