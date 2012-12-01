<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class AtividadeRegistradaModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getAtividadesRegistradasCombo() {
			$this->db->select('id, descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('tipos_registros_atividades')->result_array();
		}

		function inserir($locais){
			$this->db->trans_start();
			$this->db->set('descricao', $locais['txtDescricao']);
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('tipos_registros_atividades');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('atividades_registradas', $this->getAtividadeRegistrada($this->db->insert_id('tipos_registros_atividades', 'id')));
			return true;
		}

		function alterar($locais){

			$this->db->trans_start();
			$this->db->set('descricao', $locais['txtDescricao']);		
			$this->db->where('id', $locais['txtAtividadeRegistradaId']);
			$this->db->update('tipos_registros_atividades');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('tipos_registros_atividades', $this->getAtividadeRegistrada($locais['txtAtividadeRegistradaId']));
			return true;
		}

		function excluir($id){
			
			$this->db->trans_start();
				$aAtividadesRegistradas = explode(',', $id);
				$aExcluirAtividadesRegistradas = array();
				for($i = 0; $i < count($aAtividadesRegistradas); $i++)
					if($aAtividadesRegistradas[$i] != 'undefined')
						array_push($aExcluirAtividadesRegistradas, $aAtividadesRegistradas[$i]);

				$this->db->where_in('id', $aExcluirAtividadesRegistradas);
				$this->db->delete('tipos_registros_atividades');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function getAtividadeRegistrada($AtividadeRegistradaId){
			$this->db->where('id', $AtividadeRegistradaId);
			return $this->db->get('tipos_registros_atividades')->row();
		}
		
		function getAtividadesRegistradas($parametros){
			$this->db->select('id, descricao, to_char(dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
                        $this->db->from('tipos_registros_atividades');
                        if(@$parametros['descricao'] != '')
                            $this->db->like('upper(descricao)', strtoupper(@$parametros['descricao']));
                        $this->db->sendToGrid();
		}

		function validaAtividadeRegistrada($local){
			$this->validate->setData($local);			
				
			$this->validate->validateField('txtLocalId', array('required'), lang('AtividadesRegistradasDescricaoDeveSerInformado'));
			return $this->validate->existsErrors();
		}

	}