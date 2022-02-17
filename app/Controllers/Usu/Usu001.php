<?php
/*
	DESCRICAO: [CADASTRO DE USUARIOS]
	@AUTOR: Vagner Cerqueira
	DATA: 09/2020
*/

namespace App\Controllers\Usu;

use App\Models\Usuarios\Parametro_sistemaModel;
use App\Controllers\BaseController;
use App\Models\Usuarios\Grupo_usuarioModel;
use App\Models\Usuarios\UsuariosModel;
use Datatables_server_side;

class Usu001 extends BaseController
{
	private $sttUser = ['A' => 'Ativo', 'I' => 'Inativo'];
	public function __construct()
	{
		$this->tbs_crud  = ['form_usuarios' => PREFIXO_TB.'usuarios'];
	}
	public function index()
	{  
		$grupoModel = new Grupo_usuarioModel();
		$grupo = array_column($grupoModel->where(['superusuario' => 'N'])->findAll(), 'descricao', 'id');
		$data = [
			"arquivo_dataTable" => true,
			"grupo" => form_dropdown('GRUPO', $grupo, '', "id='GRUPO' class='form-control  form-control-sm' required"),
			"status" => form_dropdown('STATUS', $this->sttUser, '', "id='STATUS' class='form-control form-control-sm' required"),
		];
		$this->load_template($data);
	}
	public function valida_campos()
	{
		$rules = [
			'NOME' => 'max_length[50]|required',
			'USUARIO' => "min_length[3]|max_length[20]|required|is_unique[".PREFIXO_TB."usuarios.usuario,id,{ID}]",
			'EMAIL' => 'required|valid_email',
			'DOC' => "ext_in[DOC,pdf,png,jpg]"
			//'DOC' => "ext_in[DOC,png,jpg]"
		];
		return $this->validate($rules);
	}
	public function preIns($data)
	{
		$data['SENHA'] = password_hash($data['USUARIO'], PASSWORD_DEFAULT);
		/*$imgBlob = file_get_contents($_FILES['DOC']['tmp_name']);
		$data['FOTO_BLOB'] = base64_encode($imgBlob);
		print_r($imgBlob);
		exit;*/
		return $data;
	}
	public function preUpd($dados)
	{
		$file = $this->request->getFile('DOC');
		if ($file->isValid()) {
			$dados['FOTO'] = "";
		}
		return $dados;
	}

	public function grava_img($key)
	{
		$file = $this->request->getFile('DOC');
		if ($file->isValid()) {
			/*//ROTINA PARA SALVA O ARQUIVO NO BANCO
			$docModel = new Documentos_model();
			$idsDocs = $docModel->salva_docs($_FILES['DOC']);
			$userMod = new UsuariosModel();
			foreach ($idsDocs as $v)
				$userMod->update($key, ['id_documento' => $v]); //nao esquecer de add o campo na var allowedFields do model */

			//ROTINA PARA SALVA O ARQUIVO EM PASTA PUBLICA
			$nfile =   $key . "_" . date('dmYHis') . "." . $file->getClientExtension();
			$dir_img = FCPATH . "assets/img/usuarios/" . $nfile;
			move_uploaded_file($_FILES['DOC']['tmp_name'], $dir_img);
			$user = new UsuariosModel();
			$user->update($key, ['foto' => $nfile]);

			/*	//ROTINA PARA SALVA O ARQUIVO EM PASTA PRIVADA
			$nfile =   $key  . "_" . date('dmYHis') . "_" . $file->getRandomName();
			$file->store('usuarios/', $nfile);
			$user = new UsuariosModel();
			$user->update($key, ['foto' => $nfile]);*/
		}
	}
	public function excluiArq($nfile)
	{
		$fExist = FCPATH . "assets/img/usuarios/" . $nfile;
		if (file_exists($fExist))
			unlink($fExist);
	}
	public function posIns($dados, $key)
	{
		$this->grava_img($key);
		$parSis = new Parametro_sistemaModel();
		if ($dados['EMAIL'] !== "" && $parSis->find()[0]['envia_email_usuario'] == 'S') {
			$from = $parSis->find()[0]['email_suporte'];
			$dPost = $this->request->getPost();
			$headers = "From: {$from}" . "\r\n" . 'X-Mailer: PHP/' . phpversion();
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			mail($dados['EMAIL'], 'Usuario sistema arquivar', ("Ola: " . $dados['NOME'] . ", seu usuario no sistema aquivo &eacute;: " . $dados['USUARIO'] . ", e sua senha &eacute;: " . $dados['USUARIO']), $headers);
		}
	}
	public function posUpd($dados)
	{
		$this->grava_img($dados['ID']);
	}

	public function DataTable()
	{
		$dt = new Datatables_server_side([
			'tb' => PREFIXO_TB.'usuarios',
			'acao' => true,
			//'cols' => ['descricao'],
			'cols' => ["nome", "usuario", "status", "foto"],
			'where' => [
				" superusuario = 'N'"
			],
			'join' => [
				[PREFIXO_TB.'grupo_usuario', PREFIXO_TB.'grupo_usuario.id='.PREFIXO_TB.'usuarios.grupo']
			],
			'fields_fk' => [
				[PREFIXO_TB.'grupo_usuario.descricao', PREFIXO_TB.'grupo']
			],

			'formata_coluna' => [
				1 => function ($col, $lin) {
					$col .= '&nbsp;<button type="button" onclick="reset_senha(\''.base64_encode($lin['id']).'\')" title="Header" data-toggle="popover" data-placement="bottom" data-content="Content" class="btn btn-xs btn-info float-right"><i class="fa fa-key"></i>&nbsp;Reset Senha</button>';
					return $col;
				},		
				2 => function ($col, $lin) {
					return $this->montaStatus($col, $lin);
				},
				3 => function ($col, $lin) {
					$img = "<img class='img-circle elevation-2' width=35 height=35 src='" . (base_url("assets/img/usuarios/" . ($col != "" ? $col : 'user.PNG'))) . "'>";
					return  $img;
				},
			]
		]);
		$dt->simpleQuery();
	}
	public function montaStatus($r, $lin)
	{

		$c = $r == 'A' ? "success" : "warning";

		$m = '<div class="dropdown">
		  <button class=" btn btn-' . $c . ' dropdown-toggle btn-xs txtativ"  type="button" data-toggle="dropdown">' . $this->sttUser[$r] . '
		  <span class="caret"></span></button>
		  <ul class="dropdown-menu">';
		foreach ($this->sttUser as $k => $v) {
			$c = ($k == 'A') ? 'success' : 'warning';
			$m .= '<li style="margin-bottom:1px;"><button type="button" class="btn btn-xs btn-' . $c . ' btn-block" onclick="desab_status(this)" data-id="' . base64_encode($lin['id']) . '" st="' . $k . '">' . $v . '</button></li>';
		}
		$m .= '</ul>
		</div>';
		return  $m;
	}
	public function post_edicao($row)
	{
		return $row;
	}
	public function	altera_status()
	{
		$chave = base64_decode($this->request->getPost('chave'));
		$status = $this->request->getPost('stat');
		$user = new UsuariosModel();
		echo json_encode(['TOT'=>$user->update($chave, ['status' => $status])]);
	}
	public function conf_altera_senha(){
		$chave = base64_decode($this->request->getPost('chave'));
		$user = new UsuariosModel();
		$usu = $user->find($chave);
		$tot = $user->update($chave, ['senha'=>$usu['usuario']]);
		echo json_encode(['TOT'=>$tot]);
	}
}
