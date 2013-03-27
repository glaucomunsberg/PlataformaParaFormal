<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class cenasModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getCenaseCombo() {
			$this->db->select('c.id, c.descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('paraformal.cenas as c')->result_array();
		}

		function inserir($cena){
			$this->db->trans_start();
			$this->db->set('descricao', $cena['txtCenaDescricao']);
                        $this->db->set('grupo_atividade_id', $cena['txtGrupoAtividadeid']);
                        if (!empty($cena['Dt_Ocorrencia'])) {
                            $this->db->set('dt_ocorrencia', ($cena['Dt_Cena_Ocorrencia'] == '' ? 'NULL' : 'to_date(\'' . $cena['Dt_Cena_Ocorrencia'] . '\', \'dd/mm/yyyy\')'), false);
                        }
                        $this->db->set('estaativo', $cena['chkCenaAtivo']);
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('paraformal.cenas');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('cena', $this->getCena($this->db->insert_id('paraformal.cenas', 'id')));
			return true;
		}

		function alterar($cena){

			$this->db->trans_start();
			$this->db->set('descricao', $cena['txtCenaDescricao']);
                        $this->db->set('grupo_atividade_id', $cena['txtGrupoAtividadeid']);
                        if (!empty($cena['Dt_Ocorrencia'])) {
                            $this->db->set('dt_ocorrencia', ($cena['Dt_Cena_Ocorrencia'] == '' ? 'NULL' : 'to_date(\'' . $cena['Dt_Cena_Ocorrencia'] . '\', \'dd/mm/yyyy\')'), false);
                        }
                        $this->db->set('estaativo', $cena['chkCenaAtivo']);
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->where('id', $cena['txtCenaId']);
			$this->db->update('paraformal.cenas');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('cena', $this->getCena($cena['txtGrupoAtividadeid']));
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
				$this->db->delete('paraformal.cenas');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function getCena($cena){
			$this->db->where('id', $cena);
                        $this->db->from('paraformal.cenas');
			return $this->db->get()->row();
		}
		
		function getCenas($parametros){
			$this->db->select('c.id, c.descricao, c.dt_ocorrencia, c.estaativo, c.dt_cadastro, ga.descricao as grupo_atividade, c.grupo_atividade_id', false);
                        $this->db->from('paraformal.cenas as c');
                        $this->db->join('paraformal.grupos_atividades as ga','ga.id = c.grupo_atividade_id');
                        if(@$parametros['txtGrupoAtividadeCidadeId'] != null )
                                $this->db->where('ga.cidade_id', @$parametros['txtGrupoAtividadeCidadeId']);
                        if(@$parametros['txtAtividadeNome'] != null )
                                $this->db->like('upper(ga.descricao)', strtoupper(@$parametros['txtAtividadeNome']));
			$this->db->sendToGrid();
		}

		function validaGrupoAtividade($local){
			$this->validate->setData($local);			
				
			$this->validate->validateField('txtGrupoAtividadeId', array('required'), lang('gruposDeAtividadesDescricaoDeveSerInformado'));
			return $this->validate->existsErrors();
		}

	}