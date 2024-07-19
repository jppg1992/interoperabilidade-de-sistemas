from flask import Flask, json, render_template, request, redirect, jsonify
import sqlite3
import requests

URL_BASE_GOL ="http://localhost:8081" 
URL_BASE_LATAM ="http://localhost:8082" 


app = Flask(__name__, template_folder='.')

@app.route('/listar', methods=['GET','POST'])
def listar ():
	if request.method == 'POST':
		data   = request.values.get('data')
		print(data)
		txt = json.dumps({"data":data}) 
		respostaGol = requests.post(url=URL_BASE_GOL+"/servico-voos.php",data=txt)
		txt = respostaGol.content
		 
		listaGol = json.loads(txt)
		print(listaGol)	
		txt = json.dumps({"data":data}) 
		respLatam = requests.post(url=URL_BASE_LATAM+"/servico-voos.php",data=txt)
		txt = respLatam.content
		listaLatam = json.loads(txt)

		
		print(listaLatam)
		return render_template('listar.html',listaGol=listaGol,listaLatam=listaLatam)
	
	return render_template('listar.html')

@app.route('/comprar', methods=['GET'])
def comprar ():
	id = request.values.get('id')
	voo = request.values.get('voo')
	return render_template('comprar.html',resultado={'id':id,'voo':voo})

@app.route('/confirmar', methods=['GET', 'POST'])
def confirmar ():
	if request.method == 'POST':
		cpf   = request.values.get('cpf')
		nome   = request.values.get('nome')
		id   = request.values.get('id')
		voo   = request.values.get('voo')
		 
	
		if voo.find('Gol') >=0:
			urlTxt = URL_BASE_GOL+"/servico-compra.php"
		else:
			urlTxt = URL_BASE_LATAM+"/servico-compra.php"
		
		txt = json.dumps({"id":id,"cpf":cpf,"nome":nome}) 
		resp = requests.post(url=urlTxt,data=txt)
		txt = resp.content
		 
		resultado = json.loads(txt)
	 
		return render_template('confirmar.html',resultado=resultado)
	return render_template('confirmar.html')
@app.route('/', methods=['GET', 'POST'])
def index():
	return redirect('/listar')
	
app.run(port=5001, use_reloader=True)
