<?php
/*
	DESCRICAO: [PROCESSAMENTO DOS ARQUIVOS DA BILHETAGEM]
	@AUTOR: Vagner Cerqueira
	DATA: 27/03/2020
*/

namespace App\Controllers\Bil;
use App\Models\Bil\Param_geral_Model;
use App\Controllers\BaseController;
class Bil001 extends BaseController
{
	private $importar_tipo = ['001', '002','100'];//DEFAULT 
	private $importar_tipo_001 = ['004', '005'];//DEFAULT 
	private $dir_bil = null;
	private $filesDelete = [];
	private $arquivos_salvos = [];
	private $tipos_inserir = [];
	private $db = null;
	private $idenf001 = [];

	public function __construct()
	{
		$this->db = db_connect();
		$this->dir_bil =  WRITEPATH . 'uploads/bil/';
	}
	public function index()
	{	
		$data = ["dados_card_upload" => $this->info_card_upload()];
		$this->load_template($data);
	}
	public function info_card_upload()
	{
		$sql = "SELECT COUNT(*) TOT, num_carro CARRO,  DATE_FORMAT(A.data_arquivo, '%d/%m/%Y') DT_ARQUIVO
				FROM `antbus_bil_tipo_100` A
				WHERE A.data_arquivo=
				(
					SELECT MAX(`data_arquivo`)
					FROM antbus_bil_tipo_100 B
				)
				GROUP BY num_carro";

		$query = $this->db->query($sql);

		$rows = $query->getResultArray();
		return $rows;
	}
	/**************AQUI COMEÇA TRATAR UPLOAD DE ARQUIVOSDO PRIMEIRO CARD***************/
	public function upload()
	{
		$files = $_FILES['files_bil'];
		$arr_resposta = ["error" => 0, "message" => "", "rejeitados" => [], "info_card_upload" => []];

		$zip = new \ZipArchive;
		 
		$this->instancia_classes();
		
		foreach ($files['name'] as $ind => $file) {
			$tipo = strtoupper(substr($file, -4)); // arquivo aceito, .txt e .zip ou .rar
			$inicial = strtoupper(substr($file, 0, 2)); // nomes especifico aceitos TG(CASO DE ARQUIVO), UD em caso de compactado
		
			if (in_array($tipo, ['.TXT',  '.ZIP']) && in_array($inicial, ['TG', 'UD'])) {
				//1. move_uploaded_file($files['tmp_name'][$ind], ($this->dir_bil . $file));
				if (in_array($tipo, ['.ZIP'])) {
					//$zip->open($this->dir_bil . $file);
					$zip->open($files['tmp_name'][$ind]);
					$zip->extractTo($this->dir_bil);
					$zip->close();
					//unlink($this->dir_bil . $file);
					foreach (scandir($this->dir_bil, 1) as $ud) {
						if ($ud === '.' || $ud === '..') continue;
						if (is_dir($this->dir_bil  . $ud)) {
							$sub_ud = scandir($this->dir_bil .  $ud);
							foreach ($sub_ud as $tg) {
								if ($tg === '.' || $tg === '..') continue;
								$fileRows = file($this->dir_bil . $ud . '/' .  $tg);
								$this->processa_arquivo($tg, $fileRows);
							}
							$this->remove_folder($this->dir_bil . $ud);
						} else {
							$fileRows = file($this->dir_bil . $ud);
							$this->processa_arquivo($ud, $fileRows);
							unlink($this->dir_bil . $ud);
						}
					}
				} else {
					$fileRows = file($files['tmp_name'][$ind]);
					$this->processa_arquivo($file, $fileRows);
				}
			} else {
				array_push($arr_resposta['rejeitados'], $file);
			}
		}

		if (count($this->tipos_inserir) > 0) $this->insere_tipos();
		$arr_resposta['info_card_upload'] = $this->info_card_upload();		
		echo json_encode($arr_resposta);
	}

