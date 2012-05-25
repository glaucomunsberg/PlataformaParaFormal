<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class Ponte extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
			$this->load->model('cadastrosBasicos/PonteModel', 'ponteModel');
		}
		
		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('cadastrosBasicos/ponteFiltroView', $data);
		}
		
		function listaPontes(){
			$this->ajax->returnJqGrid($this->ponteModel->getPontes($_GET));
		}
		
		function novo(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';			
			$this->load->view('cadastrosBasicos/ponteView', $data);
		}

		function editar($PonteId){
			$data['tipos_pontes'] = $this->ponteModel->getPonte($PonteId);
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['tipos_pontes']->descricao;
			$this->load->view('cadastrosBasicos/ponteView', $data);
		}
		
		function excluir(){
			$isSUccess = $this->ponteModel->excluir($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}
		
		function salvar(){
	        if (empty($_POST['txtPonteId'])) {
                        $ret = $this->ponteModel->inserir($_POST);
                    } else {
                        $ret = $this->ponteModel->alterar($_POST);
                    }
                    if ($ret !== FALSE) {
                        $this->ajax->addAjaxData('tipos_pontes', $ret);
                        $this->ajax->ajaxMessage('success', lang('registroGravado'));
                    } else {
                        if (!$this->ponteModel->validate->existsErrors()) {
                            $this->ponteModel->validate->addError("txtPonteId", lang('registroNaoGravado'));
                        }
                        $this->ajax->addAjaxData('error', $this->ponteModel->validate->getError());
                    }
                    $this->ajax->returnAjax();
		}
		
	}	