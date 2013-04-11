<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class ColaborarModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function inserir($parametros){
			$this->db->trans_start();
                            $this->db->set('remote_addr',$_SERVER['REMOTE_ADDR']);
                            $this->db->set('paraformalidade_id',$parametros['txtParaformaliadeId']);
                            $this->db->set('descricao', $parametros['txtDescricao']);
                            $this->db->set('pessoa_nome', $parametros['txtNome']);
                            $this->db->set('pessoa_email', $parametros['txtEmail']);
                            if(@$parametros['txtGeoLatitude'] != '')
                                $this->db->set('geo_latitude', $parametros['txtGeoLatitude']);
                            if(@$parametros['txtGeoLongitude'] != '')
                                $this->db->set('geo_longitude', $parametros['txtGeoLongitude']);
                            if(@$parametros['txtImagemId'] != '')
                                $this->db->set('upload_id', $parametros['txtImagemId']);
                            $this->db->set('dt_cadastro', 'NOW()', false);
                            $this->db->insert('paraformal.correcao_paraformalidades');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}
			return true;
		}
                function inserirDenuncia($parametros){
			$this->db->trans_start();
                            $this->db->set('remote_addr',$_SERVER['REMOTE_ADDR']);
                            $this->db->set('denuncia', $parametros['txtDescricao']);
                            $this->db->set('pessoa_nome', $parametros['txtNome']);
                            $this->db->set('pessoa_email', $parametros['txtEmail']);
                            $this->db->set('link', $parametros['txtEmail']);
                            $this->db->set('dt_cadastro', 'NOW()', false);
                            $this->db->insert('paraformal.denuncias');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}
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

		

	}