<?php

/**
 * Tipo 044 RevalidationCard - Quando o cartão for rejeitado por falta de confirmação do operador.

 * @author Vagner Cerqueira
 * @copyright News Systems 01/2021
 * @license
 * @package application
 * @subpackage controllers
 */

require_once('tipos.php');
class Tipo_044 extends Tipos
{
    public function set_dados($lin)
    {
        $dt = $this->data_juliana(substr($lin, 6, 5));
        $dados = [
            'VERSAO' => substr($lin, 3, 3),
            'DATA' => $dt,
            'HORA' => substr($lin, 11, 5),
            'EMISSOR' => substr($lin, 16, 3),
            'DESENHO' => substr($lin, 19, 2),
            'NUMERO_SERIE' => substr($lin, 21, 8),
            'DIGITO_VERIFICADOR' => substr($lin, 29, 1),
            'NUMERO_INTERNO' => substr($lin, 30, 20),
            'APLICACAO' => substr($lin, 50, 4),
            'EMISSOR_APLICACAO' => substr($lin, 54, 3),
            'TSN' => substr($lin, 57, 5),
            'ASSINATURA' => substr($lin, 62, 4)
        ];
        return $dados;
    }
}
