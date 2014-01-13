<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class gruposAtividadesModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getGrupoAtividadeCombo() {
			$this->db->select('ga.id, c.nome || \'-\' || uf.sigla as descricao', false);
                        $this->db->join('cidades as c', 'ga.cidade_id = c.id');
                        $this->db->join('unidades_federativas as uf', 'c.unidade_federativa_id = uf.id');
			$this->db->orderby('id', 'asc');
			return $this->db->get('paraformal.grupos_atividades as ga')->result_array();
		}

		function inserir($gruposAtividades){
			$this->db->trans_start();
			$this->db->set('descricao', $gruposAtividades['txtDescricao']);
                        $this->db->set('cidade_id', $gruposAtividades['txtGrupoAtividadeCidadeId']);
                        $this->db->set('geocode_origem_latitude', $gruposAtividades['txtLatOrigem']);
                        $this->db->set('geocode_origem_longitude', $gruposAtividades['txtLngOrigem']);
                        $this->db->set('geocode_destino_latitude', $gruposAtividades['txtLatDestino']);
                        $this->db->set('geocode_destino_longitude', $gruposAtividades['txtLngDestino']);
                        if (!empty($gruposAtividades['Dt_Ocorrencia'])) {
                            $this->db->set('dt_ocorrencia', ($gruposAtividades['Dt_Ocorrencia'] == '' ? 'NULL' : 'to_date(\'' . $gruposAtividades['Dt_Ocorrencia'] . '\', \'dd/mm/yyyy\')'), false);
                        }
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('paraformal.grupos_atividades');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('grupo_atividade', $this->getGrupoAtividade($this->db->insert_id('paraformal.grupos_atividades', 'id')));
			return true;
		}

		function alterar($gruposAtividades){

			$this->db->trans_start();
			$this->db->set('descricao', $gruposAtividades['txtDescricao']);	
                        $this->db->set('cidade_id', $gruposAtividades['txtGrupoAtividadeCidadeId']);
                        $this->db->set('geocode_origem_latitude', $gruposAtividades['txtLatOrigem']);
                        $this->db->set('geocode_origem_longitude', $gruposAtividades['txtLngOrigem']);
                        $this->db->set('geocode_destino_latitude', $gruposAtividades['txtLatDestino']);
                        $this->db->set('geocode_destino_longitude', $gruposAtividades['txtLngDestino']);
                        if (!empty($gruposAtividades['Dt_Ocorrencia'])) {
                            $this->db->set('dt_ocorrencia', ($gruposAtividades['Dt_Ocorrencia'] == '' ? 'NULL' : 'to_date(\'' . $gruposAtividades['Dt_Ocorrencia'] . '\', \'dd/mm/yyyy\')'), false);
                        }
			$this->db->where('id', $gruposAtividades['txtGrupoAtividadeId']);
			$this->db->update('paraformal.grupos_atividades');
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
				$this->db->delete('paraformal.grupos_atividades');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function getGrupoAtividade($grupoAtividadeId){
			$this->db->select('id,cidade_id,geocode_origem_latitude,geocode_origem_longitude,geocode_destino_latitude,geocode_destino_longitude,dt_ocorrencia,dt_cadastro,descricao',false);
                        $this->db->from('paraformal.grupos_atividades');
                        $this->db->where('id', $grupoAtividadeId);
			return $this->db->get()->row();
		}
		
		function getGruposAtividades($parametros){
			$this->db->select('ga.id, ga.descricao, c.id as cidadeId, c.nome as nomecidade, to_char(ga.dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro, to_char(ga.dt_ocorrencia, \'dd/mm/yyyy hh24:mi:ss\') as dt_ocorrencia', false);
                        $this->db->from('paraformal.grupos_atividades as ga');
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
				
			$this->validate->validateField('txtGrupoAtividadeId', array('required'), lang('gruposDeAtividadesDescricaoDeveSerInformado'));
			return $this->validate->existsErrors();
		}

	}