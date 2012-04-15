<?php

class Inicio extends Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('../../gerenciador/models/UsuarioModel', 'usuarioModel');
	}

	function index(){		
		$this->load->view('inicioView');
	}

	function perfil(){
		if($this->usuarioModel->acessaPerfil($this->uri->segment(3), getUsuarioSession()->id)){
			$_SESSION['perfil'] = $this->uri->segment(3);
			$_SESSION['programas'] = $this->usuarioModel->getMenu($this->uri->segment(3));
			redirect('dashboard/inicio');
		}else{
			redirect('autenticacao/login/semPermissao/perfil');
		}
	}
	
	function empresa(){
		$_SESSION['empresa'] = $this->uri->segment(3);
		$_SESSION['perfis'] = $this->usuarioModel->getPerfisUsuario(getUsuarioSession()->id, $_SESSION['empresa']);
		$_SESSION['perfil'] = 2;
		$_SESSION['programas'] = $this->usuarioModel->getMenu(2);
		redirect('inicio');
	}		
		 
}