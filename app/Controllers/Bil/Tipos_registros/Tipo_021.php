<?php

/**
 * Tipo 021– Dados de Coleta Detalhe - Quando se faz uma coleta, e esta coleta possui contadores maiores que zero.
 * @author Vagner Cerqueira
 * @data 06/2021
 */
namespace App\Controllers\Bil\Tipos_registros;

use App\Controllers\Bil\Tipos_registros\Tipos;

class Tipo_021 extends Tipos
{
    public function set_dados($lin, $dadosExtra, $assoc_param = false)
    {
        $dt = $this->data_juliana(substr($lin, 68, 5));

        $dados = [
            'VERSAO' => substr($lin, 3, 3),
            'CODIGO_ESTATISTICA' => substr($lin, 6, 2),
            'QUANTIDADE_ROLETADAS' => substr($lin, 8, 4),
            'NUMERO_ONIBUS' => substr($lin, 12, 10),
            'MOT_TSP' => substr($lin, 22, 3),
            'MOT_PRODATA' => substr($lin, 25, 10),
            'MOT_MATRICULA' => substr($lin, 35, 10),
            'COB_TSP' => substr($lin, 45, 3),
            'COB_PRODATA' => substr($lin, 48, 10),
            'COB_MATRICULA' => substr($lin, 58, 10),
            'DATA' => $dt,
            'HORA' => substr($lin, 73, 5),
            //'ASSINATURA' => substr($lin, 78, 4)
        ];
        return $dados;
    }
}
