from flask import Flask, json, render_template, request, redirect, jsonify
import sqlite3
import requests

ingresso = Flask(__name__, template_folder='.')

@ingresso.route('/pessoafisicainserir', methods=['GET', 'POST'])
def inserirpf():
	if request.method == 'POST':
		cpf   = request.values.get('cpf')
		nome  = request.values.get('nome')
		insert = "insert into pessoafisica values (null, '" + cpf + "', '" + nome + "'); "
		conexao = sqlite3.connect('banco.data')
		conexao.execute(insert)
		conexao.commit()
		conexao.close()
		return redirect('/pessoafisicalistar')
	elif request.method == 'GET':
		return render_template('pessoafisica_cadastro.html')

@ingresso.route('/pessoafisicalistar', methods=['GET'])
def listarpf():
	select = "select id, cpf, nome from pessoafisica order by nome; ";
	conexao = sqlite3.connect('banco.data')
	resultado = conexao.execute(select).fetchall()
	conexao.close()
	return render_template("pessoafisica_listar.html", resultado=resultado)

@ingresso.route('/pessoafisicaremover', methods=['GET'])
def removerpf() :
	id = request.values.get('id')
	delete = "delete from pessoafisica where id = {0}; "
	delete = delete.format(id)
	conexao = sqlite3.connect('banco.data')
	conexao.execute(delete)
	conexao.commit()
	conexao.close()
	return redirect("/pessoafisicalistar")

@ingresso.route('/pessoajuridicainserir', methods=['GET', 'POST'])
def inserirpj():
	if request.method == 'POST':
		cnpj  = request.values.get('cnpj')
		nome  = request.values.get('nome')
		insert = "insert into pessoajuridica values (null, '" + cnpj + "', '" + nome + "'); "
		conexao = sqlite3.connect('banco.data')
		conexao.execute(insert)
		conexao.commit()
		conexao.close()
		return redirect('/pessoajuridicalistar')
	elif request.method == 'GET':
		return render_template('pessoajuridica_cadastro.html')

@ingresso.route('/pessoajuridicalistar', methods=['GET'])
def listarpj():
	select = "select id, cnpj, nome from pessoajuridica order by nome; ";
	conexao = sqlite3.connect('banco.data')
	resultado = conexao.execute(select).fetchall()
	conexao.close()
	return render_template("pessoajuridica_listar.html", resultado=resultado)

@ingresso.route('/pessoajuridicaremover', methods=['GET'])
def removerpj() :
	id = request.values.get('id')
	delete = "delete from pessoajuridica where id = {0}; "
	delete = delete.format(id)
	conexao = sqlite3.connect('banco.data')
	conexao.execute(delete)
	conexao.commit()
	conexao.close()
	return redirect("/pessoajuridicalistar")

@ingresso.route('/estagioinserir', methods=['GET', 'POST'])
def inserire():
	if request.method == 'POST':
		pf = request.values.get('pf')
		pj = request.values.get('pj')
		
		# pesquisar o cpf
		sql="select cpf, date('now') as inicio from pessoafisica where id = '"+pf+"';"
		# pesquisar se já tem estágio vigente nessa data
		select = "select * from estagio where fisica = '"+pf+"' and inicio < DATE('now','-6 months') and  inicio > DATE('now','+6 months');"
		insert = "insert into estagio values (null, '" + pf + "', '" + pj + "', datetime('now')); "
		conexao = sqlite3.connect('banco.data')
		result = conexao.execute(select).fetchall()
		conexao.commit()
		print( result )
		if (len(result)>0):
			return 'Não foi inserido já consta estágio em andamento!'
		#busca o cpf
		tupla = result = conexao.execute(sql).fetchall()[0]
		cpf = tupla=[0]
		inicio = tupla[1]

		obj = {"cpf":cpf,"inicio":inicio}
		txt = json.dumps(obj)
		res=requests.post(url="http://localhost:5002/sobreposicao",data=txt)
		txt = res.content
		obj = json.loads(txt)
		if obj['sobreposicao'] == True:
			return 'Não podem haver estágios sobrepostos'
		
		conexao.execute(insert)
		conexao.commit()
		conexao.close()
		return redirect('/estagiolistar')
	elif request.method == 'GET':
		conexao = sqlite3.connect('banco.data')
		select = "select id, nome from pessoafisica order by nome; "
		resultadopf = conexao.execute(select).fetchall()
		select = "select id, nome from pessoajuridica order by nome; "
		resultadopj = conexao.execute(select).fetchall()
		conexao.close()
		return render_template('estagio_cadastro.html', pf=resultadopf, pj=resultadopj)

@ingresso.route('/estagiolistar', methods=['GET'])
def listare():
	select = "select e.id, f.nome fnome, f.cpf, j.nome jnome, j.cnpj, e.inicio from estagio e join pessoafisica f on e.fisica = f.id join pessoajuridica j on e.juridica = j.id order by e.inicio desc; ";
	conexao = sqlite3.connect('banco.data')
	resultado = conexao.execute(select).fetchall()
	conexao.close()
	return render_template("estagio_listar.html", resultado=resultado)
	
@ingresso.route('/estagioremover', methods=['GET'])
def removere() :
	id = request.values.get('id')
	delete = "delete from estagio where id = {0}; "
	delete = delete.format(id)
	conexao = sqlite3.connect('banco.data')
	conexao.execute(delete)
	conexao.commit()
	conexao.close()
	return redirect("/estagiolistar")
	
@ingresso.route('/', methods=['GET', 'POST'])
def inicio():
	return redirect('/estagiolistar')

@ingresso.route('/sobreposicao')
def sobreposicao():
	txt = request.get_data()
	obj = json.loads(txt)
	cpf = obj['cpf']
	inicio = obj['inicio']
	select =  "select * from pessoafisica f join estagio e on e.fisica = f.id"
	select += " where f.cpf = '"+cpf+"' and e.inicio < date('"+inicio+"','-6months') "
	select += " and e.inicio < date('"+inicio+"','+6months') "
	conexao = sqlite3.connect("banco.data")
	resultado = conexao.execute(select).fetchall()
	obj ={"sobreposicao":False}
	if len(resultado)>0:
		obj = {"sobreposicao":True}
	txt = json.dumps(obj)
	return txt
ingresso.run(port=5001, use_reloader=True)
