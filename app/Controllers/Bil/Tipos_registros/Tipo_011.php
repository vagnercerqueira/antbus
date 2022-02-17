<?php

/**
 * Tipo 011– – Ponto de Checagem - Quando um dos técnicos citados no item acima passar o seu cartão pelo Validador nos estados: Comercial ou Placa (Em ambos os sentidos)
 * @author Vagner Cerqueira
 * @data 06/2021
 * @package application
 */
namespace App\Controllers\Bil\Tipos_registros;

use App\Controllers\Bil\Tipos_registros\Tipos;

class Tipo_011 extends Tipos
{
    public function set_dados($lin, $dadosExtra, $assoc_param = false)
    {
        $dt = $this->data_juliana(substr($lin, 29, 5));

        $dados = [
            'VERSAO' => substr($lin, 3, 3),
            'TSP' => substr($lin, 6, 3),
            //'CODIGO_PRODATA_OPER' =>  substr($lin, 9, 10),
            //'MATRICULA_PRODATA_OPER' => substr($lin, 19, 10),
            'DATA' => $dt,
            'HORA' => substr($lin, 34, 5),
            'EMISSOR' => substr($lin, 39, 3),
            'DESENHO' => substr($lin, 42, 2),
            'NUMERO_SERIE' => substr($lin, 44, 8),
            'DIGITO_VERIFICADOR' => substr($lin, 52, 1),
            'NUMERO_INTERNO' => substr($lin, 53, 20),
            'NUMERO_ONIBUS' => substr($lin, 73, 10),
            'MOT_TSP' => substr($lin, 83, 3),
            'MOT_PRODATA' => substr($lin, 186, 10),
            'MOT_MATRICULA' => substr($lin, 196, 10),
            'COB_TSP' => substr($lin, 106, 3),
            'COB_PRODATA' => substr($lin, 109, 10),
            'COB_MATRICULA' => substr($lin, 119, 10),
            //'ASSINATURA' => substr($lin, 129, 4)
        ];
        return $dados;
    }
}
