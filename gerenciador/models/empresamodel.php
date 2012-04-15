<?php

	class EmpresaModel extends Model {
	
		function __construct(){
			parent::__construct();			
		}
		
		function inserir($empresa){
			$retErro = $this->validaEmpresa($empresa);
			if($retErro)
				return false;
			
			$this->db->set('nome', $empresa['txtNome']);
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('empresas');
			
			$empresa_id = $this->db->insert_id();

			if($empresa['txtPerfis'] != ''){
				$perfis = explode(',', $empresa['txtPerfis']);
				for($i = 0; $i < count($perfis); $i++){
					$this->db->set('empresa_id', $empresa_id);
					$this->db->set('perfil_id', $perfis[$i]);
					$this->db->insert('empresas_perfis');
				}
			}

			$this->ajax->addAjaxData('empresa', $this->getEmpresa($empresa_id));
			return true;
		}

		function alterar($empresa) {
			$retErro = $this->validaEmpresa($empresa);
			if($retErro)
				return false;
				
			$this->db->trans_begin();
				$this->db->set('nome', $empresa['txtNome']);
				$this->db->where('id', $empresa['txtCodigo']);
				$this->db->update('empresas');
			
				$this->db->where('empresa_id', $empresa['txtCodigo']);
				$this->db->delete('empresas_perfis');
				
				if($empresa['txtPerfis'] != ''){
					$perfis = explode(',', $empresa['txtPerfis']);
					for($i = 0; $i < count($perfis); $i++){
						$this->db->set('empresa_id', $empresa['txtCodigo']);
						$this->db->set('perfil_id', $perfis[$i]);
						$this->db->insert('empresas_perfis');
					}
				}
				
				if($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					return false;
				}
			$this->db->trans_commit();
			
			$this->ajax->addAjaxData('empresa', $this->getEmpresa($empresa['txtCodigo']));
			return true;
		}
		
		function excluir($id) {
			$this->db->trans_begin();

				$aEmpresas = explode(',', $id);
				$aExcluirEmpresas = array();
				for($i = 0; $i < count($aEmpresas); $i++)
					if($aEmpresas[$i] != 'undefined')
						array_push($aExcluirEmpresas, $aEmpresas[$i]);

				$this->db->where_in('empresa_id', $aExcluirEmpresas);
				$this->db->delete('empresas_perfis');

				$this->db->where_in('id', $aExcluirEmpresas);
				$this->db->delete('empresas');

				if($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					return false;
				}

			$this->db->trans_commit();
			return true;
		}

		function getEmpresas($parametros) {
			$paramsJqGrid = $this->ajax->setParametersJqGrid($parametros);

			$this->db->select('id, nome, date_format(dt_cadastro, \'%d/%m/%Y\') as dt_cadastro', false);
			$this->db->like('upper(nome)', strtoupper(@$parametros['nomeEmpresa']));
			$this->db->order_by($paramsJqGrid->sortField, $paramsJqGrid->sortDirection);
			$result = $this->db->get('empresas');

			$paramsJqGrid = $this->ajax->setStartLimitJqGrid($parametros, $result->num_rows());
			$paramsJqGrid->rows = $result->result();
			return $paramsJqGrid;
		}

		function getEmpresa($id){
			$this->db->select('id, nome, date_format(dt_cadastro, \'%d/%m/%Y\') as dt_cadastro', false);
			$this->db->where('id', $id);
			return $this->db->get('empresas')->row();
		}

		function getEmpresasCombo(){
			$this->db->select('id, nome');
			$this->db->order_by('nome', 'asc');
			return $this->db->get('empresas')->result_array();
		}

		function getPerfisEmpresa($empresaId){
			$this->db->where('empresa_id', $empresaId);
			return $this->db->get('empresas_perfis')->result();
		}
		
		function getPerfisEmpresaGrid($parametros){
			$this->db->select('e.perfil_id as id, p.nome_perfil');
			$this->db->from('empresas_perfis as e');
			$this->db->join('perfis as p', 'p.id = e.perfil_id');
			$this->db->where('e.empresa_id', $parametros['empresaId']);
			$result = $this->db->get();

			$paramsJqGrid = $this->ajax->setStartLimitJqGrid($parametros, $result->num_rows());
			$paramsJqGrid->rows = $result->result();
			return $paramsJqGrid;
		}

		function validaEmpresa ($data) {
			$this->validate->setData($data);
			$this->validate->validateField('txtNome', array('required'), 'Nome deve ser informado');
			return $this->validate->existsErrors();
		}		

	}