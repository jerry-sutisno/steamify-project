import zipfile
import xml.etree.ElementTree as ET
import sys

def read_docx(path):
    try:
        with zipfile.ZipFile(path) as docx:
            xml_content = docx.read('word/document.xml')
            tree = ET.XML(xml_content)
            namespace = {'w': 'http://schemas.openxmlformats.org/wordprocessingml/2006/main'}
            text = []
            for paragraph in tree.iterfind('.//w:p', namespace):
                texts = [node.text for node in paragraph.iterfind('.//w:t', namespace) if node.text]
                if texts:
                    text.append(''.join(texts))
            return '\n'.join(text)
    except Exception as e:
        return str(e)

content = read_docx('d:/laragon/www/steamify/LAPORAN WEB 3 - UAS.docx')
with open('d:/laragon/www/steamify/laporan_extracted.md', 'w', encoding='utf-8') as f:
    f.write(content)
print("Extraction complete.")
