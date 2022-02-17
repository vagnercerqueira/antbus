<?php

namespace App\Models\Usuarios;

use App\Models\My_model;

class Grupo_lojaModel extends My_model
{
  protected $table = PREFIXO_TB.'grupo_loja';
  protected $allowedFields = ['descricao', 'status'];
}
