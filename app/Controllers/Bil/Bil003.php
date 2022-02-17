<?php
/*
	DESCRICAO: [CADASTRO DE PARAMETRO GERAL]
	@AUTOR: Vagner Cerqueira
	DATA: 06/2021
*/

namespace App\Controllers\Bil;

use App\Controllers\BaseController;
use App\Models\Bil\Param_geral_Model;
use Datatables_server_side;

class Bil003 extends BaseController
{
	private $importar_tipo = [	
								'003'=>'Total transações de uso',
								'004'=>'Tempo esgotado Catraca',
								'005'=>'Cartão rejeitado',
								'006'=>'Upgrade de Cartão', 
								'007'=>'Modo Socorro', 
								'010'=>'Ponto hr vinculo/desvinc)', 
								'011'=>'Ponto de Checagem.', 
								'020'=>'Dados de Coleta Mestre', 
								'021'=>'Dados de Coleta Detalhe', 
								'022'=>'Dados Trans Mula Mestre', 
								'023'=>'Dados Trans Mula Detalhe', 
								'030'=>'Time Registrated',
								'031'=>'Mode Show',
								'032'=>'Fiscal Liber', 
								'033'=>'Onboard Liber', 
								'034'=>'Statistical counter', 
								'035'=>'Device Especial', 
								'036'=>'Access Control', 
								'044'=>'Revalidation Card', 
								'045'=>'PowerUp'
							];
	private $estados_001 = ['001', '002', '003'];
	
	public function __construct()
	{
		$this->tbs_crud  = ['form_param_geral' => PREFIXO_TB.'bil_res_parametro_geral'];
	}
	public function index()
	{
		$data = [
			"arquivo_dataTable" => true,
			//"arquivo_js" => ['jquery.mask.min'],
			"option_import_tipos" => $this->importar_tipo,
			"option_estados_001" => $this->estados_001,
		];
		$this->load_template($data);
	}
	public function  preInsUpd($data)
	{
		$tps_reg = $this->request->getPost('BIL_TIPOS_REG');
		$estados001 = $this->request->getPost('BIL_ESTADOS_001');
		
		$data['BIL_TIPOS_REG'] = (is_array($tps_reg)) ? implode(',', $tps_reg) : "";
		$data['BIL_ESTADOS_001'] = (is_array($estados001)) ? implode(',', $estados001) : "";
		return $data;
	}
	public function post_edicao($data)
	{
		return $data;
	}

	public function DataTable()
	{
		$sql = "SELECT BIL_TIPOS_REG, BIL_ESTADOS_001, A.id FROM ".PREFIXO_TB."bil_res_parametro_geral A";

		$dt = new Datatables_server_side([
			'tb' => PREFIXO_TB."bil_res_parametro_geral",
			'cols' => ["BIL_TIPOS_REG", "BIL_ESTADOS_001"],
		]);
		$dt->complexQuery($sql);
	}	
}
