<?php
/**
 * @package academico
 * @subpackage cadastrosauxiliares
 */
	class ParaformalidadeModel extends Model {

		function __construct(){
			parent::__construct();
		}

		function getParaformalidadeCombo() {
			$this->db->select('id, descricao', false);
			$this->db->orderby('id', 'asc');
			return $this->db->get('paraformalidades')->result_array();
		}

		function inserir($paraformalidade){
			$this->db->trans_start();
			$this->db->set('descricao', $paraformalidade['txtDescricao']);
                        $this->db->set('imagem_id', $paraformalidade['arquivoImportacaoId']);
                        $this->db->set('colaborador_pessoa_id', $paraformalidade['txtColaboradorId']);
                        $this->db->set('grupo_atividade_id', $paraformalidade['txtGrupoAtividadeId']);
                        $this->db->set('tipo_registro_atividade_id', $paraformalidade['cmbTipoRegistroAtividade']);
                        $this->db->set('tipo_local_id', $paraformalidade['cmbTipoLocal']);
                        $this->db->set('tipo_condicao_ambiental_id', $paraformalidade['cmbTipoCondicaoAmbiental']);
                        $this->db->set('tipo_elemento_situacao_id', $paraformalidade['cmbTipoElementoSituacao']);
                        if($paraformalidade['cmbTipoPonte'] != '') 
                            $this->db->set('tipo_ponte_id', $paraformalidade['cmbTipoPonte']);
                        $this->db->set('esta_ativo', 'S');
                        $this->db->set('geocode_lat', $paraformalidade['txtLatParaformalidade']);
                        $this->db->set('geocode_lng', $paraformalidade['txtLngParaformalidade']);
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('paraformalidades');
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('paraformalidade', $this->getParaformalidade($this->db->insert_id('paraformalidades', 'id')));
			return true;
		}

		function alterar($paraformalidade){

			$this->db->trans_start();
                        if($paraformalidade['txtDescricao'] != '')
                            $this->db->set('descricao', $paraformalidade['txtDescricao']);
                        if($paraformalidade['arquivoImportacaoId'] != '') 
                            $this->db->set('imagem_id', $paraformalidade['arquivoImportacaoId']);
                        $this->db->set('colaborador_pessoa_id', $paraformalidade['txtColaboradorId']);
                        $this->db->set('grupo_atividade_id', $paraformalidade['txtGrupoAtividadeId']);
                        $this->db->set('tipo_registro_atividade_id', $paraformalidade['cmbTipoRegistroAtividade']);
                        $this->db->set('tipo_local_id', $paraformalidade['cmbTipoLocal']);
                        $this->db->set('tipo_condicao_ambiental_id', $paraformalidade['cmbTipoCondicaoAmbiental']);
                        $this->db->set('tipo_elemento_situacao_id', $paraformalidade['cmbTipoElementoSituacao']);
                        if($paraformalidade['cmbTipoPonte'] != '') 
                            $this->db->set('tipo_ponte_id', $paraformalidade['cmbTipoPonte']);
                        $this->db->set('esta_ativo', 'S');
                        $this->db->set('geocode_lat', $paraformalidade['txtLatParaformalidade']);
                        logVar($paraformalidade['txtLatParaformalidade']);
                        $this->db->set('geocode_lng', $paraformalidade['txtLngParaformalidade']);
			$this->db->set('dt_cadastro', 'NOW()', false);
                        
			$this->db->where('id', $paraformalidade['txtParaformalidadeId']);
			$this->db->update('paraformalidades');
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->validate->addError('txtCodigo', lang('registroNaoGravado'));
				return false;
			}

			$this->ajax->addAjaxData('paraformalidade', $this->getParaformalidade($paraformalidade['txtParaformalidadeId']));
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
				$this->db->delete('paraformalidades');

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE)					
				return false;

			return true;
		}

		function getParaformalidade($paraformalidadeID){
			$this->db->where('id', $paraformalidadeID);
			return $this->db->get('paraformalidades')->row();
		}
                
		function getParaformalidadeWhitImage($paraformalidadeID){
                        $this->db->select('p.id, pe.nome, u.nome_gerado, p.descricao, p.imagem_id, p.grupo_atividade_id, p.colaborador_pessoa_id as colaborador_id, p.tipo_registro_atividade_id, p.tipo_local_id, p.tipo_condicao_ambiental_id, p.tipo_elemento_situacao_id, p.tipo_ponte_id, p.esta_ativo, p.dt_cadastro, p.geocode_lat, p.geocode_lng',false);
                        $this->db->from('paraformalidades as p');
                        $this->db->join('public.uploads as u','p.imagem_id = u.id');
                        $this->db->join('public.pessoas as pe','p.colaborador_pessoa_id = pe.id');
			$this->db->where('p.id', $paraformalidadeID);
			return $this->db->get()->row();
		}
                
		function getParaformalidades($parametros) {
                        $this->db->select('p.id, p.id as colaboradorNome, p.descricao, pes.nome, tr.descricao as tipo_registro_atividade, tl.descricao as tipo_local, tca.descricao as tipo_condicao_ambiental, tes.descricao as tipo_elemento_descricao, tp.descricao as tipo_ponte, up.nome_original, to_char(p.dt_cadastro, \'dd/mm/yyyy hh24:mi:ss\') as dt_cadastro', false);
                        $this->db->from('paraformalidades as p');
                        $this->db->join('public.grupos_atividades as ga','p.grupo_atividade_id = ga.id', 'left');
                        $this->db->join('public.pessoas as pes','p.colaborador_pessoa_id = pes.id', 'left');
                        $this->db->join('public.tipos_registros_atividades as tr','p.tipo_registro_atividade_id = tr.id', 'left');
                        $this->db->join('public.tipos_locais as tl','p.tipo_local_id = tl.id', 'left');
                        $this->db->join('public.tipos_condicoes_ambientais as tca','p.tipo_condicao_ambiental_id = tca.id', 'left');
                        $this->db->join('public.tipos_elementos_situacoes as tes','p.tipo_elemento_situacao_id = tes.id', 'left');
                        $this->db->join('public.tipos_pontes as tp','p.tipo_ponte_id = tp.id', 'left');
                        $this->db->join('public.uploads as up','p.imagem_id = up.id', 'left');
                        if(@$parametros['txtCobaloradorId'] != '' )
                            $this->db->like('p.id', @$parametros['txtCobaloradorId']);
                        $this->db->where('p.esta_ativo','S');
                        if(@$parametros['txtGrupoAtividadeId'] != '' )
                            $this->db->where('ga.id',@$parametros['txtGrupoAtividadeId']);
                        $this->db->sendToGrid();
                }

		function validaParaformalidade($local){
			$this->validate->setData($local);			
				
			$this->validate->validateField('txtLocalId', array('required'), lang('ParaformalidadeDescricaoDeveSerInformado'));
			return $this->validate->existsErrors();
		}

	}