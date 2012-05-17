<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class ElementoSituacao extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
			$this->load->model('cadastrosBasicos/ElementoSituacaoModel', 'elementoSituacaoModel');
		}
		
		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('cadastrosBasicos/elementoSituacaoFiltroView', $data);
		}
		
		function listaElementosSituacoes(){
			$this->ajax->returnJqGrid($this->elementoSituacaoModel->getElementosSituacoes($_GET));
		}
		
		function novo(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';			
			$this->load->view('cadastrosBasicos/elementoSituacaoView', $data);
		}

		function editar($ElementoSituacaoId){
			$data['elementos_situacoes'] = $this->elementoSituacaoModel->getElementoSituacao($ElementoSituacaoId);
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['elementos_situacoes']->descricao;
			$this->load->view('cadastrosBasicos/elementoSituacaoView', $data);
		}
		
		function excluir(){
			$isSUccess = $this->elementoSituacaoModel->excluir($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}
		
		function salvar(){
	        if (empty($_POST['txtElementoSituacaoId'])) {
                        $ret = $this->elementoSituacaoModel->inserir($_POST);
                    } else {
                        $ret = $this->elementoSituacaoModel->alterar($_POST);
                    }
                    if ($ret !== FALSE) {
                        $this->ajax->addAjaxData('elementos_situacoes', $ret);
                        $this->ajax->ajaxMessage('success', lang('registroGravado'));
                    } else {
                        if (!$this->elementoSituacaoModel->validate->existsErrors()) {
                            $this->elementoSituacaoModel->validate->addError("txtElementoSituacaoId", lang('registroNaoGravado'));
                        }
                        $this->ajax->addAjaxData('error', $this->elementoSituacaoModel->validate->getError());
                    }
                    $this->ajax->returnAjax();
		}
		
	}	