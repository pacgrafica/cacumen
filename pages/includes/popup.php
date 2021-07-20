<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

</head>
<style>
.centrado {
    text-align: center;
    font-family: sans-serif;
    margin: 0;
}

.modal {
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.8);
    
    
    top: 0;
    left: 0;
    
    display: flex;
    
    animation: modal 2s 3s forwards;
    visibility: hidden;
    opacity: 0;
}

.pop {
    margin: auto;
    width: 40%;
    height: 40%;
    background: white;
    border-radius: 10px;
	
}

#cerrar {
    display: none;
	
}

#cerrar + label {
    position: fixed;
    color: #fff;
    font-size: 25px;
    z-index: 2000;
    background: darkred;
    height: 40px;
    width: 40px;
    line-height: 40px;
    
	top:0;
	left:0;
    cursor: pointer;
	
    
    animation: modal 2s 3s forwards;
    visibility: hidden;
    opacity: 0;

}

#cerrar:checked + label, #cerrar:checked ~ .modal {
    display: none;
}

@keyframes modal {
    100% {
        visibility: visible;
        opacity: 1;
    }
}
</style>
<body>
<div class="centrado">
<input type="checkbox" id="cerrar">
        <label for="cerrar" id="btn-cerrar">X</label>
        <div class="modal">
            <div class="pop">
                <h2>Información</h2>
                A partir del 1 de Junio 2016, Los precios de las facturas y tareas subidas a la plataforma NO DEBEN CONTENER CARACTERES ESPECIALES <br /> EJ: ($ espacios o puntos).
                <br /><br />La forma de ingresarlos es la siguiente EJ: ( 300000 )
            </div>
        </div>
</div>    
       
</body>
</html>
