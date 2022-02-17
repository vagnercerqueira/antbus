<?php

namespace App\Models\Usuarios;

use App\Models\My_model;

class Grupo_usuarioModel extends My_model
{
  protected $table = PREFIXO_TB.'grupo_usuario';
  protected $allowedFields = ['descricao', 'home', 'formsearch'];
}
