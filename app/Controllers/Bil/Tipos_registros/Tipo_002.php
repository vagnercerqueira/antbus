<?php

/**
 * Tipo 002 - Transaces de uso de cart�o - Registro gerado a cada valida��o de um cart�o no Validador -  Quando � feita a valida��o de um cart�o no validador
 * @author Vagner Cerqueira
 * @data 06/2021
 */

namespace App\Controllers\Bil\Tipos_registros;

use App\Controllers\Bil\Tipos_registros\Tipos;

class Tipo_002 extends Tipos
{
    public function set_dados($lin, $dadosExtra, $assoc_param = false)
    {
        $dt = $this->data_juliana(substr($lin, 6, 5));
        $dados = [ //versao 011
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
            'TSN' => substr($lin, 57, 5),
            'VALOR_TARIFA' => substr($lin, 62, 6),
            'VALOR_TARIFA_ANT' => substr($lin, 68, 6),
            'VALOR_DEBITADO' => substr($lin, 74, 6),

            'DIFERENCA_VALOR_DEBITADO' => NULL,
            'VALOR_PROMO_DESCONTO' => NULL,
            'VALOR_ACUMULADO' => NULL,
            'SECAO_ENTRADA' => NULL,
            'SECAO_SAIDA' => NULL,
            'STATUS' => NULL,
            /*'NUM_CARRO' => NULL,
            'MOT_TSP' => NULL,
            'MOT_PRODATA' => NULL,
            'MOT_MATRICULA' => NULL,
            'COB_TSP' => NULL,
            'COB_PRODATA' => NULL,
            'COB_MATRICULA' => NULL,*/
            'TIPO_EMBARQUE' => NULL,
            // 'EXT_USE_CTR' => NULL,
            // 'EXT_VAL_DATE' => NULL,
            //'PROVIDER_ID' => null,
            'TIPO_DEBITO' => null,
            'MSG_DEBITO' => null,
            'TIPO_CREDITO_CARTEIRA_A' => null,
            'TIPO_CREDITO_CARTEIRA_B' => null,
            'CSN_A' => null,
            'CSN_B' => null,
            'REPETIDO' => $dadosExtra['REPETIDO'], //ex: bolsao
            /* 'SERIAL_CHIP' => null,
            'SEQUENCIA_ARQUIVO' => null,
            'AVL_STATUS' => null,
            'ASSINATURA' => null*/
        ];
        $versao = "versao_" . substr($lin, 3, 3);
        $dados = $this->$versao($lin, $dados);
        if ($assoc_param === true) {
            $dados = $this->associa_parametros($dados);
        }
        return $dados;
    }

    public function versao_002($lin, $dados)
    {
        $dados['SECAO_ENTRADA'] = substr($lin, 80, 8);
        $dados['SECAO_SAIDA'] = substr($lin, 88, 8);
        $dados['STATUS'] = substr($lin, 96, 1);
        /* $dados['NUM_CARRO'] = substr($lin, 97, 10);
        $dados['MOT_TSP'] = substr($lin, 107, 3);
        $dados['MOT_PRODATA'] = substr($lin, 110, 10);
        $dados['MOT_MATRICULA'] = substr($lin, 120, 10);
        $dados['COB_TSP'] = substr($lin, 130, 3);
        $dados['COB_PRODATA'] = substr($lin, 133, 10);
        $dados['COB_MATRICULA'] = substr($lin, 143, 10);*/
        $dados['TIPO_EMBARQUE'] = substr($lin, 153, 1);
        /* $dados['SERIAL_CHIP'] = substr($lin, 154, 20);
        $dados['SEQUENCIA_ARQUIVO'] = substr($lin, 174, 6);
        $dados['ASSINATURA'] = substr($lin, 180, 4);*/
        return $dados;
    }
    public function versao_003($lin, $dados)
    {
        $dados['SECAO_ENTRADA'] = substr($lin, 80, 8);
        $dados['SECAO_SAIDA'] = substr($lin, 88, 8);
        $dados['STATUS'] = substr($lin, 96, 1);
        /* $dados['NUM_CARRO'] = substr($lin, 97, 10);
        $dados['MOT_TSP'] = substr($lin, 107, 3);
        $dados['MOT_PRODATA'] = substr($lin, 110, 10);
        $dados['MOT_MATRICULA'] = substr($lin, 120, 10);
        $dados['COB_TSP'] = substr($lin, 130, 3);
        $dados['COB_PRODATA'] = substr($lin, 133, 10);
        $dados['COB_MATRICULA'] = substr($lin, 143, 10);*/
        $dados['TIPO_EMBARQUE'] = substr($lin, 153, 1);
        /* $dados['PROVIDER_ID'] = substr($lin, 154, 20);
        $dados['SERIAL_CHIP'] = substr($lin, 174, 20);
        $dados['SEQUENCIA_ARQUIVO'] = substr($lin, 194, 6);
        $dados['AVL_STATUS'] = substr($lin, 200, 2);
        $dados['ASSINATURA'] = substr($lin, 202, 4);*/
        return $dados;
    }
    public function versao_004($lin, $dados)
    {
        $dados['SECAO_ENTRADA'] = substr($lin, 80, 8);
        $dados['SECAO_SAIDA'] = substr($lin, 88, 8);
        $dados['STATUS'] = substr($lin, 96, 1);
        /* $dados['NUM_CARRO'] = substr($lin, 97, 10);
        $dados['MOT_TSP'] = substr($lin, 107, 3);
        $dados['MOT_PRODATA'] = substr($lin, 110, 10);
        $dados['MOT_MATRICULA'] = substr($lin, 120, 10);
        $dados['COB_TSP'] = substr($lin, 130, 3);
        $dados['COB_PRODATA'] = substr($lin, 133, 10);
        $dados['COB_MATRICULA'] = substr($lin, 143, 10);*/
        $dados['TIPO_EMBARQUE'] = substr($lin, 153, 1);
        // $dados['PROVIDER_ID'] = substr($lin, 154, 20);
        //$dados['EXT_USE_CTR']  = substr($lin, 174, 5);,
        //$dados['EXT_VAL_DATE']  = substr($lin, 179, 5);,
        /* $dados['SERIAL_CHIP'] = substr($lin, 184, 20);
        $dados['SEQUENCIA_ARQUIVO'] = substr($lin, 204, 6);
        $dados['AVL_STATUS'] = substr($lin, 210, 2);
        $dados['ASSINATURA'] = substr($lin, 212, 4);*/
        return $dados;
    }
    public function versao_006($lin, $dados)
    {

        $dados['DIFERENCA_VALOR_DEBITADO'] = substr($lin, 80, 6);
        $dados['SECAO_ENTRADA'] = substr($lin, 86, 8);
        $dados['SECAO_SAIDA'] = substr($lin, 94, 8);

        $dados['STATUS'] = substr($lin, 102, 1);
        /* $dados['NUM_CARRO'] = substr($lin, 103, 10);
        $dados['MOT_TSP'] = substr($lin, 113, 3);
        $dados['MOT_PRODATA'] = substr($lin, 116, 10);
        $dados['MOT_MATRICULA'] = substr($lin, 126, 10);
        $dados['COB_TSP'] = substr($lin, 136, 3);
        $dados['COB_PRODATA'] = substr($lin, 139, 10);
        $dados['COB_MATRICULA'] = substr($lin, 149, 10);*/
        $dados['TIPO_EMBARQUE'] = substr($lin, 159, 1);
        /*$dados['SERIAL_CHIP'] = substr($lin, 160, 20);
        $dados['SEQUENCIA_ARQUIVO'] = substr($lin, 180, 6);
        $dados['AVL_STATUS'] = substr($lin, 186, 2);
        $dados['ASSINATURA'] = substr($lin, 188, 4);*/
        return $dados;
    }

