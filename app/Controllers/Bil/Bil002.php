<?php
/*
	DESCRICAO: [CONSULTAS]
	@AUTOR: Vagner Cerqueira
	DATA: 06/04/2020
*/

namespace App\Controllers\Bil;

use App\Controllers\BaseController;

class Bil002 extends BaseController
{
  private $db = null;

  public function __construct()
  {
    $this->db = db_connect();
  }
  public function index()
  {
    $data = [
      "arquivo_dataTable" => true,
      "carros_bil" => json_encode($this->retorna_carros(), JSON_FORCE_OBJECT),
    ];
    $this->load_template($data);
  }
  public function retorna_carros()
  {
    $sql = "SELECT distinct(NUM_CARRO) DESCRICAO, NUM_CARRO ID
				FROM antbus_bil_tipo_100";
    $rows = $this->db->query($sql)->getResultArray();
    return $rows;
  }

  public function transacao()
  {
	extract($this->request->getPost());
    $where = null;
	
	if($CARRO    != '') $where .=  " AND R.NUM_CARRO='{$CARRO}' ";			
	if($BOLSAO   != '') $where .=  " AND COALESCE(NULLIF(P.REPETIDO, ''), 'N')='{$BOLSAO}' ";
	if($STATUS   != '') $where .=  " AND P.STATUS={$STATUS}";
	if($LINHA    != '') $where .=  " AND (Q.COD_LINHA_PRINCIPAL='{$LINHA}') ";
	if($SENTIDO  != '') $where .=  " AND Q.SENTIDO='{$SENTIDO}' ";
	if($HRI      != '') $where .=  " AND P.HORA BETWEEN TIME_TO_SEC('{$HRI}')  AND  TIME_TO_SEC('{$HRF}')";
	
	if($EMBARQUE != ''){
		$where .=  $EMBARQUE == 'G' ? 
					' AND ( P.APLICACAO > 599 and P.valor_debitado  = 0 )' : 
					' AND ( ( P.APLICACAO <= 599 and P.valor_debitado = 0 ) OR (  P.valor_debitado > 0 ) ) ';
	}
	
    $sql = "SELECT 
				DATE_FORMAT(P.DATA, '%d/%m/%Y') DATA,
				SEC_TO_TIME(P.HORA) HORA,
				Q.TURNO,
				R.NUM_CARRO,
				Q.MOT_MATRICULA,
				P.VALOR_DEBITADO,
				CONCAT(P.NUM_SERIE,'-',P.DIG_VERIFICADOR) CARTAO,
				CASE Q.ESTADO_SERVICO WHEN 5 THEN 'Comercial' WHEN 4 THEN 'Placa' ELSE 'OUTROS' END ESTADO,
				Q.COD_LINHA_PRINCIPAL NR_LINHA,
				CASE Q.SENTIDO WHEN 0 THEN 'IDA' ELSE 'VOLTA' END AS SENTIDO,
				CASE WHEN ( P.APLICACAO <= 599 and P.valor_debitado = 0 ) OR (  P.valor_debitado > 0 ) 
					 THEN 'PAGANTE' ELSE 'GRATUIDADE' END EMBARQUE,
					  S.DESCRICAO AS APLICACAO,
				P.VALOR_TARIFA,
				P.TSN
			FROM antbus_bil_tipo_002 P
			INNER JOIN antbus_bil_tipo_001 Q ON Q.ID_ARQUIVO=P.ID_ARQUIVO AND P.SEQ_ESTADO=Q.SEQ
			INNER JOIN antbus_bil_tipo_100 R ON R.ID_ARQUIVO=Q.ID_ARQUIVO
			LEFT JOIN  antbus_bil_aplicacao S ON S.emissor=P.emissor_aplicacao AND S.aplicacao=P.aplicacao
			WHERE  	P.DATA BETWEEN '{$DTI}' AND '{$DTF}' 
				AND Q.estado_servico in ( 4,5 )		   
				{$where}
			ORDER BY P.DATA ASC, P.HORA ASC, R.NUM_CARRO";
	//print_r($sql);exit;
    $rows = $this->db->query($sql)->getResultArray(); 
    $retorno = ["data"  =>  $rows];
    echo json_encode($retorno);
  }

  
  /**************AQUI COMEÇA TRATAR TRANSACOES NO SEGUNDO CARD***************/
  public function intervalo()
  {
	extract($this->request->getPost());
    $where = null;
		
	$where_bolsao = ($BOLSAO   != '') ? " AND COALESCE(NULLIF(P.REPETIDO, ''), 'N')='{$BOLSAO}' " : null;
	$where_status = ($STATUS   != '') ? " AND P.STATUS={$STATUS}" : null;
	if($CARRO    != '') $where .=  " AND T.NUM_CARRO='{$CARRO}' ";
	if($LINHA    != '') $where .=  " AND (Q.COD_LINHA_PRINCIPAL='{$LINHA}') ";
	if($SENTIDO  != '') $where .=  " AND Q.SENTIDO='{$SENTIDO}' ";
	if($HRI      != '') $where .=  " AND Q.HORA BETWEEN TIME_TO_SEC('{$HRI}')  AND  TIME_TO_SEC('{$HRF}')";
	
    $sql = "
		SELECT * FROM
			(
			SELECT  
				SEC_TO_TIME(hr_comercial) HRI,
				SEC_TO_TIME(HF) HRF,
				num_carro CARRO,
				DATE_FORMAT(DATA, '%d/%m/%Y') DATA,
				cod_linha_principal LINHA,
				sentido SENTIDO,
				mot_matricula MOTORISTA,
				(
					SELECT COUNT(*)
					FROM antbus_bil_tipo_002 P
					INNER JOIN antbus_bil_tipo_100 N on N.id_arquivo=P.id_arquivo
					WHERE N.num_carro=Q1.num_carro
					AND  (
							CASE WHEN Q1.HF > Q1.hr_placa
								THEN ( P.data=Q1.data AND P.hora BETWEEN  Q1.hr_placa AND Q1.HF )
								ELSE ( 
										( P.data=(DATE_ADD(Q1.DATA, INTERVAL 1 DAY)) AND P.hora < Q1.HF ) OR
										( P.data=P.data AND P.hora > Q1.hr_placa )
									)
							END
						 )
					AND ( ( P.APLICACAO <= 599 and P.valor_debitado = 0 ) OR (  P.valor_debitado > 0 ) )
					{$where_bolsao}
					{$where_status}
				) PAGANTES,
				(
					SELECT COUNT(*)
					FROM antbus_bil_tipo_002 P
					INNER JOIN antbus_bil_tipo_100 N on N.id_arquivo=P.id_arquivo
					WHERE N.num_carro=Q1.num_carro
					AND  (
							CASE WHEN Q1.HF > Q1.hr_placa
								THEN ( P.data=Q1.data AND P.hora BETWEEN  Q1.hr_placa AND Q1.HF )
								ELSE ( 
										( P.data=(DATE_ADD(Q1.DATA, INTERVAL 1 DAY)) AND P.hora < Q1.HF ) OR
										( P.data=P.data AND P.hora > Q1.hr_placa )
									)
							END
						 )
					AND  ( P.APLICACAO > 599 and P.valor_debitado  = 0 )
					{$where_bolsao}
					{$where_status}					
					
				) GRATUIDADES
			FROM
				(
					SELECT 	Q.hora as hr_comercial, T.num_carro, Q.data,
							Q.cod_linha_principal, Q.sentido, Q.mot_matricula, hr_placa,
							(	
							  SELECT 
								CASE WHEN MIN(M.HORA) IS NULL THEN 
									(	
										SELECT MIN(M.HORA)
										FROM antbus_bil_tipo_001 M
										where M.id_arquivo=Q.id_arquivo and 
												M.DATA=(DATE_ADD(Q.DATA, INTERVAL 1 DAY))
												 and M.estado_servico = 4
									) ELSE MIN(M.HORA) END  
								
								FROM antbus_bil_tipo_001 M
								WHERE 	M.id_arquivo=Q.id_arquivo AND M.HORA>Q.hora and M.estado_servico = 4
							) HF
				
					FROM antbus_bil_tipo_001 Q 
					INNER JOIN antbus_bil_tipo_100 T ON T.ID_ARQUIVO=Q.ID_ARQUIVO
					WHERE 	T.tipo_arq != 'TGS'
						AND estado_servico = 5
						{$where}				
						AND ( ( Q.DATA='{$DTI}' AND Q.hr_placa >= 14400 ) OR ( Q.DATA = DATE_ADD('{$DTI}', INTERVAL 1 DAY ) AND Q.hr_placa < 14400 ) )
						
							/* ( Q.DATA BETWEEN '{$DTI}' AND '{$DTF}' AND Q.hr_placa >= 14400 ) OR 
							   ( Q.DATA = DATE_ADD('{$DTF}', INTERVAL 1 DAY ) AND Q.hr_placa < 14400 ) */
						
				) Q1
			) Q2
			WHERE PAGANTES > 0 OR GRATUIDADES > 0
			ORDER BY HRI";
	
    $rows = $this->db->query($sql)->getResultArray();
	
    $retorno = ["data"  =>  $rows];
    echo json_encode($retorno);
  }
  #CARTOES REJEITADOS
  public function rejeitados()
  {
	extract($this->request->getPost());
    $where = null;
	
	if($CARRO    != '') $where .=  " AND R.NUM_CARRO='{$CARRO}' ";			
	if($LINHA    != '') $where .=  " AND (Q.COD_LINHA_PRINCIPAL='{$LINHA}') ";
	if($SENTIDO  != '') $where .=  " AND Q.SENTIDO='{$SENTIDO}' ";
	if($HRI      != '') $where .=  " AND P.HORA BETWEEN TIME_TO_SEC('{$HRI}')  AND  TIME_TO_SEC('{$HRF}')";
	
    $sql = "SELECT 
				DATE_FORMAT(P.DATA, '%d/%m/%Y') DATA,
				SEC_TO_TIME(P.HORA) HORA,
				Q.TURNO,
				R.NUM_CARRO,
				Q.MOT_MATRICULA,
				CONCAT(P.NUM_SERIE,'-',P.DIG_VERIFICADOR) CARTAO,
				CASE Q.ESTADO_SERVICO WHEN 5 THEN 'Comercial' WHEN 4 THEN 'Placa' ELSE 'OUTROS' END ESTADO,
				Q.COD_LINHA_PRINCIPAL NR_LINHA,
				CASE Q.SENTIDO WHEN 0 THEN 'IDA' ELSE 'VOLTA' END AS SENTIDO,
				S.DESCRICAO AS APLICACAO,
				T.DESCRICAO ERRO
			FROM antbus_bil_tipo_005 P
			INNER JOIN antbus_bil_tipo_001 Q ON Q.ID_ARQUIVO=P.ID_ARQUIVO AND P.SEQ_ESTADO=Q.SEQ
			INNER JOIN antbus_bil_tipo_100 R ON R.ID_ARQUIVO=Q.ID_ARQUIVO
			LEFT JOIN  antbus_bil_aplicacao S ON S.emissor=P.emissor_aplicacao AND S.aplicacao=P.aplicacao
			LEFT JOIN  antbus_bil_msg_validador T ON T.codigo=P.codigo_erro 
			WHERE  	P.DATA BETWEEN '{$DTI}' AND '{$DTF}' 
				AND Q.estado_servico in ( 4,5 )		   
				{$where}
			ORDER BY P.DATA ASC, P.HORA ASC, R.NUM_CARRO";
	//print_r($sql);exit;
    $rows = $this->db->query($sql)->getResultArray(); 
    $retorno = ["data"  =>  $rows];
    echo json_encode($retorno);
  }  
}
