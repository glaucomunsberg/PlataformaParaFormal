<?php

	class RelatorioModel extends Model{
		
		function __construct(){
			parent::__construct();			
		}
		
		function incluir($relatorio){
			$retErro = $this->validaRelatorio($relatorio);
			if($retErro)
				return false;

			$this->db->set('nome', $relatorio['txtNome']);
			$this->db->set('link', $relatorio['txtLink']);
			$this->db->insert('relatorios');
			$relatorio_id = $this->db->insert_id();

			$perfisRelatorios = explode(',', $relatorio['txtPerfisSelecionados']);
			for($i = 0; $i < count($perfisRelatorios); $i++){
				$this->db->set('perfil_id', $perfisRelatorios[$i]);
				$this->db->set('relatorio_id', $relatorio_id);
				$this->db->insert('perfis_relatorios');
			}
			
			$this->ajax->addAjaxData('relatorio', $this->getRelatorio($relatorio_id));
			return true;
		}

		function alterar($relatorio){
			$retErro = $this->validaRelatorio($relatorio);
			if($retErro)
				return false;
			
			$this->db->set('nome', $relatorio['txtNome']);
			$this->db->set('link', $relatorio['txtLink']);
			$this->db->where('id', $relatorio['txtRelatorioId']);
			$this->db->update('relatorios');
			
			$this->db->where('relatorio_id', $relatorio['txtRelatorioId']);
			$this->db->delete('perfis_relatorios');
			
			$perfisRelatorios = explode(',', $relatorio['txtPerfisSelecionados']);
			for($i = 0; $i < count($perfisRelatorios); $i++){
				$this->db->set('perfil_id', $perfisRelatorios[$i]);
				$this->db->set('relatorio_id', $relatorio['txtRelatorioId']);
				$this->db->insert('perfis_relatorios');
			}
			
			$this->ajax->addAjaxData('relatorio', $this->getRelatorio($relatorio['txtRelatorioId']));
			return true;
		}

		function excluir($relatorio_id){
			$this->db->where('relatorio_id', $relatorio_id);
			$this->db->delete('perfis_relatorios');

			$this->db->where('id', $relatorio_id);
			$this->db->delete('relatorios');
			return true;
		}

		function getRelatorio($id){
			$this->db->where('id', $id);
			return $this->db->get('relatorios')->row();
		}
		
		function getRelatorios(){
			$this->db->order_by('nome', 'asc');
			$result = $this->db->get('relatorios');
			$dados['total'] = $result->num_rows();
			$dados['results'] = $result->result();
			return $dados;
		}
		
		function getPerfisRelatorio($relatorio_id){
			$this->db->where('relatorio_id', $relatorio_id);
			return $this->db->get('perfis_relatorios')->result();
		}

		function validaRelatorio($relatorio){
			$this->validate->setData($relatorio);
			$this->validate->validateField('txtNome', array('required'), lang('gerenciadorRelatorioNomeNaoInformado'));
			$this->validate->validateField('txtLink', array('required'), lang('gerenciadorRelatorioLinkNaoInformado'));
			return $this->validate->existsErrors();
		}

	}