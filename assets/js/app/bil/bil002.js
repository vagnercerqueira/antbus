var tableTransacao, tableIntervalo, tableRejeitados, tb_ativa, tot_pgt = 0, tot_grat = 0;
function transacoes(){
    if (tableTransacao != undefined)  tableTransacao.destroy();
	tableTransacao = $('#table_transacao').DataTable({
		processing: true,
		info: true,
		paging: false,
		pagingType: "full_numbers",
		ajax: {
			url: pag_url + "transacao",
			type: "POST",
			timeout: 15000,
			dataType: "json",
			data: function () { return $("#form_transacao").serialize() }
		},

		"columns": [
			{ "data": "DATA"},
			{ "data": "HORA" },
			{ "data": "ESTADO" },
			{ "data": "NUM_CARRO" },
			{ "data": "MOT_MATRICULA"  },
			{ "data": "NR_LINHA" },
			{ "data": "TURNO"  },
			{ "data": "SENTIDO" },
			{ "data": "EMBARQUE" },
			{ "data": "CARTAO" },
			{ "data": "TSN" },
			{ "data": "APLICACAO" },
			{ "data": "VALOR_DEBITADO"},
			{ "data": "VALOR_TARIFA"},
		//	{ "data": "ARQUIVO"},
		]
	});
}

function intervalo(){
	 if (tableIntervalo != undefined)  tableIntervalo.destroy();
	tableIntervalo = $('#table_intervalo').DataTable({
		processing: true,
		info: true,
		paging: false,
		pagingType: "full_numbers",
		ajax: {
			url: pag_url + "intervalo",
			type: "POST",
			timeout: 15000,
			dataType: "json",
			data: function () { return $("#form_transacao").serialize() }
		},
	"preDrawCallback": function (settings) {
		tot_pgt = 0;
		tot_grat = 0;
	},
	"footerCallback": function (row, data, start, end, display) {

		$(".pag_int").text(tot_pgt);
		$(".grt_int").text(tot_grat);
		$(".total_intervalo").text(tot_pgt + tot_grat);
		//$(".tot_pass").text(tot_pgt + tot_grat);

	},
	"rowCallback": function (row, data) {
		vlr_pgtt = parseInt(data.PAGANTES);
		vlr_grat = parseInt(data.GRATUIDADES);

		tot_pgt += vlr_pgtt;
		tot_grat += vlr_grat;

	},
		"columns": [
			{ "data": "DATA"},
			{ "data": "LINHA"},
			{ "data": "SENTIDO"},
			{ "data": "CARRO"},
			{ "data": "HRI"},
			{ "data": "HRF"},
			{ "data": "MOTORISTA"},
			{ "data": "PAGANTES"},
			{ "data": "GRATUIDADES"},
		]
	});	
	
}

function rejeitados(){
    if (tableRejeitados != undefined)  tableRejeitados.destroy();
	tableRejeitados = $('#table_rejeitados').DataTable({
		processing: true,
		info: true,
		paging: false,
		pagingType: "full_numbers",
		ajax: {
			url: pag_url + "rejeitados",
			type: "POST",
			timeout: 15000,
			dataType: "json",
			data: function () { return $("#form_transacao").serialize() }
		},

		"columns": [
			{ "data": "DATA"},
			{ "data": "HORA" },
			{ "data": "ESTADO" },
			{ "data": "NUM_CARRO" },
			{ "data": "MOT_MATRICULA"  },
			{ "data": "NR_LINHA" },
			{ "data": "TURNO"  },
			{ "data": "SENTIDO" },
			{ "data": "CARTAO" },
			{ "data": "APLICACAO" },
			{ "data": "ERRO"},
		]
	});
}

//const form_transacao = document.getElementById('form_transacao');
const form_transacao = document.getElementById('DTF');
form_transacao.addEventListener('blur', consulta_transacao);
function consulta_transacao(ev) {
	ev.preventDefault();
	if(tb_ativa == 'transacoes')
		transacoes();
	if(tb_ativa == 'intervalo')
		intervalo();
	if(tb_ativa == 'rejeitados')
		rejeitados();	
		
}
function eventos_table(n){
	$("#modal-transacoes").modal('show');
	if( n == 1 ){
		transacoes();
		tb_ativa = 'transacoes';
		$(".row_transacao, .transac").show();
		$(".row_intervalo, .row_rejeitados").hide();
		$("#modal-transacoes .modal-header h5").html('<b>TRANSAÇÕES</b>');
		return;
	}
	if( n == 2 ){
		intervalo();
		tb_ativa = 'intervalo';
		$(".row_intervalo").show();
		$(".row_transacao, .row_rejeitados, .transac").hide();				
		$("#modal-transacoes .modal-header h5").html('<b>INTERVALOS</b>');
		return;
	}
	if( n == 3 ){
		rejeitados();
		tb_ativa = 'rejeitados';
		$(".row_rejeitados").show();
		$(".row_transacao, .row_intervalo, .transac").hide();				
		$("#modal-transacoes .modal-header h5").html('<b>CARTOES REJEITADOS</b>');
		return;
	}	
}
$('#modal-transacoes').on('hidden.bs.modal', function () {
  document.getElementById('form_transacao').reset();
})
/****************FUNCAO PARA TRATAR CARD INTERVALO DE HORARIO******************** */
/*
var tot_pgt = 0;
var tot_grat = 0;
var tableIntervalo = $('.table_intervalo').DataTable({
	processing: true,
	info: true,
	paging: false,
	pagingType: "full_numbers",
	ajax: {
		url: pag_url + "intervalo",
		type: "POST",
		timeout: 15000,
		dataType: "json",
		data: function (d) {
			d['VEICULO'] = document.getElementById("VEICULO_INTER").value;
			d['DATA_INTER'] = document.getElementById("DATA_INTER").value;
			d['HR_INI_INTER'] = document.getElementById("HR_INI_INTER").value;
			d['HR_FIM_INTER'] = document.getElementById("HR_FIM_INTER").value;
		}
	},
	"preDrawCallback": function (settings) {
		tot_pgt = 0;
		tot_grat = 0;
	},
	"footerCallback": function (row, data, start, end, display) {

		$(".pag_int").text(tot_pgt);
		$(".grt_int").text(tot_grat);
		$(".total_intervalo").text(tot_pgt + tot_grat);
		//$(".tot_pass").text(tot_pgt + tot_grat);

	},
	"rowCallback": function (row, data) {
		vlr_pgtt = parseInt(data.PAGANTES);
		vlr_grat = parseInt(data.GRATUIDADES);

		tot_pgt += vlr_pgtt;
		tot_grat += vlr_grat;

	},
	"columns": [
		{ data: "DATA"},
		{ data: "LINHA"},
		{ data: "SENTIDO"},
		{ data: "CARRO"},
		{ data: "HRI"},
		{ data: "HRF"},
		{ data: "MOTORISTA"},
		{ data: "PAGANTES"},
		{ data: "GRATUIDADES"},
	]
});
const form_intervalo = document.getElementById('form_intervalo');
form_intervalo.addEventListener('submit', consulta_intervalo);

async function consulta_intervalo(ev) {
	ev.preventDefault();
	tableIntervalo.ajax.reload();
}
*/