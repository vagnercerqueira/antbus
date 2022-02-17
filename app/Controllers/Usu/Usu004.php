<?php

namespace App\Controllers\Usu;

use App\Controllers\Tb_basicas\Tb_basicas;

class Usu004 extends Tb_basicas
{
	public function __construct()
	{		
		$this->titulo = "Grupo Usuarios";
		$this->modelo = PREFIXO_TB."grupo_usuario";
		$this->field_extra = ['home' => ['type' => 'varchar', 'size' => 20], 'formsearch'=>['char', 'size' => 1]];

		$this->arr_extra = $this->monta_diretorios();
		$this->mwhere = [" superusuario = 'N' "];
		$this->tbs_crud  = ['form_basicos' => $this->modelo];
	}

	public function monta_diretorios()
	{

		$dir    = APPPATH . 'Controllers/Home/';
		$files = scandir($dir, 1);

		$select = "<label for='HOME'>Home</label>
		<select class='form-control form-control-sm' required id='HOME' name='HOME'>";
		foreach ($files as $k => $v) {
			if (!in_array($v, ['.', '..'])) {
				$op = explode('.', $v);
				$select .= "<option value='" . strtolower($op[0]) . "'>" . $op[0] . "</option>";
			}
		}
		$select .= "</select>";
		
		$formsearch = "<label for='FORMSEARCH'>Formulario de busca</label>
		<select class='form-control form-control-sm' required id='FORMSEARCH' name='FORMSEARCH'>
			<option value='S'>S</option><option value='N'>N</option>
		</select>";		
		
		return [$select, $formsearch];
	}
	public function valida_campos()
	{
		$rules = [
			'DESCRICAO' => 'required|max_length[20]|min_length[3]',
			//'HOME' => 'required|min_length[3]|max_length[5]',
		];
		return $this->validate($rules);
	}
}
