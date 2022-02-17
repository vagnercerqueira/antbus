<?php

/**
 * Tipo 036–ACCESS CONTROL-É gerado quando sai do estado de comercial e existe diferença de passagens entre a entrada e saída
 * @author Vagner Cerqueira
 * @data 06/2021
 */

namespace App\Controllers\Bil\Tipos_registros;

use App\Controllers\Bil\Tipos_registros\Tipos;

class Tipo_036 extends Tipos
{
    public function set_dados($lin, $dadosExtra, $assoc_param = false)
    {
        $dt = $this->data_juliana(substr($lin, 6, 5));
        $dados = [
            'VERSAO' => substr($lin, 3, 3),
            'DATA' => $dt,
            'HORA' => substr($lin, 11, 5),
            'ENTRADA' => substr($lin, 16, 8), //ENTRY
            'SAIDA' => substr($lin, 24, 8), //EXIT
            'TOTAL' => substr($lin, 32, 8),
            //'ASSINATURA' => substr($lin, 40, 4)
        ];
        return $dados;
    }
}
