<?php

/**
 * Tipos, para tratar informacoes em comum aos tipos de registros da bilhetagem
 * @author Vagner Cerqueira
 * data 27/03/2021
 */

namespace App\Controllers\Bil\Tipos_registros;

use App\Controllers\BaseController;

class Tipos extends BaseController
{
    public function data_juliana($juliana)
    {
        $jd_data = intval($juliana);
        $jd_ref = GregorianToJD(12, 31, 2002);
        $data_ingles = jdtogregorian($jd_data + $jd_ref);
        $arr_data = explode('/', $data_ingles);
        $data = $arr_data[2] . '/' . $arr_data[0] . '/' . $arr_data[1];
        return $data;
    }
}
