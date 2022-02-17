<?php

/**
 * Tipo 006 – Upgrade de Cartão - Quando o cartão sofrer um Upgrade definido pelo validador.
 * @author Vagner Cerqueira
 * @data 29/03/2021
 * @package application
 */

namespace App\Controllers\Bil\Tipos_registros;

use App\Controllers\Bil\Tipos_registros\Tipos;
class Tipo_006 extends Tipos
{
    public function set_dados($lin, $dadosExtra, $assoc_param = false)
    {
        $dt = $this->data_juliana(substr($lin, 6, 5));
        $dados = [
			'SEQ_ESTADO' => $dadosExtra['ID_001'],
            'VERSAO' => substr($lin, 3, 3),
            'DATA' => $dt,
            'HORA' => substr($lin, 11, 5),
            'NUMERO_INTERNO' => substr($lin, 16, 20),
            'APLICACAO' => substr($lin, 36, 4),
            'EMISSOR_APLICACAO' => substr($lin, 40, 3),
            'CAMPO' => substr($lin, 43, 2),
            'VALOR_ANTIGO' => substr($lin, 45, 5),
            'VALOR_NOVO' => substr($lin, 50, 5),
            //'ASSINATURA' => substr($lin, 55, 4)
        ];
        return $dados;
    }
}