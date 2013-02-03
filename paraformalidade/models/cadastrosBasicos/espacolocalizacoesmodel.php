<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class EspacoLocalizacoesModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getEspacoLocalizacoesCombo() {
			$this->db->select('id, descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('paraformal.espaco_localizacoes')->result_array();
		}

		function inserir($espacoNumero){
			$this->db->trans_start();
			$this->db->set('descricao', $espacoNumero['txtDescricao']);
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('paraformal.espaco_localizacoes');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('espaco_localizacoes', $this->getEspacoNumero($this->db->insert_id('paraformal.espaco_localizacoes', 'id')));
			return true;
		}

		function alterar($espacoLocalizacoes){

			$this->db->trans_start();
			$this->db->set('descricao', $espacoLocalizacoes['txtDescricao']);		
			$this->db->where('id', $espacoLocalizacoes['txtEspacoLocalizacoesId']);
			$this->db->update('paraformal.espaco_localizacoes');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('espaco_localizacoes', $this->getEspacoNumero($espacoLocalizacoes['txtEspacoLocalizacoesId']));
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
				$this->db->delete('paraformal.espaco_localizacoes');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function getEspacoNumero($espacoNumeroId){
			$this->db->where('id', $espacoNumeroId);
			return $this->db->get('paraformal.espaco_localizacoes')->row();
		}
		
		function getEspacoLocalizacoes($parametros){
			$this->db->select('id, descricao, to_char(dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
                        $this->db->from('paraformal.espaco_localizacoes');
                        if(@$parametros['descricao'] != '')
                            $this->db->like('upper(descricao)', strtoupper(@$parametros['descricao']));
                        $this->db->sendToGrid();
		}

		function validaPonte($ponte){
			$this->validate->setData($ponte);				
			$this->validate->validateField('txtEspacoLocalizacoesId', array('required'), lang('ponteDescricaoDeveSerInformado'));
			return $this->validate->existsErrors();
		}

	}