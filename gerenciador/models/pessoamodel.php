<?php
	class PessoaModel extends Model{
		
		function __construct(){
			parent::__construct();			
		}
		
		function inserir($pessoa) {
			$retErro = $this->validaPessoa($pessoa);
			if($retErro){
				return false;
			}
			
			$dados = array('nome' => $pessoa['txtNome'],
						   'cpf' => $pessoa['txtCpf'],
						   'senha' => $pessoa['txtSenha'],
						   'dt_cadastro' => "now()" );						   
			$this->db->insert('pessoas', $dados);
			$this->ajax->addAjaxData('pessoa', $this->getPessoa($this->db->insert_id()));
			return true;
		}
		
		function alterar($pessoa) {
			$retErro = $this->validaPessoa($pessoa);
			if($retErro)
				return false;

			$gruposUsuario = explode(",", $pessoa['txtGrupos']);
			
			$dados = array('nome' => $pessoa['txtNome'],
						   'dt_cadastro' => "now()");
			$this->db->where('id', $pessoa['txtCodigo']);
			$this->db->update('pessoas', $dados);			
			$this->ajax->addAjaxData('pessoa', $this->getPessoa($pessoa['txtCodigo']));
			
			$this->db->where('pessoa_id', $pessoa['txtCodigo']);
			$this->db->delete('pessoas_grupos');
			
			for($i = 0; $i < count($gruposUsuario); $i++){
				$dados = array('pessoa_id' => $pessoa['txtCodigo'],
								'grupo_id' => $gruposUsuario[$i]);
				$this->db->insert('pessoas_grupos', $dados);
			}
			
			return true;
		}
		
		function excluir($id) {
			$this->db->where('id', $id);
			$this->db->delete('pessoas');
		}
		
		function getPessoas($nomePessoa = '', $cpf = '', $start, $limit){			
			$this->db->select('count(*) as quant');
			$this->db->like('nome',$nomePessoa);
			$this->db->like('cpf',$cpf);
			$total = $this->db->get('pessoas')->row();						
			$dados['total'] = $total->quant;
			
			$this->db->select('id, nome as nome, cpf, date_format(dt_cadastro, \'%d/%m/%Y\') as dt_cadastro', false);
			$this->db->like('nome',$nomePessoa);
			$this->db->like('cpf',$cpf);
			$this->db->orderby('nome', 'asc');
			$dados['results'] = $this->db->get('pessoas', $limit, $start)->result();
			return $dados;
		}
		
		function getPessoasCombo() {
			$this->db->select('id, nome as nome', false);
			$this->db->orderby('nome', 'asc');
			return $this->db->get('pessoas')->result_array();
		}
		
		function getPessoa($id){
			$this->db->select('id, nome, sexo, date_format(dt_cadastro, \'%d/%m/%Y\') as dt_cadastro,date_format(dt_nascimento, \'%d/%m/%Y\') as dt_nascimento, email, rg, cpf', false);
			$this->db->where('id', $id);
			return $this->db->get('pessoas')->row();
		}

		function getPessoaByRg($rg){
			$this->db->where('rg', $rg);
			return $this->db->get('pessoas')->row();
		}

		function getPessoaByCpf($cpf){
			$this->db->where('cpf', str_ireplace('-', '', str_ireplace('.', '', $cpf)));
			return $this->db->get('pessoas')->row();
		}		

		function getGruposPessoa($idPessoa){
			$this->db->where('pessoa_id', $idPessoa);
			return $this->db->get('pessoas_grupos')->result();
		}

		function validaPessoa($data) {
			$this->validate->setData($data);
			$this->validate->validateField('txtNome', array('required'), lang('pessoaNomeRequerido'));
			return $this->validate->existsErrors();
		}
		
	}
?>