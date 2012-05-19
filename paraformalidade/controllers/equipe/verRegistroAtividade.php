<?php
/**
 * @package cgic
 * @subpackage bolsista
 */
	class VerRegistroAtividade extends Controller {

		function __construct(){
			parent::__construct();
			$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
                        $this->load->model('../../gerenciador/models/PessoaModel', 'pessoaModel');
			$this->load->model('equipe/RegistroAtividadeModel', 'registroAtividadeModel');
		}

		function index(){
			$data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
			$this->load->view('equipe/verRegistroAtividadeFiltroView', $data);
		}

		function listaEquipeComRegistradas(){
			$this->registroAtividadeModel->getEquipeComAtividades($_GET);
		}
                
                function verRegistrosDeAtividade($pessoaId){
                    $data['pessoa'] = $this->pessoaModel->getPessoa($pessoaId);
                    $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']).' / '.@$data['pessoa']->nome;
                    $this->load->view('equipe/verRegistroAtividadeView', $data);
                }
                
                function listaRegistrosDeAtividade(){
                    $this->registroAtividadeModel->getAtividadesRegistrosPorPessoa($_GET);
                }



	}