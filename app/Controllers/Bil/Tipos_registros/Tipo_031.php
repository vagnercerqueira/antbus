<?php

/**
 * Tipo 031–Mode Show-Quando a função mostra saldo é ativada e o cartão de vale transporte é apresentado
 * @author Vagner Cerqueira
 * @data 06/2021
 */

namespace App\Controllers\Bil\Tipos_registros;

use App\Controllers\Bil\Tipos_registros\Tipos;

class Tipo_031 extends Tipos
{
    public function set_dados($lin, $dadosExtra, $assoc_param = false)
    {
        $dt = $this->data_juliana(substr($lin, 6, 5));
        $dt_cart_a = $this->data_juliana(substr($lin, 57, 5));
        $dt_cart_b = $this->data_juliana(substr($lin, 62, 5));

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
            'DATA_CARTEIRA_A' => $dt_cart_a,
            'DATA_CARTEIRA_B' => $dt_cart_b,
            'VALOR_CARTEIRA_A' => substr($lin, 67, 6),
            'VALOR_CARTEIRA_B' => substr($lin, 73, 6),
            //'ASSINATURA' => substr($lin, 79, 4)
        ];
        return $dados;
    }
}
