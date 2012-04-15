<?php

	class Usuario extends Controller {
	
		function __construct(){
			parent::__construct();
			$this->load->model('../../autenticacao/models/LoginModel', 'loginModel');
			$this->load->model('ProgramaModel', 'programaModel');
			$this->load->model('UsuarioModel', 'usuarioModel');
			$this->load->model('EmpresaModel', 'empresaModel');
			$this->load->model('PermissaoModel', 'permissaoModel');
			$this->load->model('GrupoAcessoModel', 'grupoAcessoModel');
			$this->load->model('ParametroModel', 'parametroModel');
		}

		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('usuarioFiltroView', $data);
		}

		function listaUsuarios(){
			$this->ajax->returnJqGrid($this->usuarioModel->getUsuarios($_GET));
		}

		function novo(){
			$this->auth->check_logged('gerenciador/'.$this->router->class, $this->router->method);

			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';
			$data['empresas'] = $this->empresaModel->getEmpresasCombo();
			$this->load->view('usuarioView', $data);
		}
		
		function editar($usuario_id){
			$this->auth->check_logged('gerenciador/'.$this->router->class, $this->router->method);
			
			$data['usuario'] = $this->usuarioModel->getUsuario($usuario_id);
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.$data['usuario']->nome;						
			$data['empresas'] = $this->empresaModel->getEmpresasCombo();
			$data['permissao_aplicativos'] = $this->usuarioModel->getMenuPermissoesByUsuarioId($usuario_id);			
			$this->load->view('usuarioView', $data);
		}

		function salvar(){
			$this->auth->check_logged('gerenciador/'.$this->router->class, $this->router->method);

			if($_POST['txtCodigo'] == '')
				$ret = $this->usuarioModel->incluir($_POST);
			else
				$ret = $this->usuarioModel->alterar($_POST);
				
			if($ret)
				$this->ajax->ajaxMessage('success', lang('registroGravado'));
			else
				$this->ajax->addAjaxData('error', $this->usuarioModel->validate->getError());

			$this->ajax->returnAjax();
		}

		function salvarUsuarioProgramaAcessos(){
			$this->auth->check_logged('gerenciador/'.$this->router->class, $this->router->method);
			
			$ret = $this->usuarioModel->incluirProgramasAcessos($_POST);

			if($ret)
				$this->ajax->ajaxMessage('success', lang('registroGravado'));
			else
				$this->ajax->addAjaxData('error', $this->usuarioModel->validate->getError());

			$this->ajax->returnAjax();
		}
		
		function excluir(){
			$isSUccess = $this->usuarioModel->excluir($_POST['id']);
			
			if($isSUccess)
				$this->ajax->addAjaxData('success', 'true');
			else
				$this->ajax->addAjaxData('success', 'false');
			
			$this->ajax->returnAjax();
		}
		
		function incluirEmpresa(){
			$this->auth->check_logged('gerenciador/'.$this->router->class, $this->router->method);

			$ret = $this->usuarioModel->incluirEmpresa($_POST);
			
			if($ret)
				$this->ajax->ajaxMessage('success', lang('registroGravado'));
			else
				$this->ajax->addAjaxData('error', $this->grupoModel->validate->getError());

			$this->ajax->returnAjax();
		}
		
		function excluirEmpresa(){
			$isSucess = $this->usuarioModel->excluirEmpresa($_POST['usuarioId'], $_POST['empresaId']);
			
			if($isSucess){
				$this->ajax->addAjaxData('success', 'true');
			}else{
				$this->ajax->addAjaxData('success', 'false');
			}
			$this->ajax->returnAjax();
		}

		function listaGruposAcessos(){
			$this->ajax->returnJqGrid($this->grupoAcessoModel->getGruposAcessos($_GET, false));
		}

		function listaGruposAcessosUsuario(){			
			$this->ajax->AddAjaxData('usuarioGruposAcessos', $this->usuarioModel->getGruposAcessosUsuario($_POST['usuarioId']));
			$this->ajax->returnAjax();
		}

		function listaEmpresas(){
			$this->ajax->returnJqGrid($this->usuarioModel->getEmpresasUsuario($_GET));
		}		

		function listaPerfisUsuario(){
			$this->ajax->AddAjaxData('usuarioPerfis', $this->usuarioModel->getPerfisUsuario($_POST['usuarioId'], $_POST['empresaId']));
			$this->ajax->returnAjax();
		}

		function salvarPerfis(){
			$ret = $this->usuarioModel->salvarPerfis($_POST);

			if($ret)
				$this->ajax->addAjaxData('success', 'true');
			else
				$this->ajax->addAjaxData('success', 'false');

			$this->ajax->returnAjax();
		}

		function getEmpresaUsuario(){
			$this->ajax->addAjaxData('usuarioEmpresa', $this->usuarioModel->getEmpresaUsuario($_POST['usuarioId'], $_POST['empresaId']));
			$this->ajax->returnAjax();
		}

		function permissoes($programaId){
			$aProgramaId = explode('-', $programaId);
			$data['programaId'] = $aProgramaId[0];
			$data['usuarioId'] = $aProgramaId[2];
			$this->load->view('usuarioPermissoesView', $data);
		}				
		
		function listaMetodosGrid($programaId){			
			$programa = $this->programaModel->getPrograma($programaId);			
			$this->ajax->returnJqGrid($this->permissaoModel->getMetodosGrid($_GET, $programa->link));
		}
		
		function salvarPermissoes(){
			$ret = $this->usuarioModel->salvarPermissoes($_POST);
			
			if($ret)
				$this->ajax->addAjaxData('success', 'true');
			else
				$this->ajax->addAjaxData('success', 'false');

			$this->ajax->returnAjax();
		}
		
		function listaMetodosUsuario(){
			$this->ajax->AddAjaxData('usuarioPermissoes', $this->usuarioModel->getPermissoesUsuario($_POST['usuarioId'], $_POST['programaId']));
			$this->ajax->returnAjax();
		}
		
		function salvarGruposAcessos(){
			$ret = $this->usuarioModel->salvarGruposAcessos($_POST);

			if($ret)
				$this->ajax->addAjaxData('success', 'true');
			else
				$this->ajax->addAjaxData('success', 'false');
	
			$this->ajax->returnAjax();		
		}

		function fazerLoginComo($usuarioId){
			$this->auth->check_logged('gerenciador/'.$this->router->class, $this->router->method);
			
			$this->loginModel->autenticaUsuarioById($usuarioId);		

			$this->session->set_userdata('menu', $this->usuarioModel->getMenuByUsuarioId($usuarioId));
			$this->session->set_userdata('ANO_MATRICULA_DEFAULT', $this->parametroModel->getParametroNome('ANO_MATRICULA_DEFAULT'));
			$this->session->set_userdata('SEMESTRE_MATRICULA_DEFAULT', $this->parametroModel->getParametroNome('SEMESTRE_MATRICULA_DEFAULT'));
			setcookie('navigationtree', '', time() - 3600, PATH_COOKIE);
			setcookie('showMenu', '', time() - 3600, PATH_COOKIE);
			setcookie('redirect', '', time()- 3600, PATH_COOKIE);		
			redirect('dashboard');
		}

	}