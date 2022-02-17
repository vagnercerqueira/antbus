<?php

/**
 * Tipo 001 - Registro que indica qual é o estado atual do validador e o horário de alteração deste estado
 * @author Vagner Cerqueira
 * @data 29/03/2021
 * @package application
 */

namespace App\Controllers\Bil\Tipos_registros;

use App\Controllers\Bil\Tipos_registros\Tipos;

class Tipo_001 extends Tipos
{
    public function set_dados($lin, $dadosExtra)
    {
        $dt = $this->data_juliana(substr($lin, 22, 5));
		$turno = ( ( substr($lin, 27, 5)) < 39600 ? 1 : 2 );
        $dados = [
            'SEQ' => $dadosExtra['ID_001'],
            'VERSAO' => substr($lin, 3, 3),
            'TSP' => substr($lin, 6, 3),            
			//'NUM_CARRO' => substr($lin, 9, 10),
            'ESTADO_SERVICO' => substr($lin, 19, 3),
            'DATA' => $dt,
            'HORA' => substr($lin, 27, 5),
            //'MOT_TSP' => substr($lin, 32, 3),
            //'MOT_PRODATA' => substr($lin, 35, 10),
            'MOT_MATRICULA' => ( $dadosExtra['TIPO_ARQ'] != 'TGS' ? substr($lin, 45, 10) : $dadosExtra['MOTORISTA'] ),
            //'COB_TSP' => substr($lin, 55, 3),
            //'COB_PRODATA' => substr($lin, 58, 10),
            'COB_MATRICULA' => substr($lin, 68, 10),
            'COD_LINHA_DETALHE' => substr($lin, 78, 5),
            'COD_LINHA_PRINCIPAL' => substr($lin, 83, 5),
            'COD_LINHA_SECAO' => substr($lin, 88, 3),
            'SENTIDO' => substr($lin, 91, 3),
            'TURNO' => $turno,
			'HR_PLACA' => $dadosExtra['HR_PLACA'],
            //'ASSINATURA' => substr($lin, 95, 4)
        ];
		
        return $dados;
    }
}
