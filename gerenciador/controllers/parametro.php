<?php

	class Parametro extends Controller{

		function __construct(){
			parent::__construct();
			$this->load->model('ProgramaModel', 'programaModel');
			$this->load->model('ParametroModel', 'parametroModel');
		}

		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('parametroFiltroView', $data);
		}
		
		function novo(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';
			$this->load->view('parametroView', $data);
		}
		
		function salvar(){
			if($_POST['txtCodigo'] == '')
				$ret = $this->parametroModel->inserir($_POST);
			else
				$ret = $this->parametroModel->alterar($_POST);			
			
			if($ret)
				$this->ajax->ajaxMessage('sucess', lang('registroGravado'));
			else
				$this->ajax->addAjaxData('error', $this->parametroModel->validate->getError());			
						
			$this->ajax->returnAjax();
		}
		
		function excluir(){
			$isSuccess = $this->parametroModel->excluir($_POST['id']);
			
			if($isSuccess)
				$this->ajax->addAjaxData('sucess', 'true');
			else
				$this->ajax->addAjaxData('sucess', 'false');

			$this->ajax->returnAjax();
		}
		
		function editar($parametro_id){
			$data['parametro'] = $this->parametroModel->getParametro($parametro_id);
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.$data['parametro']->nome;
			$this->load->view('parametroView', $data);
		}

		function listaParametros(){			
			$this->ajax->returnJqGrid($this->parametroModel->getParametros($_GET));
		}

	}