	public function instancia_classes()
	{
		$parametros = new Param_geral_Model();
		$paramRows = $parametros->first(); // print_r( explode(',',$paramRows['bil_tipos_reg'] ));exit;
		if(count($paramRows) > 0){
			$this->importar_tipo = array_merge($this->importar_tipo,( explode(',',$paramRows['bil_tipos_reg'] )));		
			$this->importar_tipo_001 = array_merge($this->importar_tipo_001,( explode(',',$paramRows['bil_estados_001'] )));
		}		
		foreach($this->importar_tipo as $v){
			$class = 'Tipo_'.$v; 
			$cl = "App\Controllers\Bil\Tipos_registros\\".$class;
			$this->$class = new $cl();
		}
	}
	public function processa_arquivo($arquivo, $fileRows)
	{
		$detArq = explode('_', $arquivo);
		$dt_arquivo = substr($detArq[5], 0, 4) . "/" . substr($detArq[5], 4, 2) . "/" . substr($detArq[5], 6, 2);
		$id_arq = trim($detArq[1] . $detArq[5]);
		$dadosExtra = 	[ 	'DT_ARQUIVO' => $dt_arquivo, 
							'NUM_CARRO' => $detArq[1],
							'MOTORISTA'=>0, 
							'HR_PLACA'=>'',
							'ID_ARQUIVO'=> $id_arq,
							'TIPO_ARQ'=>substr($arquivo, 0, 3),
							'RGATUAL'=>null,
							'REPETIDO'=>null,
							'ID_001'=>0,
							'DATA_CAD'=>(date('d/m/Y'))
						];
							
		foreach ($fileRows as $i => $lin) {
			$tpReg = substr($lin, 0, 3);
			if (in_array($tpReg, $this->importar_tipo)) {				
				if ($tpReg == '100') { //documentacao diz que nao pode ocorrer 100 mais de uma vez, porem pode sim.
					if (in_array($dadosExtra['ID_ARQUIVO'], $this->filesDelete)) continue;
					array_push($this->filesDelete, $dadosExtra['ID_ARQUIVO']);
				}

				if ($tpReg == '001') {
					if (!in_array(substr($lin, 19, 3), $this->importar_tipo_001)) continue;
					$turno = ( ( substr($lin, 27, 5)) < 39600 ? 1 : 2 );
					$infoMot = substr($lin, 22, 5).$dadosExtra['NUM_CARRO'].$turno.substr($lin, 83, 5);
					$dadosExtra['ID_001'] = $dadosExtra['ID_001']+1;
					
					if(substr($dadosExtra['TIPO_ARQ'],0,3) == 'TGM') $this->idenf001[$infoMot] = substr($lin, 45, 10);
					if(substr($dadosExtra['TIPO_ARQ'],0,3) == 'TGS' && array_key_exists( $infoMot, $this->idenf001 ) ) $dadosExtra['MOTORISTA'] = $this->idenf001[$infoMot];//arquivo tgs n vem com motorista, por isso seto aqui					
					
					if(substr($lin, 19, 3) == 4) $dadosExtra['HR_PLACA'] = substr($lin, 27, 5);
									
				}

				if ($tpReg === '002') {
					$repet = (substr($lin, 57, 5) > 0) && ($dadosExtra['RGATUAL'] == substr($lin, 21, 41)) ? 'S' : '';
					$dadosExtra['RGATUAL'] = substr($lin, 21, 41);
					$dadosExtra['REPETIDO'] = $repet;
				}

				$class = 'Tipo_' . $tpReg;
				
				if ($tpReg == '034') { // registro 034 possui mais de uma aplicacao por linha, entao vou inserir no banco por aplicacao, quebrando a linha.
					$compl = trim(substr($lin, 86));
					$qtdCompl = strlen($compl);
					$j = 0;
					while ($j < $qtdCompl) {
						$dados = $this->$class->set_dados($lin, $compl, $dadosExtra);
						$dados['ID_ARQUIVO'] = $dadosExtra['ID_ARQUIVO'];
						$this->tipos_inserir[$tpReg][] = $dados;
						$j += 32;
					}
				} else {
					$dados = $this->$class->set_dados($lin, $dadosExtra);
					$dados['ID_ARQUIVO'] = $dadosExtra['ID_ARQUIVO'];
					$this->tipos_inserir[$tpReg][] = $dados;
				}
			}
		}
		if (array_key_exists('002', $this->tipos_inserir) && count($this->tipos_inserir['002']) > 5000) $this->insere_tipos();
	}

	public function insere_tipos()
	{	
		$this->db->query("DELETE FROM " . PREFIXO_TB . "bil_tipo_100 WHERE id_arquivo in ('" . implode("','", $this->filesDelete) . "')");
		//print_r($this->tipos_inserir);exit;
		foreach ($this->tipos_inserir as $tp => $cols) $this->db->table(PREFIXO_TB . 'bil_tipo_' . $tp)->insertBatch($cols);		
		$this->tipos_inserir = [];
		$this->filesDelete = [];
	}
}