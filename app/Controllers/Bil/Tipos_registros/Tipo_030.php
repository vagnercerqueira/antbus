<?php

/**
 * Tipo 030–Time Registrated-Registro que indica o horário de pegada e/ou largada dos Operadores: Despachante, Inspetor,Fiscal e Auxiliar de Tráfego
 * @author Vagner Cerqueira
 * @data 06/2021
 */

namespace App\Controllers\Bil\Tipos_registros;

use App\Controllers\Bil\Tipos_registros\Tipos;

class Tipo_030 extends Tipos
{
    public function set_dados($lin, $dadosExtra, $assoc_param = false)
    {
        $dt = $this->data_juliana(substr($lin, 42, 5));
        $dados = [
            'VERSAO' => substr($lin, 3, 3),
            //'FUNCAO_OPERADOR' => substr($lin, 6, 3),
            'TSP' => substr($lin, 9, 3),
            // 'CODIGO_OPERADOR_PRODATA'=> substr($lin, 12, 10),
            // 'MATRICULA_OPERADOR' => substr($lin, 22, 10),
            'NUMERO_ONIBUS' => substr($lin, 32, 10),
            'DATA' => $dt,
            'HORA' => substr($lin, 47, 5),
            'CODIGO_OPERACAO' => substr($lin, 52, 3),
            'NUMERO_SERIE' => substr($lin, 55, 8),
            'NUMERO_INTERNO' => substr($lin, 63, 20),
           // 'ASSINATURA' => substr($lin, 83, 4)
        ];
        return $dados;
    }
}
