<?php

namespace App\Models\Bil;

use App\Models\My_model;

class Param_geral_Model extends My_model
{
  protected $table = PREFIXO_TB.'bil_res_parametro_geral';
  protected $allowedFields = ['bil_tipos_reg', 'bil_estados_001'];
}