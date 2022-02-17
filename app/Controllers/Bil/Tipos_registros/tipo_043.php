<?php

/**
 * Tipo 043 - Registro tipo 043 – PRESENCE REVAL -  Gerado sempre que um cartão escolar é apresentado para o processo de revalidação.
 * @author Vagner Cerqueira
 * @copyright News Systems 02/2021
 * @license
 * @package application
 * @subpackage controllers

 */
require_once('tipos.php');
class Tipo_043 extends Tipos
{
    public function set_dados($lin, $assoc_param=false)
    {
        $dados = [ 
            'VERSAO' => substr($lin, 3, 3),
            'DATA' => $this->data_juliana(substr($lin, 6, 5)),
            'HORA' => substr($lin, 11, 5),
            'DATA_REVALIDACAO' => $this->data_juliana(substr($lin, 16, 5)),
            'HORA_REVALIDACAO' => substr($lin, 21, 5),
            'NUMERO_INTERNO' => substr($lin, 26, 20),            
            'EMISSOR_CARTAO' => substr($lin, 46, 3),
			'DESENHO' => substr($lin, 49, 2),
			'NUM_SERIE' => substr($lin, 51, 8),
			'APLICACAO' => substr($lin, 59, 4),
			'EMISSOR_APLICACAO' => substr($lin, 63, 3),
			'RSN' => substr($lin, 66, 5),
            'TSN' => substr($lin, 71, 5),
			'DEVICE_ID' => substr($lin, 76, 5),
			
            'TYPE' => null,
            'PROVIDER_ID' => null,
            'ASSINATURA' => null,
        ];
        $versao = "versao_" . substr($lin, 3, 3);
        $dados = $this->$versao($lin, $dados);
        if($assoc_param === true){
            $dados = $this->associa_parametros($dados);
        }        
        return $dados;
    }

    public function versao_001($lin, $dados)
    {
        $dados['ASSINATURA'] = substr($lin, 81, 4);
        return $dados;
    }
    public function versao_002($lin, $dados)
    {
        $dados['TYPE'] = substr($lin, 81, 1);
        $dados['ASSINATURA'] = substr($lin, 82, 4);
        return $dados;
    }
    public function versao_003($lin, $dados)
    {
		$dados['TYPE'] = substr($lin, 81, 1);
        $dados['PROVIDER_ID'] = substr($lin, 82, 10);
        $dados['ASSINATURA'] = substr($lin, 92, 4);
        return $dados;
    }
}
