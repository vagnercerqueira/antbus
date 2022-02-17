<?php

/**
 * Tipo 032–Fiscal Liber-Registro que indica liberação da catraca sem contabilização.-Quando o operador seleciona a função: Fiscal Liber
 * @author Vagner Cerqueira
 * @data 06/2021
 */

namespace App\Controllers\Bil\Tipos_registros;

use App\Controllers\Bil\Tipos_registros\Tipos;

class Tipo_032 extends Tipos
{
    public function set_dados($lin, $dadosExtra, $assoc_param = false)
    {
        $dt = $this->data_juliana(substr($lin, 6, 5));
        $dados = [
            'VERSAO' => substr($lin, 3, 3),
            'DATA' => $dt,
            'HORA' => substr($lin, 11, 5),
            'EMISSOR' => substr($lin, 16, 3),
            'DESENHO' => substr($lin, 19, 2),
            'NUMERO_SERIE' => substr($lin, 21, 8),
            'DIGITO_VERIFICADOR' => substr($lin, 29, 1),
            'NUMERO_INTERNO' => substr($lin, 30, 20),
            'APLICACAO' => substr($lin, 50, 4),
            'EMISSOR_APLICACAO' => substr($lin, 54, 3),
            'ASSINATURA' => substr($lin, 57, 4)
        ];
        return $dados;
    }
}
