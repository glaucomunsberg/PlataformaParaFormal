<?php
/**
 * @package cgic
 * @subpackage bolsista
 */
	class RegistroAtividade extends Controller {

		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
			$this->load->model('equipe/RegistroAtividadeModel', 'registroAtividadeModel');
		}

		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('equipe/registroAtividadeFiltroView', $data);
		}

		function listaAtividadesRegistradas(){
			$this->registroAtividadeModel->getAtividadesRegistros($_GET,getUsuarioSession()->pessoa_id);
		}

		function novo(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / Novo';
			$data['pessoaId'] = getUsuarioSession()->pessoa_id;
			$data['entrada_saida'] = array(
				array('id' => 'E', 'value' => 'Entrada'),
				array('id' => 'S', 'value' => 'Saída'));

			$this->load->view('equipe/registroAtividadeView', $data);
		}

		function salvar(){
			$ret = $this->registroAtividadeModel->inserir($_POST);

			if($ret)
				$this->ajax->ajaxMessage('success', lang('registroGravado'));
			else
				$this->ajax->addAjaxData('error', $this->registroAtividadeModel->validate->getError());

			$this->ajax->returnAjax();
		}



	}