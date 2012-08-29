<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class equipeGrupoAtividadeModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getEquipeGrupoAtividadeCombo() {
			$this->db->select('id, descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('grupos_atividades_equipe')->result_array();
		}

		function inserir($EquipeGrupoAtividade){
			$this->db->trans_start();
                        $this->db->set('grupo_atividade_id', $EquipeGrupoAtividade['txtGrupoAtividadeId']);
                        $this->db->set('pessoa_id', $EquipeGrupoAtividade['txtPessoaId']);
                        $this->db->set('responsavel', $EquipeGrupoAtividade['cmbResponsavel']);
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('grupos_atividades_equipe');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('grupos_atividades_equipe', $this->getEquipeGrupoAtividade($this->db->insert_id('grupos_atividades_equipe', 'id')));
			return true;
		}

		function alterar($EquipeGruposAtividades){

			$this->db->trans_start();
                        $this->db->set('grupo_atividade_id', $EquipeGruposAtividades['txtGrupoAtividadeId']);
                        $this->db->set('pessoa_id', $EquipeGruposAtividades['txtPessoaId']);
                        $this->db->set('responsavel', $EquipeGruposAtividades['cmbResponsavel']);
			$this->db->where('id', $EquipeGruposAtividades['txtGrupoPessoaId']);
			$this->db->update('grupos_atividades');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('grupos_atividades_equipe', $this->getEquipeGrupoAtividade($EquipeGruposAtividades['txtGrupoPessoaId']));
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
				$this->db->delete('grupos_atividades_equipe');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function getEquipeGrupoAtividade($equipeGrupoAtividadeId){
			$this->db->where('id', $equipeGrupoAtividadeId);
			return $this->db->get('grupos_atividades_equipe')->row();
		}
		
		function getEquipeGruposAtividades($parametros){
			$this->db->select('gae.id, p.nome,                        
                            case
                                when gae.responsavel = \'S\' then \'Sim\'
                                when gae.responsavel = \'N\' then \'Não\'
                            end as responsavel
                        , to_char(gae.dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
                        $this->db->from('grupos_atividades_equipe as gae');
                        $this->db->join('pessoas as p','gae.pessoa_id = p.id');
                        if(@$parametros['txtGrupoAtividadeId'] != null )
                                $this->db->where('gae.grupo_atividade_id', @$parametros['txtGrupoAtividadeId']);
			$this->db->sendToGrid();
		}

		function validaEquipeGrupoAtividade($local){
			$this->validate->setData($local);			
				
			$this->validate->validateField('txtLocalId', array('required'), lang('gruposDeAtividadesDescricaoDeveSerInformado'));
			return $this->validate->existsErrors();
		}
                
               public function getParticipanteByNome($nome) {
                    $this->db->select('p.id, p.nome');
                    $this->db->from('pessoas as p');
                    if($nome != '')
                        $this->db->like('upper(p.nome)', strtoupper($nome));
                    $this->db->where('p.pessoa_tipo_id is not null');
                    $this->db->order_by('p.nome', 'asc');
                    $this->db->limit('20');
                    return $this->db->get('')->result();
                }

	}