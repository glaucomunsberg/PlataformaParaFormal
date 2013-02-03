<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class EquipamentoPortes extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
			$this->load->model('cadastrosBasicos/EquipamentoPortesModel', 'equipamentoPortesModel');
		}
		
		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('cadastrosBasicos/equipamentoPortesFiltroView', $data);
		}
		
		function listaEquipamentoPortes(){
			$this->equipamentoPortesModel->getEquipamentoPortes($_GET);
		}
		
		function novo(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';			
			$this->load->view('cadastrosBasicos/equipamentoPortesView', $data);
		}

		function editar($equipamentoPorteId){
			$data['equipamento_portes'] = $this->equipamentoPortesModel->getEquipamentoPorte($equipamentoPorteId);
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['equipamento_Portes']->descricao;
			$this->load->view('cadastrosBasicos/equipamentoPortesView', $data);
		}
		
		function excluir(){
			$isSUccess = $this->equipamentoPortesModel->excluir($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}
		
		function salvar(){
	        if (empty($_POST['txtEquipamentoPortesId'])) {
                        $ret = $this->equipamentoPortesModel->inserir($_POST);
                    } else {
                        $ret = $this->equipamentoPortesModel->alterar($_POST);
                    }
                    if ($ret !== FALSE) {
                        $this->ajax->addAjaxData('equipamento_portes', $ret);
                        $this->ajax->ajaxMessage('success', lang('registroGravado'));
                    } else {
                        if (!$this->equipamentoPortesModel->validate->existsErrors()) {
                            $this->equipamentoPortesModel->validate->addError("txtEquipamentoPortesId", lang('registroNaoGravado'));
                        }
                        $this->ajax->addAjaxData('error', $this->equipamentoPortesModel->validate->getError());
                    }
                    $this->ajax->returnAjax();
		}
		
	}	