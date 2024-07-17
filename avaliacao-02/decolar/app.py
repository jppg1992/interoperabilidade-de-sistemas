from flask import Flask, json, render_template, request, redirect, jsonify
import sqlite3
import requests

app = Flask(__name__, template_folder='.')

@app.route('/listar', methods=['GET','POST'])
def listar ():
	if request.method == 'POST':
		data   = request.values.get('data')
		print(data)
		txt = json.dumps({"data":data}) 
		respostaGol = requests.post(url="http://localhost:8001/servico-voos.php",data=txt)
		txt = respostaGol.content
		 
		resultado = json.loads(txt)
		print(resultado[0])
		return render_template('listar.html',resultado=resultado)
	
	return render_template('listar.html')

@app.route('/comprar', methods=['GET'])
def comprar ():
	id = request.values.get('id')
	voo = request.values.get('voo')
	return render_template('comprar.html')

@app.route('/confirmar', methods=['GET', 'POST'])
def confirmar ():
	return render_template('confirmar.html')

@app.route('/', methods=['GET', 'POST'])
def index():
	return redirect('/listar')
	
app.run(port=5001, use_reloader=True)
