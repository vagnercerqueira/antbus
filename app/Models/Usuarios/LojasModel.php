<?php

namespace App\Models\Usuarios;

use App\Models\My_model;

class LojasModel extends My_model
{
  protected $table = PREFIXO_TB.'lojas';
  protected $allowedFields = ['nome'];
}
