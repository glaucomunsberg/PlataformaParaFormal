<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class CorpoPosicoes extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
			$this->load->model('cadastrosBasicos/CorpoPosicoesModel', 'corpoPosicoesModel');
		}
		
		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('cadastrosBasicos/corpoPosicoesFiltroView', $data);
		}
		
		function listaCorpoPosicoes(){
			$this->corpoPosicoesModel->getCorpoPosicoes($_GET);
		}
		
		function novo(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';			
			$this->load->view('cadastrosBasicos/corpoPosicoesView', $data);
		}

		function editar($corpoNumeroId){
			$data['corpo_posicoes'] = $this->corpoPosicoesModel->getCorpoNumero($corpoNumeroId);
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['corpo_posicoes']->descricao;
			$this->load->view('cadastrosBasicos/corpoPosicoesView', $data);
		}
		
		function excluir(){
			$isSUccess = $this->corpoPosicoesModel->excluir($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}
		
		function salvar(){
	        if (empty($_POST['txtCorpoPosicoesId'])) {
                        $ret = $this->corpoPosicoesModel->inserir($_POST);
                    } else {
                        $ret = $this->corpoPosicoesModel->alterar($_POST);
                    }
                    if ($ret !== FALSE) {
                        $this->ajax->addAjaxData('corpo_posicoes', $ret);
                        $this->ajax->ajaxMessage('success', lang('registroGravado'));
                    } else {
                        if (!$this->corpoPosicoesModel->validate->existsErrors()) {
                            $this->corpoPosicoesModel->validate->addError("txtCorpoPosicoesId", lang('registroNaoGravado'));
                        }
                        $this->ajax->addAjaxData('error', $this->corpoPosicoesModel->validate->getError());
                    }
                    $this->ajax->returnAjax();
		}
		
	}	