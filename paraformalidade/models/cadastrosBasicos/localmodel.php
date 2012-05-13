<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class LocalModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getLocaisCombo() {
			$this->db->select('id, descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('tipos_locais')->result_array();
		}

		function inserir($locais){
			$this->db->trans_start();
			$this->db->set('descricao', $locais['txtDescricao']);
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('tipos_locais');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('tipos_locais', $this->getLocal($this->db->insert_id('tipos_locais', 'id')));
			return true;
		}

		function alterar($locais){

			$this->db->trans_start();
			$this->db->set('descricao', $locais['txtDescricao']);		
			$this->db->where('id', $locais['txtLocalId']);
			$this->db->update('tipos_locais');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('tipos_locais', $this->getLocal($locais['txtLocalId']));
			return true;
		}

		function excluir($id){
			
			$this->db->trans_start();
				$aLocais = explode(',', $id);
				$aExcluirLocais = array();
				for($i = 0; $i < count($aLocais); $i++)
					if($aLocais[$i] != 'undefined')
						array_push($aExcluirLocais, $aLocais[$i]);

				$this->db->where_in('id', $aExcluirLocais);
				$this->db->delete('tipos_locais');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function getLocal($LocalId){
			$this->db->where('id', $LocalId);
			return $this->db->get('tipos_locais')->row();
		}
		
		function getLocais($parametros){
			$this->db->select('count(*) as quantidade');
			$this->db->like('upper(descricao)', strtoupper(@$parametros['descricao']));
			$total = $this->db->get('tipos_locais')->row();

			$paramsJqGrid = $this->ajax->setStartLimitJqGrid($parametros, $total->quantidade);

			$this->db->select('id, descricao, to_char(dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
			$this->db->like('upper(descricao)', strtoupper(@$parametros['descricao']));
			$this->db->order_by($paramsJqGrid->sortField, $paramsJqGrid->sortDirection);
			$result = $this->db->get('tipos_locais', $paramsJqGrid->limit, $paramsJqGrid->start);

			$paramsJqGrid->rows = $result->result();
			return $paramsJqGrid;
		}

		function validaLocal($local){
			$this->validate->setData($local);			
				
			$this->validate->validateField('txtLocalId', array('required'), lang('locaisDescricaoDeveSerInformado'));
			return $this->validate->existsErrors();
		}

	}