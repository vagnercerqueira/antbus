document.getElementById('files_bil').addEventListener('change', (ele) => {
	let dados_files = valida_files();
	document.querySelector(".table_files thead").innerHTML = "<tr><th class='text-center'>Total de arquivos: " + dados_files.tot + "</th></tr>";
	document.querySelector(".table_files tbody").innerHTML = dados_files.html;
});
function openDialog() {
	document.getElementById('files_bil').click();
	limpa_tabela();
	limpa_relogio();
}

document.querySelector('.cancel').addEventListener('click', (ele) => {
	limpa_tabela();
	limpa_relogio();
});

function limpa_tabela() {
	document.querySelector(".table_files tbody").innerHTML = "";
	document.querySelector(".table_files thead").innerHTML = "";
}
function limpa_relogio() {
	document.querySelector(".timer_upload_ini").innerHTML = "";
	document.querySelector(".timer_upload_fim").innerHTML = "";
	document.querySelector('.row_msg_upload').innerHTML = "";
}

function valida_files(file) {
	var fileInput = document.getElementById("files_bil");
	var files = fileInput.files;
	let dados_files = { tot: 0, html: [] }
	var rows = "";

	[...files].forEach((file, ind) => {
		var fname = (file.name).substr(0, 2);
		var cl = '';
		if (!(['TG', 'UD', 'ud'].includes(fname)))
			cl = "class='text-danger arquivo_invalido'";
		dados_files.tot++;
		dados_files.html += `<tr><td style='padding: 0px;' ` + cl + `><smal>` + (file.name) + `</smal></td></tr>`;
	});
	return dados_files;
}

async function uploadFile() {
	let return_data = { error: 0, message: '', rejeitados: [], info_card_upload: [] };
	let invalidos = document.querySelectorAll('.arquivo_invalido').length
	if (invalidos > 0) {
		error_alert("#form_upload", false, 'Remova da lista os arquivos com nomes invalidos em vermelho!!!', 1000);
		return false;
	}

	try {
		let data = new FormData(document.getElementById('form_upload'));
		let response = await fetch(pag_url + 'upload', {
			method: 'POST',
			credentials: 'same-origin',
			body: data
		});

		if (response.status != 200)
			throw new Error('HTTP response code != 200');

		let json_response = await response.json();

		if (json_response.error == 1)
			throw new Error(json_response.message);
		else {
			return_data.rejeitados = json_response.rejeitados
			return_data.info_card_upload = json_response.info_card_upload
		}

	}
	catch (e) {
		return_data = { error: 1, message: e.message };
	}

	return return_data;
}
//---------------------------------------------------------

const form_upload = document.getElementById('form_upload');
form_upload.addEventListener('submit', uploadSubmit);

async function uploadSubmit(event) {
	event.preventDefault();
	var fileInput = document.getElementById("files_bil");
	var files = fileInput.files;
	if (files.length > 0) {
		error_alert("#form_upload", 'loading', 'Processando...!!!', 1000);
		document.querySelector('.timer_upload_ini').innerHTML = "<i class='fas fa-hourglass'></i>&nbsp;Inicio: " + relogio();
		let upload_res = await uploadFile();

		document.querySelector('.timer_upload_fim').innerHTML = "<i class='far fa-hourglass'></i>&nbsp;Termino: " + relogio();
		toastr.clear();

		if (upload_res.error == 0) {
			error_alert("#form_upload", true, 'Arquivos processados com sucesso', 700);
			document.querySelector('.row_msg_upload').innerHTML = `<div class="col-md-12"><div class="alert alert-success">Arquivos processados com sucesso</div></div>`;

			var rejeitados = upload_res.rejeitados;
			let rows = "";
			limpa_tabela();
			document.getElementById('form_upload').reset();
			if (rejeitados.length > 0) {
				[...rejeitados].forEach(element => {
					rows += "<tr class='text-danger'><td style='padding: 0px;'>" + element + "</td><tr>";
				});
				document.querySelector(".table_files thead").innerHTML = "<tr><th class='text-center text-danger'>Arquivos com problema: " + (rejeitados.length) + "</th></tr>";
				document.querySelector(".table_files tbody").innerHTML = rows;
			}

			if ((upload_res.info_card_upload).length > 0) {
				document.querySelector(".qtd_carros").innerHTML = (upload_res.info_card_upload).length;
				document.querySelector(".ultima_data").innerHTML = (upload_res.info_card_upload[0].DT_ARQUIVO);
			}
		}
		else if (upload_res.error == 1) {
			error_alert("#form_upload", false, 'Falha ao processar arquivos', 700);
			document.querySelector('.row_msg_upload').innerHTML = `<div class="col-md-12"><div class="alert alert-danger">Falha no processamento dos arquivos</div></div>`;
		}

	} else {
		error_alert("#form_upload", false, 'Nenhum arquivo encontrado!!!', 1000);
	}
	return false;
}

function relogio() {
	var today = new Date();
	var hora = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
	return hora;
}