<?php

namespace App\Models\Usuarios;

use App\Models\My_model;

class AplicacoesModel extends My_model
{
  protected $table = PREFIXO_TB.'aplicacoes';
  protected $allowedFields = ['id_pai', 'nome', 'icone', 'caminho', 'ordem'];
  public function AcessUsuGrupo()
  {
    $query = "SELECT * FROM {$this->table} 
              WHERE caminho NOT IN ( 'Usu/Usu002.php' ,'Usu/Usu005.php', 'usu/Usu006.php')";
    $rows = $this->query($query)->getResultArray();
    return $rows;
  }
}
