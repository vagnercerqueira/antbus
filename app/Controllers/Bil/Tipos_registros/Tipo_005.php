<?php

/**
 * Tipo 005 - – Cartão rejeitado - Registro que diz o código de rejeição do cartão - Quando o cartão foi rejeitado e qual o seu motivo..
 * @author Vagner Cerqueira
 * @copyright News Systems 01/2021
 * @license
 * @package application
 * @subpackage controllers

 */
namespace App\Controllers\Bil\Tipos_registros;

use App\Controllers\Bil\Tipos_registros\Tipos;

class Tipo_005 extends Tipos
{
    public function set_dados($lin, $dadosExtra)
    {
		$dados = [];
        $dt = $this->data_juliana(substr($lin, 6, 5));
        $dados = [
			'SEQ_ESTADO' => $dadosExtra['ID_001'],
            'VERSAO' => substr($lin, 3, 3),
            'DATA' => $dt,
            'HORA' => substr($lin, 11, 5),
            'EMISSOR_CARTAO' => substr($lin, 16, 3),
            'DESENHO' => substr($lin, 19, 2),
            'NUM_SERIE' => substr($lin, 21, 8),
            'DIG_VERIFICADOR' => substr($lin, 29, 1),
            'NUM_INTERNO' => substr($lin, 30, 20),
            'APLICACAO' => substr($lin, 50, 4),
            'EMISSOR_APLICACAO' => substr($lin, 54, 3),
            'CODIGO_ERRO' => substr($lin, 57, 5),
           // 'ASSINATURA' => substr($lin, 62, 4)
        ];
        return $dados;
    }
}
