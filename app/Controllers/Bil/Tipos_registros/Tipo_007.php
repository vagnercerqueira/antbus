<?php

/**
 * Tipo 007 – Modo Socorro - Quando o passageiro passa na roleta com o validador no modo socorro
 * @author Vagner Cerqueira
 * @data 29/03/2021
 * @package application
 */

namespace App\Controllers\Bil\Tipos_registros;

use App\Controllers\Bil\Tipos_registros\Tipos;
class Tipo_007 extends Tipos
{
	public function set_dados($lin, $dadosExtra, $assoc_param = false)
    {
        $dt_ini = $this->data_juliana(substr($lin, 6, 5));
        $dt = $this->data_juliana(substr($lin, 16, 5));

        $dados = [
			'SEQ_ESTADO' => $dadosExtra['ID_001'],
            'VERSAO' => substr($lin, 3, 3),
            'DATA_INICIO' => $dt_ini,
            'HORA_INICIO' => substr($lin, 11, 5),
            'DATA' => $dt,
            'HORA' => substr($lin, 21, 5),
            'ONIBUS_ORIGEM' => substr($lin, 26, 10),
            'TSN' => substr($lin, 36, 5),
           // 'ASSINATURA' => substr($lin, 41, 4)
        ];
        return $dados;
    }
}
