<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class grupoAtividadeModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getGrupoAtividadeCombo() {
			$this->db->select('ga.id, c.nome || \'-\' || uf.sigla as descricao', false);
                        $this->db->join('cidades as c', 'ga.cidade_id = c.id');
                        $this->db->join('unidades_federativas as uf', 'c.unidade_federativa_id = uf.id');
			$this->db->orderby('id', 'asc');
			return $this->db->get('grupos_atividades as ga')->result_array();
		}

		function inserir($grupoAtividade){
			$this->db->trans_start();
			$this->db->set('descricao', $grupoAtividade['txtDescricao']);
                        $this->db->set('cidade_id', $grupoAtividade['txtGrupoAtividadeCidadeId']);
                        $this->db->set('geocode_origem_lat', $grupoAtividade['txtLatOrigem']);
                        $this->db->set('geocode_origem_lng', $grupoAtividade['txtLngOrigem']);
                        $this->db->set('geocode_destino_lat', $grupoAtividade['txtLatDestino']);
                        $this->db->set('geocode_destino_lng', $grupoAtividade['txtLngDestino']);
                        if (!empty($grupoAtividade['Dt_Ocorrencia'])) {
                            $this->db->set('dt_ocorrencia', ($grupoAtividade['Dt_Ocorrencia'] == '' ? 'NULL' : 'to_date(\'' . $grupoAtividade['Dt_Ocorrencia'] . '\', \'dd/mm/yyyy\')'), false);
                        }
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('grupos_atividades');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('grupo_atividade', $this->getGrupoAtividade($this->db->insert_id('grupos_atividades', 'id')));
			return true;
		}

		function alterar($gruposAtividades){

			$this->db->trans_start();
			$this->db->set('descricao', $gruposAtividades['txtDescricao']);	
                        $this->db->set('cidade_id', $gruposAtividades['txtGrupoAtividadeCidadeId']);
                        $this->db->set('geocode_origem_lat', $gruposAtividades['txtLatOrigem']);
                        $this->db->set('geocode_origem_lng', $gruposAtividades['txtLngOrigem']);
                        $this->db->set('geocode_destino_lat', $gruposAtividades['txtLatDestino']);
                        $this->db->set('geocode_destino_lng', $gruposAtividades['txtLngDestino']);
                        if (!empty($gruposAtividades['Dt_Ocorrencia'])) {
                            $this->db->set('dt_ocorrencia', ($gruposAtividades['Dt_Ocorrencia'] == '' ? 'NULL' : 'to_date(\'' . $gruposAtividades['Dt_Ocorrencia'] . '\', \'dd/mm/yyyy\')'), false);
                        }
			$this->db->where('id', $gruposAtividades['txtGrupoAtividadeId']);
			$this->db->update('grupos_atividades');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('grupo_atividade', $this->getGrupoAtividade($gruposAtividades['txtGrupoAtividadeId']));
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
				$this->db->delete('grupos_atividades');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function getGrupoAtividade($grupoAtividadeId){
			$this->db->where('id', $grupoAtividadeId);
			return $this->db->get('grupos_atividades')->row();
		}
		
		function getGruposAtividades($parametros){
			$this->db->select('ga.id, ga.descricao, c.id as cidadeId, c.nome as nomecidade, to_char(ga.dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro, to_char(ga.dt_ocorrencia, \'dd/mm/yyyy hh24:mi:ss\') as dt_ocorrencia', false);
                        $this->db->from('grupos_atividades as ga');
                        $this->db->join('cidades as c','ga.cidade_id = c.id', 'left');
                        if(@$parametros['txtDescricao'] != null )
                                $this->db->like('upper(ga.descricao)', @$parametros['txtDescricao']);
                        if(@$parametros['txtGrupoAtividadeCidadeId'] != null )
                                $this->db->where('ga.cidade_id', @$parametros['txtGrupoAtividadeCidadeId']);
                        if (@$parametros['Dt_Ocorrencia'])
				$this->db->where('date(ga.dt_ocorrencia) between to_date(\''. $parametros['Dt_Ocorrencia'] .'\', \'dd/mm/yyyy\') and to_date(\''.$parametros['Dt_Ocorrencia'].'\', \'dd/mm/yyyy\')');
			$this->db->sendToGrid();
		}

		function validaGrupoAtividade($local){
			$this->validate->setData($local);			
				
			$this->validate->validateField('txtLocalId', array('required'), lang('gruposDeAtividadesDescricaoDeveSerInformado'));
			return $this->validate->existsErrors();
		}

	}