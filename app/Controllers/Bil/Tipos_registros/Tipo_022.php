<?php

/**
 * Tipo 022–Dados Transação Mula Mestre-Quando o operador autorizado aproxima o cartão do validador para efetuar uma transação mula dos dados, e a transferência do cartão do cobrador é efetuada com sucesso
 * @author Vagner Cerqueira
 * @data 06/2021
 */
namespace App\Controllers\Bil\Tipos_registros;

use App\Controllers\Bil\Tipos_registros\Tipos;

class Tipo_022 extends Tipos
{
    public function set_dados($lin, $dadosExtra, $assoc_param = false)
    {
        $dt = $this->data_juliana(substr($lin, 9, 5));
        $dt_ini_serv = $this->data_juliana(substr($lin, 77, 5));
        $dt_fim_serv = $this->data_juliana(substr($lin, 87, 5));
        //1 a 10 é teste, 11 é operacao
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
            //'MATRICULA_OPERADOR' => substr($lin, 53, 10),
            'COB_APLICACAO' => substr($lin, 63, 4),
            'COB_MATRICULA' => substr($lin, 67, 10),
            'DATA_INI_SERVICO' => $dt_ini_serv,
            'HORA_INI_SERVICO' => substr($lin, 82, 5),
            'DATA_FIM_SERVICO' => $dt_fim_serv,
            'HORA_FIM_SERVICO' => substr($lin, 92, 5),
            'NUMERO_ONIBUS' => substr($lin, 97, 10),
            'CODIGO_LINHA_PRINCIPAL' => substr($lin, 107, 5),
            'TURNO' => substr($lin, 112, 1),
            'CSN' => substr($lin, 113, 4),
           // 'ASSINATURA' => substr($lin, 117, 4)
        ];
        return $dados;
    }
}
