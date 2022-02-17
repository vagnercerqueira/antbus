<?php

/**
 * Tipo 045 PowerUp - Registro que identifica ocorrência de reinicialização do equipamento.
 * @author Vagner Cerqueira
 * @copyright News Systems 01/2021
 * @license
 * @package application
 * @subpackage controllers
 */

require_once('tipos.php');
class Tipo_045 extends Tipos
{
    public function set_dados($lin)
    {
        $dt = $this->data_juliana(substr($lin, 26, 5));
        $dados = [
            'VERSAO' => substr($lin, 3, 3),
            'CONDIÇÃO' => substr($lin, 6, 10),
            'STATUS_SERVICO' => substr($lin, 16, 10),
            'DATA' => $dt,
            'HORA' => substr($lin, 31, 5),
            'ASSINATURA' => substr($lin, 36, 4)
        ];
        return $dados;
    }
}