    public function versao_008($lin, $dados)
    {

        $dados['STATUS'] = substr($lin, 80, 1);
        /*  $dados['NUM_CARRO'] = substr($lin, 81, 10);
        $dados['MOT_TSP'] = substr($lin, 91, 3);
        $dados['MOT_PRODATA'] = substr($lin, 94, 10);
        $dados['MOT_MATRICULA'] = substr($lin, 104, 10);
        $dados['COB_TSP'] = substr($lin, 114, 3);
        $dados['COB_PRODATA'] = substr($lin, 117, 10);
        $dados['COB_MATRICULA'] = substr($lin, 127, 10);*/
        $dados['TIPO_EMBARQUE'] = substr($lin, 137, 1);
        //$dados['PROVIDER_ID_ESTUDANTE'] = substr($lin, 138, 20);
        /*$dados['SERIAL_CHIP'] = substr($lin, 158, 20);
        $dados['SEQUENCIA_ARQUIVO'] = substr($lin, 178, 6);
        $dados['AVL_STATUS'] = substr($lin, 184, 2);
        $dados['ASSINATURA'] = substr($lin, 186, 4);*/
        return $dados;
    }

    public function versao_011($lin, $dados)
    {
        $dados['VALOR_PROMO_DESCONTO'] = substr($lin, 80, 6);
        $dados['VALOR_ACUMULADO'] = substr($lin, 86, 6);
        $dados['SECAO_ENTRADA'] = substr($lin, 92, 8);
        $dados['SECAO_SAIDA'] = substr($lin, 100, 8);
        $dados['STATUS'] = substr($lin, 108, 1);
        /*  $dados['NUM_CARRO'] = substr($lin, 109, 10);
        $dados['MOT_TSP'] = substr($lin, 119, 3);
        $dados['MOT_PRODATA'] = substr($lin, 122, 10);
        $dados['MOT_MATRICULA'] = substr($lin, 132, 10);
        $dados['COB_TSP'] = substr($lin, 142, 3);
        $dados['COB_PRODATA'] = substr($lin, 145, 10);
        $dados['COB_MATRICULA'] = substr($lin, 155, 10);*/
        $dados['TIPO_EMBARQUE'] = substr($lin, 165, 1);
        // $dados['PROVIDER_ID'] = substr($lin, 166, 20);
        $dados['TIPO_DEBITO'] = substr($lin, 186, 1);
        $dados['MSG_DEBITO'] = substr($lin, 187, 3);
        $dados['TIPO_CREDITO_CARTEIRA_A'] = substr($lin, 190, 2);
        $dados['TIPO_CREDITO_CARTEIRA_B'] = substr($lin, 192, 2);
        $dados['CSN_A'] = substr($lin, 194, 10);
        $dados['CSN_B'] = substr($lin, 204, 10);
        /* $dados['SERIAL_CHIP'] = substr($lin, 214, 20);
        $dados['SEQUENCIA_ARQUIVO'] = substr($lin, 234, 6);
        $dados['AVL_STATUS'] = substr($lin, 240, 2);
        $dados['ASSINATURA'] = substr($lin, 242, 4);*/
        return $dados;
    }
}
