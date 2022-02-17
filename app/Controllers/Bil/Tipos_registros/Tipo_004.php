<?php

/**
 * Tipo 004 – Tempo esgotado de Catraca - Quando a catraca está disponível para passagem e o passageiro não passa em tempo hábil.
 * @author Vagner Cerqueira
 * @data 06/2021
 * @package application
 */

namespace App\Controllers\Bil\Tipos_registros;

use App\Controllers\Bil\Tipos_registros\Tipos;
class Tipo_004 extends Tipos
{
    public function set_dados($lin)
    {
        $dt = $this->data_juliana(substr($lin, 8, 5));
        $dados = [
            'VERSAO' => substr($lin, 3, 3),
            'SWITCH' => substr($lin, 6, 2),
            'DATA' => $dt,
            'HORA' => substr($lin, 13, 5),
            //'ASSINATURA' => null
        ];
        $versao = "versao_" . substr($lin, 3, 3);
        if ($versao == '010') {
            $dados = $this->versao_010($lin, $dados);
        } else {
            $dados = $this->versao_123($lin, $dados);
        }
        return $dados;
    }
    public function versao_010($lin, $dados)
    {
        $dados['EMISSOR'] = substr($lin, 18, 4);
        $dados['DESENHO'] = substr($lin, 21, 2);
        $dados['NUMERO_SERIE'] = substr($lin, 23, 8);
        $dados['DIGITO_VERIFICADOR'] = substr($lin, 31, 1);
        $dados['NUMERO_INTERNO'] = substr($lin, 32, 20);
        $dados['APLICACAO'] = substr($lin, 52, 4);
        $dados['EMISSOR_APLICACAO'] = substr($lin, 56, 3);
       // $dados['ASSINATURA'] = substr($lin, 59, 4);
        return $dados;
    }
    public function versao_123($lin, $dados)
    {
        return $dados;
    }
}
