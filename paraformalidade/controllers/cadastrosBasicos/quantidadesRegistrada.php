<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class QuantidadesRegistrada extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
			$this->load->model('cadastrosBasicos/QuantidadesRegistradaModel', 'quantidadesRegistradaModel');
		}
		
		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('cadastrosBasicos/quantidadesRegistradaFiltroView', $data);
		}
		
		function listaQuantidadesRegistradas(){
			$this->quantidadesRegistradaModel->getQuantidadesRegistradas($_GET);
		}
		
		function novo(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';			
			$this->load->view('cadastrosBasicos/quantidadesRegistradaView', $data);
		}

		function editar($QuantidadesRegistradaId){
			$data['quantidadess_registradas'] = $this->quantidadesRegistradaModel->getQuantidadesRegistrada($QuantidadesRegistradaId);
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Editar / '.@$data['quantidades_registradas']->descricao;
			$this->load->view('cadastrosBasicos/quantidadesRegistradaView', $data);
		}
		
		function excluir(){
			$isSUccess = $this->quantidadesRegistradaModel->excluir($_POST['id']);

			if($isSUccess)
				$this->ajax->addAjaxData('success', true);
			else
				$this->ajax->addAjaxData('success', false);

			$this->ajax->returnAjax();
		}
		
		function salvar(){
	        if (empty($_POST['txtQuantidadesRegistradaId'])) {
                        $ret = $this->quantidadesRegistradaModel->inserir($_POST);
                    } else {
                        $ret = $this->quantidadesRegistradaModel->alterar($_POST);
                    }
                    if ($ret !== FALSE) {
                        $this->ajax->addAjaxData('quantidades_registradas', $ret);
                        $this->ajax->ajaxMessage('success', lang('registroGravado'));
                    } else {
                        if (!$this->quantidadesRegistradaModel->validate->existsErrors()) {
                            $this->quantidadesRegistradaModel->validate->addError("txtQuantidadesRegistradaId", lang('registroNaoGravado'));
                        }
                        $this->ajax->addAjaxData('error', $this->quantidadesRegistradaModel->validate->getError());
                    }
                    $this->ajax->returnAjax();
		}
		
	}	