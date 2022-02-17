<?php

/**
 * TIPO 100 - Registro que identifica informacoes b�sicas do arquivo (Sempre sera o primeiro e 
 *		o unico registro deste tipo no arquivo)
 * @author Vagner Cerqueira
 * data 27/03/2021
 */

namespace App\Controllers\Bil\Tipos_registros;

use App\Controllers\Bil\Tipos_registros\Tipos;

class Tipo_100 extends Tipos
{
    public function set_dados($lin, $dadosExtra)
    {		
        $dados = [
           // 'VERSAO' => substr($lin, 3, 3),
           // 'TSP' => substr($lin, 6, 3),
		    'ID_ARQUIVO' => $dadosExtra['ID_ARQUIVO'], 
            'NUM_CARRO' => $dadosExtra['NUM_CARRO'],
            'TIPO_CARRO' => substr($lin, 19, 3),
            'DATA_ARQUIVO' => $dadosExtra['DT_ARQUIVO'],
            //'HORA_ARQUIVO' => $dadosExtra['HR_ARQUIVO'],
            'TIPO_ARQ' => ( in_array($dadosExtra['TIPO_ARQ'], ['TGS', 'TGM']) ? $dadosExtra['TIPO_ARQ'] : substr($dadosExtra['TIPO_ARQ'],0,2) ), 
            //'NUM_SERIAL_VALIDADOR' => NULL,
            // 'ASSINATURA' => NULL,
        ];
        // $versao = "versao_" . substr($lin, 3, 3);
        // $dados = $this->$versao($lin, $dados);
        return $dados;
    }
    public function versao_001($lin, $dados)
    {
        $dados['ASSINATURA'] = substr($lin, 22, 4);
        return $dados;
    }
    public function versao_002($lin, $dados)
    {
        // $dados['NUM_SERIAL_VALIDADOR'] = substr($lin, 22, 20);
        //$dados['SEQUENCIAL_ARQUIVO'] = substr($lin, 42, 6);
        $dados['ASSINATURA'] = substr($lin, 48, 4);
        return $dados;
    }
}
