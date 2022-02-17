<?php

namespace App\Models\Usuarios;

use App\Models\My_model;

class Pedidos_cad_usuariosModel extends My_model
{
  protected $table = PREFIXO_TB.'pedidos_cad_usuarios';
  protected $allowedFields = ['nome', 'email','senha','status'];
  protected $beforeInsert = ['beforeInsert'];
 

  protected function beforeInsert(array $data)
  {
    $data = $this->passwordHash($data);
    return $data;
  }

  protected function passwordHash(array $data)
  {
    if (isset($data['data']['senha']))
      $data['data']['senha'] = password_hash($data['data']['senha'], PASSWORD_DEFAULT);

    return $data;
  }
}
