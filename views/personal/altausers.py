import pandas as pd
import mysql.connector
from mysql.connector import Error

# Parámetros de conexión a MySQL
host_name = "72.167.45.26"
user_name = "alfred"
user_password = "aaabcde1409"
db_name = "nominas"

# Carga el archivo Excel
archivo_excel = "C:/wamp64/www/admin-gmt/views/personal/archivo_lista/Lista.xlsx"
df = pd.read_excel(archivo_excel)

# Función para obtener RFCs existentes
def obtener_rfc_existentes(conn):
    try:
        cursor = conn.cursor()
        query = "SELECT rfc FROM empleados_pruebas"
        cursor.execute(query)
        result = cursor.fetchall()
        return {rfc[0] for rfc in result}
    except Error as e:
        print("Error al obtener RFCs existentes", e)
        return set()

# Función para insertar datos
def insertar_datos(conn, nombre, rfc, password, carpeta):
    try:
        cursor = conn.cursor()
        query = "INSERT INTO empleados_pruebas (nombre, rfc, password, carpeta) VALUES (%s, %s, %s, %s)"
        cursor.execute(query, (nombre, rfc, password, carpeta))
        conn.commit()
        return True
    except Error as e:
        print(f"Error al insertar datos para RFC {rfc}: {e}")
        return False

# Conectar a MySQL
try:
    conn = mysql.connector.connect(
        host=host_name,
        user=user_name,
        password=user_password,
        database=db_name
    )
    if conn.is_connected():
        print("Conexión exitosa a la base de datos")

        # Obtener RFCs existentes
        rfc_existentes = obtener_rfc_existentes(conn)

        total_registros = len(df)
        registros_insertados = 0
        print(df.columns)

        # Itera sobre el DataFrame e inserta los datos si el RFC no existe
        for i, fila in df.iterrows():
            print(f"Procesando registro {i+1}/{total_registros}...")
            if fila["rfc"] not in rfc_existentes:
                if insertar_datos(conn, fila["nombre"], fila["rfc"], fila["password"], fila["carpeta"]):
                    registros_insertados += 1
                    rfc_existentes.add(fila["rfc"])  # Añadir el RFC al conjunto de existentes
            else:
                print(f"Registro omitido: el RFC {fila['rfc']} ya existe.")

        print(f"Todos los datos han sido procesados. Total de registros insertados: {registros_insertados}")

except Error as e:
    print("Error al conectar a MySQL", e)
finally:
    if conn.is_connected():
        conn.close()
        print("Conexión a MySQL cerrada")
