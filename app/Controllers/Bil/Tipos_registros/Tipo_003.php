<?php

/**
 * Tipo 003 - Totalização de transações de uso - Registro que totaliza o uso dos cartões em um determinado estado.
 * @author Vagner Cerqueira
 * @data 16/2021
 * @package application

 */
namespace App\Controllers\Bil\Tipos_registros;

use App\Controllers\Bil\Tipos_registros\Tipos;

class Tipo_003 extends Tipos
{
    public function set_dados($lin, $dadosExtra, $assoc_param = false)
    {
        $dt = $this->data_juliana(substr($lin, 81, 5));
        $dados = [
			'SEQ_ESTADO' => $dadosExtra['ID_001'],
            'VERSAO' => substr($lin, 3, 3),
            'APLICACAO' => substr($lin, 6, 4),
            'EMISSOR_APLICACAO' => substr($lin, 10, 3),
            'QTD_EM_ROLETADAS' => substr($lin, 13, 5),
            'QTD_EM_VALOR' => substr($lin, 18, 7),
           // 'NUM_CARRO' => substr($lin, 25, 10),
           // 'MOT_TSP' => substr($lin, 35, 3),
           // 'MOT_PRODATA' => substr($lin, 38, 10),
            //'MOT_MATRICULA' => substr($lin, 48, 10),
           // 'COB_TSP' => substr($lin, 58, 3),
           // 'COB_PRODATA' => substr($lin, 61, 10),
            //'COB_MATRICULA' => substr($lin, 71, 10),
            'DATA' => $dt,
            'HORA' => substr($lin, 86, 5),
            //'ASSINATURA' => substr($lin, 91, 4)
        ];

        return $dados;
    }
}
