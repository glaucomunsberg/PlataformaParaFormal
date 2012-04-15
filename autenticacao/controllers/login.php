<?php
/**
 * Classe responsavel pelo login no sistema audigital
 * @package autenticacao
 */
 
	class Login extends Controller{

		function __construct(){
			parent::__construct();
			$this->load->model('LoginModel', 'loginModel');
			$this->load->model('../../gerenciador/models/UsuarioModel', 'usuarioModel');
			$this->load->model('../../gerenciador/models/ParametroModel', 'parametroModel');
		}

		function index(){
			if(@$_COOKIE['92c29c1ac4d85b45639f741599c24cd7'] != '')
				redirect('dashboard');
			else
				$this->load->view('loginView');
		}

		function entrar(){
			if($this->loginModel->validaUsuario($_POST)){
				$usuario_id = getUsuarioSession()->id;				
				$this->session->set_userdata('menu', $this->usuarioModel->getMenuByUsuarioId($usuario_id));
				setcookie('navigationtree', '', time() - 3600, PATH_COOKIE);
				setcookie('showMenu', '', time() - 3600, PATH_COOKIE);
				$this->ajax->ajaxMessage('success', lang('registroGravado'));
				$this->ajax->returnAjax();
			}else{
				$this->ajax->addAjaxData('error', $this->loginModel->validate->getError());
				$this->ajax->returnAjax();
			}
		}

		function sair(){
			$this->session->sess_destroy();
			setcookie('92c29c1ac4d85b45639f741599c24cd7', '', time() - 3600, PATH_COOKIE);
			setcookie('navigationtree', '', time() - 3600, PATH_COOKIE);		
			setcookie('showMenu', '', time() - 3600, PATH_COOKIE);
			setcookie('tema', '', time() - 3600, PATH_COOKIE);
			setcookie('avatar', '', time() - 3600, PATH_COOKIE);
			setcookie('redirect', '', time()- 3600, PATH_COOKIE);
			redirect('autenticacao/login');
		}

		function validaAutenticacaoAjax(){
			if(@$_COOKIE['92c29c1ac4d85b45639f741599c24cd7'] == '')
				$this->ajax->ajaxMessage('logged', false);
			else
				$this->ajax->ajaxMessage('logged', true);

			return $this->ajax->returnAjax();
		}

		function semPermissao() {
			if($this->uri->segment(3) == 'perfil')
				$data['mensagem'] = 'Você não tem permissão para acessar este grupo';
			else
				$data['mensagem'] = lang('semPermissaoAcessarMetodo');

			$this->load->view('login/semPermissaoView', $data);
		}

	}