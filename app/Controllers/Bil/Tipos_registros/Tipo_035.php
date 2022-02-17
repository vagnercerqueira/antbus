<?php

/**
 * Tipo 035 DEVICE ESPECIAL - Indica qual modo de operação do validador dentro da estrutura Master –Slave
 * @author Vagner Cerqueira
 * @data 29/03/2021
 * @package application
 */

namespace App\Controllers\Bil\Tipos_registros;

use App\Controllers\Bil\Tipos_registros\Tipos;

class Tipo_035 extends Tipos
{
    public function set_dados($lin, $dadosExtra)
    {
        $dt = $this->data_juliana(substr($lin, 6, 5));
        $dados = [
            'VERSAO' => substr($lin, 3, 3),
            'DATA' => $dt,
            'HORA' => substr($lin, 11, 5),
            'NUMERO_SERIE' => substr($lin, 16, 8),
            'CSN' => substr($lin, 24, 8),
            'CONTADOR_SERVICO' => substr($lin, 32, 8),
            'TYPE' => substr($lin, 40, 2),
            'SLAVE_QTY' => substr($lin, 42, 2),
            //'VALIDADOR_ID'=> substr($lin, 44,2),
            //'SAM_MASTER_CSN'=> substr($lin, 46,16),
            //'FILE_SEQUENCE'=> substr($lin, 62,8),
            //'ASSINATURA' => substr($lin, 42, 4)
        ];
        //print_r($dados);exit;
        return $dados;
    }
}
