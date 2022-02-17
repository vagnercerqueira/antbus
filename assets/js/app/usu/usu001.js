var tableBasicas = initDataTable();
//------------------------------------------------------
var desab_status = (e) => {
	form = document.getElementById("form_usuarios");
	stt = e.getAttribute('st');
	stTxt = e.textContent;
	chave = e.getAttribute("data-id");
	oData = new FormData();
	oData.append('chave', chave);
	oData.append('stat', stt);

	error_alert(form, 'loading', '')
	fetch(pag_url + "altera_status", {
		method: 'POST',
		body: oData,
	})
		.then(response => response.json())
		.then(json => {
			toastr.clear();
			if (json.TOT > 0) {
				var s = true;
				var msg = "Alteração efetuada com sucesso!!";
				dropDwn = e.closest('.dropdown');
				texto = dropDwn.querySelector('.txtativ');
				texto.textContent = stTxt;
				if (stt == 'A') {
					texto.classList.add('btn-success');
					texto.classList.remove('btn-warning');
				} else {
					texto.classList.remove('btn-success');
					texto.classList.add('btn-warning');
				}
				setTimeout(function () { error_alert(form, true, 'Status Alterado!!!'); }, 600);
			} else {
				setTimeout(function () { error_alert(form, false, 'Erro ao alterar Status!!!'); }, 600);
			}
		})
		.catch(function (error) {
			toastr.clear();
			setTimeout(function () { error_alert(form, false, 'Erro ao alterar permissao!!!'); }, 600);
			console.log("ocorreu algum erro");
		});
}
function reset_senha(v){
	$("#modal_reset_senha").modal('show');
	document.getElementById("btn_conf_senha").setAttribute('data-chave', v);
}
function conf_resetar_senha(e){

	chave = e.getAttribute("data-chave");
	oData = new FormData();
	oData.append('chave', chave);
	
	error_alert('#modal_reset_senha', 'loading', '')
	fetch(pag_url + "conf_altera_senha", {
		method: 'POST',
		body: oData,
	}).then(response => response.json())
	.then(json => {
		toastr.clear();
		if (json.TOT > 0) {
			setTimeout(function () { error_alert('#modal_reset_senha', true, 'Senha resetada!!!'); }, 600);
			$("#modal_reset_senha").modal('hide');
		} else {
			setTimeout(function () { error_alert('#modal_reset_senha', false, 'Erro ao resetar senha!!!'); }, 600);
		}
	})
	.catch(function (error) {
		toastr.clear();
		setTimeout(function () { error_alert('#modal_reset_senha', false, 'Erro ao alterar a senha!!!'); }, 600);
		console.log("ocorreu algum erro");
	});	
}