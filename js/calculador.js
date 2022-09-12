function calculaCuota() {
	var valorCuota = 0;
	var interes = 0;
	var cuotaConInteres = 0;
    if (document.getElementById("monto")) {
		var monto = Number(document.getElementById("monto").value);
	}
	if (document.getElementById("interes")) {
		var porcentajeInteres = Number(document.getElementById("interes").value);
	}
    if (document.getElementById("cuotas")) {
		var cuotas = Number(document.getElementById("cuotas").value);
	}
	if((porcentajeInteres!=0)&&(monto!=0)&&(cuotas!=0)){
	valorCuota = monto/cuotas;
	interes = (monto * porcentajeInteres)/100;
	cuotaConInteres = valorCuota+interes;
	}
	document.getElementById('cuotaTotal').value = cuotaConInteres.toFixed();
}