from flask import Flask, request, json

programa = Flask(__name__,template_folder='.')

@programa.route('/valida',methods=['POST','GET'])
def valida():
    txt = request.get_data()
    obj = json.loads(txt)
    documento = obj['documento']
    
    if len(documento) != 11:
        return json.dumps({"status":False})
    if not documento.isdigit():
        return json.dumps({"status":False})


    soma = 0
    count = 0
    for el in documento:
        
        if count == 9:
             break
        n = int(el)
        m = 10 - count
        soma += (n*m)
        count +=1
		
    resto = soma%11
     
    dv = 11-resto
	
    if dv>9 :
        dv = 0
	
    print('doc9')
    print(documento[9])
    if int(documento[9]) != dv :
        return json.dumps({"status":False})
    soma = 0
    count = 0
    for el in documento :
        if count == 10:
            break
        n =  int(el)
        m = 11 - count
        soma += (n*m)
        count += 1

    resto = soma%11
    dv = 11 - resto

    
    if dv>9:
        dv = 0

	
    if int(documento[10]) != dv:
        return json.dumps({"status":False})
    
    return json.dumps({"status":True})

programa.run(port=5002,use_reloader=True)