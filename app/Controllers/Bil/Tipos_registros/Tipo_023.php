<?php

/**
 * Tipo 023 - Dados Transação Mula Detalhe - Quando se faz uma coleta, e esta coleta possui contadores maiores que zero
 * @author Vagner Cerqueira
 * @data 06/2021
 */
namespace App\Controllers\Bil\Tipos_registros;

use App\Controllers\Bil\Tipos_registros\Tipos;

class Tipo_023 extends Tipos
{
    public function set_dados($lin, $dadosExtra, $assoc_param = false)
    {
        $dados = [
            'VERSAO' => substr($lin, 3, 3),
            'CODIGO_ESTATISTICA' => substr($lin, 6, 2),
            'QUANTIDADE_ROLETADAS' => substr($lin, 8, 4),
           // 'ASSINATURA' => substr($lin, 12, 4)
        ];
        return $dados;
    }
}
