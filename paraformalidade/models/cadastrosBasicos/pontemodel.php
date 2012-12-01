<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class PonteModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getPonteCombo() {
			$this->db->select('id, descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('tipos_pontes')->result_array();
		}

		function inserir($pontes){
			$this->db->trans_start();
			$this->db->set('descricao', $pontes['txtDescricao']);
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('tipos_pontes');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('tipos_pontes', $this->getPonte($this->db->insert_id('tipos_pontes', 'id')));
			return true;
		}

		function alterar($pontes){

			$this->db->trans_start();
			$this->db->set('descricao', $pontes['txtDescricao']);		
			$this->db->where('id', $pontes['txtPonteId']);
			$this->db->update('tipos_pontes');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('tipos_pontes', $this->getPonte($pontes['txtPonteId']));
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
				$this->db->delete('tipos_pontes');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function getPonte($PonteId){
			$this->db->where('id', $PonteId);
			return $this->db->get('tipos_pontes')->row();
		}
		
		function getPontes($parametros){
			$this->db->select('id, descricao, to_char(dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
                        $this->db->from('tipos_pontes');
                        if(@$parametros['descricao'] != '')
                            $this->db->like('upper(descricao)', strtoupper(@$parametros['descricao']));
                        $this->db->sendToGrid();
		}

		function validaPonte($ponte){
			$this->validate->setData($ponte);				
			$this->validate->validateField('txtPonteId', array('required'), lang('ponteDescricaoDeveSerInformado'));
			return $this->validate->existsErrors();
		}

	}