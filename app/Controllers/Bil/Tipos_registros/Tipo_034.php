<?php

/**
 * Tipo 034 STATISTICAL COUNTER - Registro de estat�sticadasvalida��es de cart�es no Validador
 * @author Vagner Cerqueira
 * @data 06/2021
 */

namespace App\Controllers\Bil\Tipos_registros;

use App\Controllers\Bil\Tipos_registros\Tipos;

class Tipo_034 extends Tipos
{
    public function set_dados($lin, $compl, $dadosExtra, $assoc_param = false)
    {
        
        $dt_ini_viagem = $this->data_juliana(substr($lin, 30, 5));
        $dt_ter_viagem = $this->data_juliana(substr($lin, 40, 5));

        $dados = [
            'PACOTE' => substr($lin, 3, 21),
            'BATCH' => substr($lin, 24, 1),
            'ID_SERVICO' => substr($lin, 25, 1),
            'ESTADO_VALIDADOR' => substr($lin, 26, 3),
            'STATUS_VIAGEM' => substr($lin, 29, 1),
            'DATA_INI_VIAGEM' => $dt_ini_viagem,
            'HORA_INI_VIAGEM' => substr($lin, 35, 5),
            'DATA_TERMINO_VIAGEM' => $dt_ter_viagem,
            'HORA_TERMINO_VIAGEM' => substr($lin, 45, 5),
            'NUM_CARRO' => substr($lin, 50, 10),
            'CODIGO_PRINCIPAL_LIN' => substr($lin, 60, 5),
            'SENTIDO' => substr($lin, 65, 1),
            'MOT_PRODATA' => substr($lin, 66, 10),
            'COB_PRODATA' => substr($lin, 76, 10),

            'NUMERO_APLICACAO' => substr($compl, 0, 4),
            'TOTAL_PASSAGEIROS' => substr($compl, 4, 5),
            'PRECO_TARIFA' => substr($compl, 9, 6),
            'TIPO_EMBARQUE' => substr($compl, 15, 1),
            'SECAO_SAIDA' => substr($compl, 16, 8),
            'SECAO_ENTRADA' => substr($compl, 24, 8),
        ];
        if($assoc_param === true){
            $dados = $this->associa_parametros($dados);
        }
        return $dados;
    }
}
