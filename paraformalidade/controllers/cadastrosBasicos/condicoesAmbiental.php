<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class CondicoesAmbiental extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
			$this->load->model('cadastrosBasicos/CondicoesAmbientalModel', 'condicoesAmbientalModel');
		}
		
		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('cadastrosBasicos/condicoesAmbientalFiltroView', $data);
		}
		
		function listaCondicoesAmbientais(){
			$this->condicoesAmbientalModel->getCondicoesAmbientais($_GET);
		}
		
		function novo(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';			
			$this->load->view('cadastrosBasicos/condicoesAmbientalView', $data);
		}

		function editar($CondicaoAmbientalId){
			$data['condicao_ambiental'] = $this->condicoesAmbientalModel->getCondicoesAmbiental($CondicaoAmbientalId);
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['condicao_ambiental']->descricao;
			$this->load->view('cadastrosBasicos/condicoesAmbientalView', $data);
		}
		
		function excluir(){
			$isSUccess = $this->condicoesAmbientalModel->excluir($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}
		
		function salvar(){
	        if (empty($_POST['txtCondicaoAmbientalId'])) {
                        $ret = $this->condicoesAmbientalModel->inserir($_POST);
                    } else {
                        $ret = $this->condicoesAmbientalModel->alterar($_POST);
                    }
                    if ($ret !== FALSE) {
                        $this->ajax->addAjaxData('condicao_ambiental', $ret);
                        $this->ajax->ajaxMessage('success', lang('registroGravado'));
                    } else {
                        if (!$this->condicoesAmbientalModel->validate->existsErrors()) {
                            $this->condicoesAmbientalModel->validate->addError("txtCondicaoAmbientalId", lang('registroNaoGravado'));
                        }
                        $this->ajax->addAjaxData('error', $this->condicoesAmbientalModel->validate->getError());
                    }
                    $this->ajax->returnAjax();
		}
		
	}	