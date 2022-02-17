var tableBasicas = initDataTable();

function apos_editar(formu, data) {
	let estados = (data.BIL_ESTADOS_001).split(",");
	let tps = (data.BIL_TIPOS_REG).split(",");
	let inp_tps = document.querySelectorAll("#BIL_TIPOS_REG");
	let inp_estados = document.querySelectorAll("#BIL_ESTADOS_001");
	
	inp_tps.forEach(function(item){ if (tps.includes(item.value) !== false) item.checked = true; })
	inp_estados.forEach(function(item){ if (estados.includes(item.value) !== false) item.checked = true; })
}