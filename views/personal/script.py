# %% [markdown]
# ## TEST conexion inster DB NOMINAS

# %%
import os
import re
import pandas as pd
import xml.etree.ElementTree as ET
from pdfminer.high_level import extract_text
from datetime import datetime
from tqdm import tqdm
from sqlalchemy import create_engine

def extract_text_from_pdf_pdfminer(file_path):
    return extract_text(file_path)

def extract_rfc(text):
    match = re.search(r'RFC:(\w{4}-\d{6}-\w{3})', text)
    if match:
        rfc = match.group(1)
        return rfc.replace("-", "")
    else:
        return None

def extract_rfc_from_xml(file_path):
    tree = ET.parse(file_path)
    root = tree.getroot()
    namespaces = {
        'cfdi': 'http://www.sat.gob.mx/cfd/4',
        'nomina12': 'http://www.sat.gob.mx/nomina12',
    }
    rfc_value = None
    for elem in root.iterfind('.//cfdi:Receptor', namespaces=namespaces):
        rfc_value = elem.attrib.get('Rfc')

    if rfc_value:
        return rfc_value.replace("-", "")
    else:
        return None

def extract_rfc_from_filename(filename):
    pattern = r'\d{4}-\d{2}-\d{2}_(\w{12,13})\.pdf'
    match = re.search(pattern, filename)
    if match:
        return match.group(1)
    else:
        return None

def extract_rfc_from_new_filename(filename):
    pattern = r'\d{4}-\d{2}-\d{2}_(\w{12,13})\.pdf'
    match = re.search(pattern, filename)
    if match:
        return match.group(1)
    else:
        return None


directory_path = 'C:/wamp64/www/nomina/codepy/15-08-2023'
pdf_files = [f for f in os.listdir(directory_path) if f.endswith('.PDF')]
xml_files = [f for f in os.listdir(directory_path) if f.endswith('.xml')]
new_pdf_files = [f for f in os.listdir(directory_path) if f.startswith('2023-') and f.endswith('.pdf')]

directory_name = os.path.basename(directory_path)
date = datetime.strptime(directory_name, '%d-%m-%Y').strftime('%Y-%m-%d')

rfcs = {}
for pdf_file in tqdm(pdf_files, desc="Processing PDF files"):
    pdf_path = os.path.join(directory_path, pdf_file)
    pdf_text = extract_text_from_pdf_pdfminer(pdf_path)
    rfc = extract_rfc(pdf_text)
    
    if rfc:
        if rfc in rfcs:
            rfcs[rfc]['pdf'] = pdf_file
        else:
            rfcs[rfc] = {
                'codigo': rfc,
                'pdf': pdf_file,
                'fecha': date,
                'rfc_fecha': rfc + '_' + date,
            }

for new_pdf_file in tqdm(new_pdf_files, desc="Processing new PDF files"):
    rfc_from_new_filename = extract_rfc_from_new_filename(new_pdf_file)
    if rfc_from_new_filename:
        if rfc_from_new_filename in rfcs:
            rfcs[rfc_from_new_filename]['especial'] = new_pdf_file
        else:
            rfcs[rfc_from_new_filename] = {
                'codigo': rfc_from_new_filename,
                'detalle': new_pdf_file,
                'fecha': date,
                'rfc_fecha': rfc_from_new_filename + '_' + date,
            }

for xml_file in tqdm(xml_files, desc="Processing XML files"):
    xml_path = os.path.join(directory_path, xml_file)
    rfc = extract_rfc_from_xml(xml_path)
    if rfc:
        if rfc in rfcs:
            rfcs[rfc]['xml'] = xml_file
        else:
            rfcs[rfc] = {
                'codigo': rfc,
                'xml': xml_file,
                'fecha': date,
                'rfc_fecha': rfc + '_' + date,
            }

df = pd.DataFrame(rfcs.values())

df.to_excel(f'{directory_name}.xlsx', index=False)

# MySQL Connection and Data Insertion
user = 'alfred'
password = 'aaabcde1409'
host = '72.167.45.26'
port = '3306'
database = 'nominas'  # replace with your database name

engine = create_engine(f'mysql+pymysql://{user}:{password}@{host}:{port}/{database}')

df['id'] = range(104952, 104952 + len(df))
df.to_sql('nominas', con=engine, if_exists='append', index=False)



print("Proceso terminado")



