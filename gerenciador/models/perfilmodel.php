<?php

	class PerfilModel extends Model{
		
		function __construct(){
			parent::__construct();			
		}
		
		function incluirPerfil($perfil){
			$retErro = $this->validaPerfil($perfil);
			if($retErro)
				return false;
			
			$this->db->set('nome_perfil', $perfil['txtNome']);
			$this->db->set('dt_cadastro', 'NOW()', false);
			$this->db->insert('perfis');
			
			$this->ajax->addAjaxData('perfil', $this->getPerfil($this->db->insert_id()));
			return true;
		}
		
		function alterarPerfil($perfil){
			$retErro = $this->validaPerfil($perfil);
			if($retErro)
				return false;			
			
			$this->db->set('nome_perfil', $perfil['txtNome']);
			$this->db->where('id', $perfil['txtCodigo']);
			$this->db->update('perfis');
			
			$this->ajax->addAjaxData('perfil', $this->getPerfil($perfil['txtCodigo']));
			return true;
		}

		function excluirPerfil($perfis){
			$this->db->trans_begin();

				$aPerfis = explode(',', $perfis);
				$aExcluirPerfis = array();
				for($i = 0; $i < count($aPerfis); $i++)
					if($aPerfis[$i] != 'undefined')
						array_push($aExcluirPerfis, $aPerfis[$i]);

				$this->db->where_in('perfil_id', $aExcluirPerfis);
				$this->db->delete('perfis_programas');

				$this->db->where_in('id', $aExcluirPerfis);
				$this->db->delete('perfis');

				if($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					return false;
				}

			$this->db->trans_commit();
			return true;
		}

		function incluirProgramaPai($programa, $programaPai = 0){
			$retErro = $this->validaPerfilProgramaPai($programa);
			if($retErro)
				return false;

			$this->db->set('perfil_id', $programa['txtIdPerfilPai']);
			$this->db->set('programa_id', $programa['cmbProgramaPai']);
			$this->db->set('ordem', $this->maxOrdem($programa['txtIdPerfilPai'], $programaPai));
			$this->db->set('programa_pai', $programaPai);
			$this->db->set('flg_ativo', 'S');
			$this->db->insert('perfis_programas');
			
			$this->ajax->addAjaxData('programaPai', $this->getPerfilPrograma($this->db->insert_id()));
			return true;
		}
		
		function alterarProgramaPai($programa){
			$retErro = $this->validaPerfilProgramaPai($programa);
			if($retErro)
				return false;

			$this->db->set('perfil_id', $programa['txtIdPerfilPai']);
			$this->db->set('programa_id', $programa['cmbProgramaPai']);
			$this->db->where('id', $programa['txtIdProgramaPerfilPai']);
			$this->db->update('perfis_programas');

			$this->ajax->addAjaxData('programaPai', $this->getPerfilPrograma($programa['txtIdProgramaPerfilPai']));
			return true;
		}

		function excluirProgramaPai($idPerfilPrograma, $programaId, $idPerfil){
			$this->db->trans_begin();
				$this->db->where('programa_pai', $programaId);
				$this->db->where('perfil_id', $idPerfil);
				$this->db->delete('perfis_programas');
				
				$this->db->where('id', $idPerfilPrograma);				
				if(!$this->db->delete('perfis_programas')){
					$this->db->trans_rollback();
					return false;
				}					
				
				if($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					return false;
				}
			$this->db->trans_commit();
			return true;
		}
		
		function incluirPrograma($programa, $idPerfil, $programaPai){
			$retErro = $this->validaPerfilPrograma($programa);
			if($retErro)
				return false;

			$this->db->set('perfil_id', $idPerfil);
			$this->db->set('programa_id', $programa['cmbPrograma']);
			$this->db->set('ordem', $this->maxOrdem($idPerfil, $programaPai));
			$this->db->set('programa_pai', $programaPai);
			$this->db->set('flg_ativo', 'S');
			$this->db->insert('perfis_programas');
			
			$this->ajax->addAjaxData('programa', $this->getPerfilPrograma($this->db->insert_id()));
			return true;
		}
		
		function excluirPrograma($idPerfilPrograma, $programaId){
			$this->db->trans_begin();
				$sql = 'delete from usuarios_programas_acessos
						 where programa_id = '.$programaId.'
						   and perfil_id in (select perfil_id from perfis_programas where id = '.$idPerfilPrograma.')';
				$this->db->query($sql);

				$this->db->where('id', $idPerfilPrograma);
				$this->db->delete('perfis_programas');

				if($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					return false;
				}

			$this->db->trans_commit();
			return true;
		}

		function getPerfil($id){
			$this->db->select('id, nome_perfil, date_format(dt_cadastro, \'%d/%m/%Y\') as dt_cadastro', false);
			$this->db->where('id', $id);
			return $this->db->get('perfis')->row();
		}

		function getPerfis($parametros){			
			$this->db->select('count(*) as quantidade');			
			$total = $this->db->get('perfis')->row();
			
			$paramsJqGrid = $this->ajax->setStartLimitJqGrid($parametros, $total->quantidade);
			
			$this->db->select('id, nome_perfil, case when flg_ativo = \'S\' then \'Sim\' else \'Não\' end as flg_ativo, date_format(dt_cadastro, \'%d/%m/%Y\') as dt_cadastro', false);
			$this->db->order_by($paramsJqGrid->sortField, $paramsJqGrid->sortDirection);
			$result = $this->db->get('perfis', $paramsJqGrid->limit, $paramsJqGrid->start);

			$paramsJqGrid->rows = $result->result();
			return $paramsJqGrid;			
		}
		
		function getPerfisByUsuarioIdEmpresaId($usuarioId, $empresaId){
			$this->db->select('p.id, p.nome_perfil', false);
			$this->db->from('usuarios_perfis as up');
			$this->db->join('perfis as p', 'up.perfil_id = p.id');
			$this->db->join('empresas_perfis as ep', 'up.perfil_id = ep.perfil_id and up.empresa_id = ep.empresa_id');
  			$this->db->where('up.usuario_id', $usuarioId);
  			$this->db->where('ep.empresa_id', $empresaId);
  			return $this->db->get()->result();  			  		
		}
		
		function getPerfisGrupoAcessoByUsuarioIdEmpresaId($usuarioId, $empresaId){
			$sql = 'select p.id, p.nome_perfil
					  from usuarios_perfis as up
					  join perfis as p
						on up.perfil_id = p.id
					  join empresas_perfis as ep
						on up.perfil_id = ep.perfil_id
							and up.empresa_id = ep.empresa_id
					 where up.usuario_id = '.$usuarioId.'
					   and ep.empresa_id = '.$empresaId.'
					 union
					select p.id, p.nome_perfil
					  from usuarios as u
					  join usuarios_grupos_acessos as uga
						on u.id = uga.usuario_id
					  join grupos_acessos_empresas as gae
						on uga.grupo_acesso_id = gae.grupo_acesso_id
					  join grupos_acessos_perfis as gap
						on uga.grupo_acesso_id = gap.grupo_acesso_id
							and gae.empresa_id = gap.empresa_id
					  join perfis as p
						on p.id = gap.perfil_id
					 where u.id = '.$usuarioId.'
					   and gap.empresa_id = '.$empresaId.'
					 order by nome_perfil asc';
			return $this->db->query($sql)->result();
		}
		
		function getPerfisCombo(){
			$this->db->select('id, nome_perfil');
			$this->db->order_by('nome_perfil', 'asc');
			return $this->db->get('perfis')->result_array();
		}
		
		function getPerfilPrograma($id){
			$this->db->where('id', $id);
			return $this->db->get('perfis_programas')->row();
		}
		
		function getPerfilProgramas($parametros, $idProgramaPai){
			$paramsJqGrid = $this->ajax->setParametersJqGrid($parametros);
			
			$this->db->select('concat_ws(\'chr\', perfis_programas.id, programas.id) as id, nome_programa as nome', false);
			$this->db->from('perfis_programas');
			$this->db->join('programas', 'programas.id = perfis_programas.programa_id');
			$this->db->where('perfil_id', $parametros['idPerfil']);
			$this->db->where('programa_pai', $idProgramaPai);
			$this->db->orderby('ordem', 'asc');
			$result =  $this->db->get();

			$paramsJqGrid = $this->ajax->setStartLimitJqGrid($parametros, $result->num_rows());
			$paramsJqGrid->rows = $result->result();
			return $paramsJqGrid;
		}
		
		function alterarProgramas($idPerfil, $idPai, $ids, $idsProgramas){
			$this->db->trans_begin();
			
				$idPerfilPrograma = explode(",", $ids);
				$idPrograma = explode(",", $idsProgramas);
				
				for($i = 0; $i <= count($idPerfilPrograma) - 1; $i++){
					$dados = array('perfil_id' => $idPerfil,
								   'programa_id' => trim($idPrograma[$i]),
								   'ordem' => $i,
								   'programa_pai' => $idPai);
					$this->db->where('id', trim($idPerfilPrograma[$i]));
					$this->db->update('perfis_programas', $dados);
					
					if($this->db->trans_status() === FALSE){
						$this->db->trans_rollback();
						return false;
					}
				}
				
			$this->db->trans_commit();
			return true;
		}
		
		function maxOrdem($idPerfil, $idProgramaPai){
			$this->db->select('max(ordem) as max_ordem');
			$this->db->where('perfil_id', $idPerfil);
			$this->db->where('programa_pai', $idProgramaPai);
			$return = $this->db->get('perfis_programas')->row();
			return $return->max_ordem + 1;
		}
		
		function validaPerfil($data){
			$this->validate->setData($data);
			$this->validate->validateField('txtNome', array('required'), lang('perfilNomeRequerido'));
			return $this->validate->existsErrors();
		}
		
		function validaPerfilProgramaPai($data){
			$this->validate->setData($data);			
			$this->validate->validateField('txtIdPerfilPai', array('required'), 'Perfil deve ser informado');
			$this->validate->validateField('cmbProgramaPai', array('required'), lang('perfilProgramaRequerido'));			
			return $this->validate->existsErrors();
		}

		function validaPerfilPrograma($data){
			$this->validate->setData($data);
			$this->validate->validateField('txtIdProgramaPai', array('required'), 'Programa pai deve ser informado');
			$this->validate->validateField('cmbPrograma', array('required'), lang('perfilProgramaRequerido'));
			return $this->validate->existsErrors();
		}

	}