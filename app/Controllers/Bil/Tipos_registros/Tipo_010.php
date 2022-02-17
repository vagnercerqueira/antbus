<?php

/**
 * Tipo 010 - Registro que indica o horário da vinculação ou desvinculação de um Motorista, Cobrador ou Motorista Jr.
 * @author Vagner Cerqueira
 * @data 06/2021
 * @package application
 */

namespace App\Controllers\Bil\Tipos_registros;

use App\Controllers\Bil\Tipos_registros\Tipos;

class Tipo_010 extends Tipos
{
    public function set_dados($lin, $dadosExtra, $assoc_param = false)
    {
        $dt = $this->data_juliana(substr($lin, 42, 5));
        $dados = [
            'VERSAO' => substr($lin, 3, 3),
            'FUNCAO_OPERADOR' => substr($lin, 6, 3),
            'TSP' => substr($lin, 9, 3),
            'MATRICULA_PRODATA' => substr($lin, 12, 10),
            'MATRICULA' => substr($lin, 22, 10),
            'NUM_CARRO' => substr($lin, 32, 10),
            'DATA' => $dt,
            'HORA' => substr($lin, 47, 5),
            'CODIGO_OPERACAO' => substr($lin, 52, 3),
            'STATUS' => substr($lin, 55, 1),
           // 'ASSINATURA' => substr($lin, 56, 4)
        ];
        return $dados;
    }
}
