<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class CorpoNumeros extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
			$this->load->model('cadastrosBasicos/CorpoNumerosModel', 'corpoNumerosModel');
		}
		
		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('cadastrosBasicos/corpoNumerosFiltroView', $data);
		}
		
		function listaCorpoNumeros(){
			$this->corpoNumerosModel->getCorpoNumeros($_GET);
		}
		
		function novo(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';			
			$this->load->view('cadastrosBasicos/corpoNumerosView', $data);
		}

		function editar($corpoNumeroId){
			$data['corpo_numeros'] = $this->corpoNumerosModel->getCorpoNumero($corpoNumeroId);
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['corpo_numeros']->descricao;
			$this->load->view('cadastrosBasicos/corpoNumerosView', $data);
		}
		
		function excluir(){
			$isSUccess = $this->corpoNumerosModel->excluir($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}
		
		function salvar(){
	        if (empty($_POST['txtCorpoNumerosId'])) {
                        $ret = $this->corpoNumerosModel->inserir($_POST);
                    } else {
                        $ret = $this->corpoNumerosModel->alterar($_POST);
                    }
                    if ($ret !== FALSE) {
                        $this->ajax->addAjaxData('corpo_numeros', $ret);
                        $this->ajax->ajaxMessage('success', lang('registroGravado'));
                    } else {
                        if (!$this->corpoNumerosModel->validate->existsErrors()) {
                            $this->corpoNumerosModel->validate->addError("txtCorpoNumerosId", lang('registroNaoGravado'));
                        }
                        $this->ajax->addAjaxData('error', $this->corpoNumerosModel->validate->getError());
                    }
                    $this->ajax->returnAjax();
		}
		
	}	