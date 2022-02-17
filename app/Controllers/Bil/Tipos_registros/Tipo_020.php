<?php

/**
 * Tipo 020– Dados de Coleta Mestre - Quando o cobrador aproxima o cartão do validador para coletar os dados, e a coleta é efetuada com sucesso.
 * @author Vagner Cerqueira
 * @data 06/2021
 */
namespace App\Controllers\Bil\Tipos_registros;

use App\Controllers\Bil\Tipos_registros\Tipos;

class Tipo_020 extends Tipos
{
    public function set_dados($lin, $dadosExtra, $assoc_param = false)
    {
        $dt = $this->data_juliana(substr($lin, 9, 5));

        $dados = [
            'VERSAO' => substr($lin, 3, 3),
            //'FUNCAO_OPERADOR' => substr($lin, 6, 3),
            'DATA' => $dt,
            'HORA' => substr($lin, 14, 5),
            'EMISSOR' => substr($lin, 19, 3),
            'DESENHO' => substr($lin, 22, 2),
            'NUMERO_SERIE' => substr($lin, 24, 8),
            'DIGITO_VERIFICADOR' => substr($lin, 32, 1),
            'NUMERO_INTERNO' => substr($lin, 33, 20),
            'TSP' => substr($lin, 53, 3),
            //  'CODIGO_PRODATA_OPER' =>  substr($lin, 56, 10),
            //  'MATRICULA_PRODATA_OPER' => substr($lin, 66, 10),
            'TSN' => substr($lin, 76, 5),

            'NUMERO_SERVICO' => substr($lin, 81, 2),
            'NUMERO_ONIBUS' => substr($lin, 83, 10),
            'MOT_TSP' => substr($lin, 93, 3),
            'MOT_PRODATA' => substr($lin, 96, 10),
            'MOT_MATRICULA' => substr($lin, 106, 10),
            'COB_TSP' => substr($lin, 116, 3),
            'COB_PRODATA' => substr($lin, 119, 10),
            'COB_MATRICULA' => substr($lin, 129, 10),
            'ASSINATURA' => substr($lin, 139, 4)
        ];
        return $dados;
    }
}
