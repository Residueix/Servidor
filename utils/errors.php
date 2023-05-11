<?php

// Javier Valverde Lozano

$errors = array(
    
    "1" => '{"codi_error":"token_1","error":"No s\'ha enviat el mètode correcte."}',
    "2" => '{"codi_error":"token_2","error":"No s\'ha trobat el tipus d\'accio a fer."}',
    "3" => '{"codi_error":"token_3","error":"No s\'ha enviat l\'acció corresponent per generar token."}',
    "4" => '{"codi_error":"token_4","error":"No s\'ha enviat l\'usuari per generar token."}',
    "5" => '{"codi_error":"token_5","error":"No s\'ha enviat un tipus d\'usuari correcte."}',
    "6" => '{"codi_error":"token_6","error":"L\'usuari informat no existeix."}',
    "7" => '{"codi_error":"token_7","error":"Error al generar token. Contacti amb l\'administrador."}',
    "8" => '{"codi_error":"usuaris_1","error":"No s\'ha enviat el mètode correcte."}',
    "9" => '{"codi_error":"usuaris_2","error":"No s\'ha trobat el tipus d\'accio a fer."}',
    "10" => '{"codi_error":"usuaris_3","error":"No s\'ha trobat el permís per fer qualsevol acció."}',
    "11" => '{"codi_error":"usuaris_4","error":"No té permís per la gestió d\'usuaris."}',
    "12" => '{"codi_error":"usuaris_5","error":"Falten paràmetres per poder donar d\'alta un usuari. Recorda que com a mínim ha d\'haver: tipus d\'usuari, email, paraula clau, nom i cognom1 i telèfon."}',
    "13" => '{"codi_error":"usuaris_6","error":"Només pot donar d\'alta usuaris administradors."}', 
    "14" => '{"codi_error":"usuaris_7","error":"No s\'ha facilitat id de l\'usuari que fa la petició."}', 
    "15" => '{"codi_error":"token_8","error":"No s\'ha facilitat un token per fer la petició."}', 
    "16" => '{"codi_error":"token_9","error":"No hi ha un token vàlid per aquest usuari o a caducat."}', 
    "17" => '{"codi_error":"usuaris_8","error":"No té permí per donar d\'alta aquest tipus d\'usuari"}', 
    "18" => '{"codi_error":"usuaris_9","error":"Falten paràmetres per poder donar d\'alta un usuari. Recorda que com a mínim ha d\'haver: tipus d\'usuari, email, paraula clau, nom i cognom1,telèfon, carrer, cp i població."}',
    "19" => '{"codi_error":"usuaris_10","error":"Només pot donar d\'alta treballadors dels punts de recollida."}',
    "20" => '{"codi_error":"usuaris_11","error":"Aquest usuari (email) ja existeix registrat al sistema."}',
    "21" => '{"codi_error":"poblacions_1","error":"Hi ha un error amb el llistat de poblacions. Posi\'s en contacte amb l\'adminisrador.."}',
    "22" => '{"codi_error":"usuaris_12","error":"Només pot donar d\'alta ususaris residuents."}',
    "23" => '{"codi_error":"login_1","error":"No ha indicat usuari."}',
    "24" => '{"codi_error":"login_2","error":"No ha indicat paraula clau."}',
    "25" => '{"codi_error":"login_3","error":"Usuari o paraula clau incorrectes."}',
    "26" => '{"codi_error":"login_4","error":"No ha indicat token."}',
    "27" => '{"codi_error":"usuaris_13","error":"No pot eliminar un usuari que no sigui el propi."}',
    "28" => '{"codi_error":"usuaris_14","error":"Només pot donar d\'alta usuaris adherits."}',
    "29" => '{"codi_error":"usuaris_15","error":"Aquest usuari administrador no existeix."}',
    "30" => '{"codi_error":"usuaris_16","error":"Aquest usuari residuent no existeix."}',
    "31" => '{"codi_error":"usuaris_17","error":"Només pot donar d\'alta usuaris residuents."}',
    "32" => '{"codi_error":"usuaris_18","error":"Falten paràmetres per poder donar d\'alta un usuari. Recorda que com a mínim ha d\'haver: id, tipus d\'usuari, email, paraula clau, nom, cognom1 i cognom2, carrer, codi postal, població i telèfon."}',
    "33" => '{"codi_error":"usuaris_19","error":"Aquest usuari treballador no existeix."}',
    "34" => '{"codi_error":"usuaris_20","error":"Només pot donar d\'alta usuaris treballadors."}',
    "35" => '{"codi_error":"usuaris_21","error":"Falten paràmetres per poder donar d\'alta un usuari. Recorda que com a mínim ha d\'haver: id, tipus d\'usuari, email, paraula clau, nom, cognom1 i cognom2 i telèfon."}',
    "36" => '{"codi_error":"usuaris_22","error":"Aquest usuari adherit no existeix."}',                            
    "37" => '{"codi_error":"usuaris_23","error":"Només pot donar d\'alta usuaris adherits."}',
    "38" => '{"codi_error":"usuaris_24","error":"Falten paràmetres per poder donar d\'alta un usuari. Recorda que com a mínim ha d\'haver: id, tipus d\'usuari, email, paraula clau, nom, cognom1 i cognom2, telèfon, actiu , carrer, poblacio, codi postal, nom empresa i horari."}',
    "39" => '{"codi_error":"usuaris_25","error":"No s\'ha trobat usuari amb aquest identificador."}',
    "40" => '{"codi_error":"usuaris_26","error":"No s\'ha trobat usuari amb aquest email."}',
    "41" => '{"codi_error":"tipus_residu_1","error":"No s\'ha pogut donar d\'alta el tipus de residu."}',
    "42" => '{"codi_error":"tipus_residu_2","error":"No s\'ha pogut modificar el tipus de residu."}',
    "43" => '{"codi_error":"llistat_1","error":"No hi ha cap tipus de residu."}',
    "44" => '{"codi_error":"tipus_residu_3","error":"No s\'ha pogut carregar l\'imatge."}',
    "45" => '{"codi_error":"tipus_residu_4","error":"Falten paràmetres per poder donar d\'alta un tipus de residu. Recorda que com a mínim ha d\'haver: nom i imatge."}',
    "46" => '{"codi_error":"tipus_residu_5","error":"Només pot donar d\'alta usuaris administradors i treballadors."}',
    "47" => '{"codi_error":"tipus_residu_6","error":"Falten paràmetres per poder modificar un tipus de residu. Recorda que com a mínim ha d\'haver: id, nom i imatge (opcional)."}',
    "48" => '{"codi_error":"residu_1","error":"No s\'ha pogut donar d\'alta el residu."}',
    "49" => '{"codi_error":"residu_2","error":"No s\'ha pogut carregar l\'imatge."}',
    "50" => '{"codi_error":"residu_3","error":"Falten paràmetres per poder donar d\'alta un residu. Recorda que com a mínim ha d\'haver: tipus, nom, imatge, descripcio, valor i actiu."}',
    "51" => '{"codi_error":"residu_4","error":"No s\'ha pogut modificar el tipus de residu."}',
    "52" => '{"codi_error":"residu_5","error":"Només pot llistar residus l\'administrador i treballador."}',
    "53" => '{"codi_error":"residu_6","error":"Només pot llistar tipus de residus l\'administrador i treballador."}',
    "54" => '{"codi_error":"residu_7","error":"Només pot consultar tipus de residus l\'administrador i treballador."}',
    "55" => '{"codi_error":"residu_8","error":"L\'id passat com a paràmetre no correspon a cap tipus de residu."}',
    "56" => '{"codi_error":"residu_9","error":  "No s\'ha passat cap id com a paràmetre."}',
    "57" => '{"codi_error":"residu_10","error":"No es pot eliminar aquest tipus de residu perquè té residus relacionats."}',  
    "58" => '{"codi_error":"tipus_residu_7","error":  "L\'Id passat a donar de baixa no existeix."}',
    "59" => '{"codi_error":"tipus_residu_8","error":"Només pot donar de baixa tipus de residus l\'administrador i treballador."}',
    "60" => '{"codi_error":"tipus_residu_9","error":"El token que utilitza aquest compte no esta actiu."}',
    "61" => '{"codi_error":"residu_11","error":  "No s\'ha passat cap id com a paràmetre."}',
    "62" => '{"codi_error":"residu_12","error":"L\'id passat com a paràmetre no correspon a cap residu."}',
    "63" => '{"codi_error":"residu_13","error":"Falten paràmetres per modificar el residu."}',
    "64" => '{"codi_error":"residu_14","error":"Error al carregar la imatge per modificar el residu."}',
    "65" => '{"codi_error":"punts_recollida_1","error":"No té permís per veure el llistat de punts de recollida"}',
    "66" => '{"codi_error":"token_10","error":"El token públic no és correcte."}',
    "67" => '{"codi_error":"punts_recollida_2","error":"No s\'ha passat per paràmetre cap identificador (id)."}',
    "68" => '{"codi_error":"punts_recollida_3","error":"El paràmetre passat com a identificador (id) no és vàlid o no retorna cap registre."}',
    "69" => '{"codi_error":"punts_recollida_4","error":"Només pot donar d\'alta usuaris administradors."}',
    "70" => '{"codi_error":"punts_recollida_5","error":"Falten paràmetres per poder donar d\'alta un punt de recollida. Recorda que com a mínim ha d\'haver: nom, descripció, imatge, actiu."}',
    "71" => '{"codi_error":"punts_recollida_6","error":"No s\'ha pogut carregar l\'imatge del punt de recollida."}',
    "72" => '{"codi_error":"punts_recollida_7","error":"', // missatge per excepció.
    "73" => '{"codi_error":"punts_recollida_8","error":"Falten paràmetres per poder modificar un punt de recollida. Recorda que com a mínim ha d\'haver: id."}',
    "74" => '{"codi_error":"punts_recollida_9","error":"Només pot modificar usuaris administradors."}',
    "75" => '{"codi_error":"punts_recollida_10","error":"Només pot donar de baixa usuaris administradors."}',
    "76" => '{"codi_error":"punts_recollida_11","error":"L\'id passat com a paràmetre no correspon amb cap punt de recollida."}',
    "77" => '{"codi_error":"poblacions_1","error":"', // missatge per excepció.
    "78" => '{"codi_error":"recollida_1","error":"Només pot recollir usuaris treballadors."}',
    "79" => '{"codi_error":"recollida_2","error":"No s\'ha rebut cap recollida vàlida."}',
    "80" => '{"codi_error":"recollida_3","error":"Error en la introducció de la transacció."}',
    "81" => '{"codi_error":"recollida_4","error":"Error en la introducció de la recollida."}',
    "82" => '{"codi_error":"recollida_5","error":"', // missatge per excepció.
    "83" => '{"codi_error":"recollida_6","error":"Error en la introducció del saldo de la recollida."}',
    "84" => '{"codi_error":"tipus_residu_10","error":"Aquest tipus de residu no existeix a la base de dades."}',
    "85" => '{"codi_error":"aplicacio_1","error":"No s\'ha enviat el mètode correcte."}',    
    "86" => '{"codi_error":"esdeveniments_1","error":"Només pot donar d\'alta usuaris administradors."}',
    "87" => '{"codi_error":"esdeveniments_2","error":"Falten paràmetres per poder donar d\'alta un esdeveniment. Recorda que com a mínim ha d\'haver: nom, descripció, valor, aforament, data, hora, població, imatge, actiu."}',
    "88" => '{"codi_error":"esdeveniments_3","error":"No s\'ha pogut carregar l\'imatge de l\'esdeveniment."}',
    "89" => '{"codi_error":"esdeveniments_4","error":"', // missatge per excepció.
    "90" => '{"codi_error":"esdeveniments_5","error":"No s\'ha passat per paràmetre cap identificador (id)."}',
    "91" => '{"codi_error":"esdeveniments_6","error":"El paràmetre passat com a identificador (id) no és vàlid o no retorna cap registre."}',
    "92" => '{"codi_error":"esdeveniments_7","error":"L\'id passat com a paràmetre no correspon amb cap esdeveniment."}',
    "93" => '{"codi_error":"esdeveniments_8","error":"Només pot modificar esdeveniments els usuaris administradors."}',
    "94" => '{"codi_error":"esdeveniments_9","error":"Falten paràmetres per poder modificar un esdeveniment. Recorda que com a mínim ha d\'haver: id, nom, descripció, valor, aforament, data, hora, població, imatge, actiu."}',
    "95" => '{"codi_error":"esdeveniments_10","error":"Falten paràmetres per poder modificar un esdeveniment. Recorda que com a mínim ha d\'haver: id."}',
    "96" => '{"codi_error":"esdeveniments_11","error":"No s\'ha pogut carregar l\'imatge del esdeveniment."}',
    "97" => '{"codi_error":"esdeveniments_12","error":"', // missatge per excepció.
    "98" => '{"codi_error":"esdeveniments_13","error":"L\'id passat com a paràmetre no correspon amb cap esdeveniment."}',
    "99" => '{"codi_error":"esdeveniments_14","error":"Només pot modificar usuaris administradors."}',
    "100" => '{"codi_error":"esdeveniments_15","error":"Falten paràmetres per poder donar d\'alta un esdeveniment. Recorda que com a mínim ha d\'haver: id, nom, descripció, valor, aforament, data, hora, població, imatge, actiu."}',
    
    "finalExcepcio" => '"}',
    
    
    
    
    
    
    
    "1000" => '{"codi_error":"usuaris_3","error":"No té permís per donar d\'alta un usuari."}'
    
);

?>