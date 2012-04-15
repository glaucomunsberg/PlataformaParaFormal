<?php

class GrupoAcessoModel extends Model {
	
	function __construct(){
		parent::__construct();
		$this->load->model('../../gerenciador/models/ProgramaModel', 'programaModel');
		$this->load->model('../../gerenciador/models/PermissaoModel', 'permissaoModel');
	}
	
	function incluir($grupoAcesso){
		$retErro = $this->validaGrupoAcesso($grupoAcesso);
		if($retErro)
			return false;
		
		$this->db->trans_start();
			$this->db->set('nome', $grupoAcesso['txtNome']);
			$this->db->insert('grupos_acessos');
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->validate->addError('txtNome', lang('registroNaoGravado'));
			return false;
		}
		
		$this->ajax->addAjaxData('grupoAcesso', $this->getGrupoAcesso($this->db->insert_id()));
		return true;
	}

	function alterar($grupoAcesso){
		$retErro = $this->validaGrupoAcesso($grupoAcesso);
		if($retErro)
			return false;

		$this->db->trans_start();
			$this->db->set('nome', $grupoAcesso['txtNome']);
			$this->db->where('id', $grupoAcesso['txtGrupoAcessoId']);
			$this->db->update('grupos_acessos');
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->validate->addError('txtNome', lang('registroNaoGravado'));
			return false;
		}
		
		$this->ajax->addAjaxData('grupoAcesso', $this->getGrupoAcesso($grupoAcesso['txtGrupoAcessoId']));
		return true;
	}

	function getGrupoAcesso($id){
		$this->db->where('id', $id);
		return $this->db->get('grupos_acessos')->row();
	}

	function getGruposAcessos($parametros, $pagination=true){
		$this->db->select('count(*) as total_grupos_acesso', false);
		$this->db->like('upper(nome)', @$parametros['txtNome']);
		$total = $this->db->get('grupos_acessos')->row();

		$paramsJqGrid = $this->ajax->setStartLimitJqGrid($parametros, $total->total_grupos_acesso);

		$this->db->select('id, nome, date_format(dt_cadastro, \'%d/%m/%Y %H:%i:%s\') as dt_cadastro', false);
		$this->db->like('upper(nome)', @$parametros['txtNome']);
		$this->db->order_by($paramsJqGrid->sortField, $paramsJqGrid->sortDirection);
		if($pagination)
			$this->db->limit($paramsJqGrid->limit, $paramsJqGrid->start);

		$result = $this->db->get('grupos_acessos');

		$paramsJqGrid->rows = $result->result();
		return $paramsJqGrid;
	}	
	
	function getEmpresasGrupoAcesso($parametros){
		$this->db->select('concat_ws(\'chr\', gae.grupo_acesso_id, gae.empresa_id) as id, e.nome', false);
		$this->db->from('grupos_acessos_empresas as gae');
		$this->db->join('empresas as e', 'gae.empresa_id = e.id');
		$this->db->where('gae.grupo_acesso_id', $parametros['grupo_acesso_id']);
		$this->db->order_by('e.nome', 'asc');
		$result = $this->db->get();
		
		$paramsJqGrid = $this->ajax->setStartLimitJqGrid($parametros, $result->num_rows());
		$paramsJqGrid->rows = $result->result();
		return $paramsJqGrid;
	}
	
	function salvarGrupoAcessoEmpresa($empresa){
		$retErro = $this->validaGrupoAcessoEmpresa($empresa);
		if($retErro)
			return false;

		$this->db->trans_start();
			$this->db->where('grupo_acesso_id', $empresa['txtGrupoAcessoIdEmpresa']);
			$this->db->where('empresa_id', $empresa['cmbSetor']);
			$this->db->delete('grupos_acessos_empresas');
			
			$this->db->set('grupo_acesso_id', $empresa['txtGrupoAcessoIdEmpresa']);
			$this->db->set('empresa_id', $empresa['cmbSetor']);
			$this->db->insert('grupos_acessos_empresas');
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->validate->addError('cmbSetor', lang('registroNaoGravado'));
			return false;
		}

		$this->db->trans_commit();
		return true;
	}
	
	function excluirGrupoAcessoEmpresa($grupoAcessoId, $empresaId){
		$this->db->where('empresa_id', $empresaId);
		$perfis = $this->db->get('empresas_perfis')->result();
		
		$this->db->trans_begin();

			foreach($perfis as $perfil){
				$this->db->where('grupo_acesso_id', $grupoAcessoId);
				$this->db->where('perfil_id', $perfil->perfil_id);
				$this->db->where('empresa_id', $empresaId);
				$this->db->delete('grupos_acessos_perfis');
			}
			
			$this->db->where('grupo_acesso_id', $grupoAcessoId);
			$this->db->where('empresa_id', $empresaId);
			$this->db->delete('grupos_acessos_empresas');
			
			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}
		
		$this->db->trans_commit();
		return true;
	}

	function getPerfisGrupoAcesso($grupoAcessoId, $empresaId){
		$this->db->select('p.id, p.nome_perfil');
		$this->db->from('grupos_acessos_perfis as gap');
		$this->db->join('perfis as p', 'gap.perfil_id = p.id');
		$this->db->join('empresas_perfis as ep', 'gap.perfil_id = ep.perfil_id');
		$this->db->where('gap.grupo_acesso_id', $grupoAcessoId);
		$this->db->where('ep.empresa_id', $empresaId);
		$this->db->where('gap.empresa_id', $empresaId);
		$this->db->order_by('p.nome_perfil', 'asc');
		return $this->db->get()->result();
	}

	function salvarPerfis($perfis){
		$this->db->where('empresa_id', $perfis['empresaId']);
		$empresaPerfis = $this->db->get('empresas_perfis')->result();

		$this->db->trans_begin();
			foreach($empresaPerfis as $empresaPerfil){
				$this->db->where('grupo_acesso_id', $perfis['grupoAcessoId']);
				$this->db->where('perfil_id', $empresaPerfil->perfil_id);
				$this->db->where('empresa_id', $perfis['empresaId']);
				$this->db->delete('grupos_acessos_perfis');
			}
						
			if($perfis['perfisId'] != ''){
				$idPerfis = explode(',', $perfis['perfisId']);
				for($i = 0; $i < count($idPerfis); $i++){
					$this->db->set('grupo_acesso_id', $perfis['grupoAcessoId']);
					$this->db->set('perfil_id', $idPerfis[$i]);
					$this->db->set('empresa_id', $perfis['empresaId']);
					$this->db->insert('grupos_acessos_perfis');
				}
			}
			
			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}
		
		$this->db->trans_commit();
		return true;
	}
	
	function getEmpresasGrupoAcessoCombo($grupoAcessoId){
		$this->db->select('gae.empresa_id, e.nome');
		$this->db->from('grupos_acessos_empresas as gae');
		$this->db->join('empresas as e', 'gae.empresa_id = e.id');
		$this->db->where('gae.grupo_acesso_id', $grupoAcessoId);
		$this->db->orderby('e.nome', 'asc');
		return $this->db->get()->result();
	}
	
	function getPerfisByGrupoAcessoIdEmpresaId($grupoAcessoId, $empresaId){
		$this->db->select('p.id, p.nome_perfil', false);
		$this->db->from('grupos_acessos_perfis as up');
		$this->db->join('perfis as p', 'up.perfil_id = p.id');
		$this->db->join('empresas_perfis as ep', 'up.perfil_id = ep.perfil_id and up.empresa_id = ep.empresa_id');
		$this->db->where('up.grupo_acesso_id', $grupoAcessoId);
		$this->db->where('ep.empresa_id', $empresaId);
		return $this->db->get()->result();
	}
	
	function getProgramas($grupoAcessoId, $perfil, $programaPai=0, $empresaId){
		$this->db->select('p.id as perfil, p.nome_perfil, pp.programa_id, pp.programa_pai, pp.ordem, pr.nome_programa, pr.link', false);
		$this->db->from('grupos_acessos_perfis as up');
		$this->db->join('perfis as p', 'up.perfil_id = p.id');
		$this->db->join('empresas_perfis as ep', 'up.perfil_id = ep.perfil_id and up.empresa_id = ep.empresa_id');
		$this->db->join('perfis_programas as pp', 'pp.perfil_id = p.id');
		$this->db->join('programas as pr', 'pp.programa_id = pr.id');
		$this->db->where('up.grupo_acesso_id', $grupoAcessoId);
		$this->db->where('pp.programa_pai', $programaPai);
		$this->db->where('p.id', $perfil);
		$this->db->where('ep.empresa_id', $empresaId);
		$this->db->order_by('pp.ordem', 'asc');
		return $this->db->get()->result();
	}
	
	function verificaAcessoPrograma($grupo_acesso_id, $empresa_id, $perfil_id, $programa_id){
		$this->db->where('grupo_acesso_id', $grupo_acesso_id);
		$this->db->where('empresa_id', $empresa_id);
		$this->db->where('perfil_id', $perfil_id);
		$this->db->where('programa_id', $programa_id);
		$programa_acesso = $this->db->get('grupos_acessos_programas')->row();
		return (@$programa_acesso->id != '' ? true : false);
	}

	function getMenuPermissoesByGrupoAcessoId($grupoAcessoId){
		$menu = '';
		$empresas = $this->getEmpresasGrupoAcessoCombo($grupoAcessoId);
		foreach ($empresas as $empresa) {
			$menu.= '<li><span>'.$empresa->nome.'</span><ul style="background: none !important;">';
			$perfis = $this->getPerfisByGrupoAcessoIdEmpresaId($grupoAcessoId, $empresa->empresa_id);
			foreach ($perfis as $perfil){
				$menu.= '<li><span>'.$perfil->nome_perfil.'</span><ul style="background: none !important;">';
				$programasParent = $this->getProgramas($grupoAcessoId, $perfil->id, 0, $empresa->empresa_id);

				foreach ($programasParent as $programaParent) {
					$menu.= '<li><span><input type="checkbox" id="programa-'.$perfil->id.'-'.$programaParent->programa_id.'" name="programas_acessos[]" value="'.$empresa->empresa_id.'chr'.$perfil->id.'chr'.$programaParent->programa_id.'" style="margin: 0px 2px;" '.($this->verificaAcessoPrograma($grupoAcessoId, $empresa->empresa_id, $perfil->id, $programaParent->programa_id) ? 'checked' : '').' />'.$programaParent->nome_programa;

					$menu.= '</span><ul style="background: none !important;">';
					$programas = $this->getProgramas($grupoAcessoId, $perfil->id, $programaParent->programa_id, $empresa->empresa_id);
					foreach ($programas as $programa)
						$menu.= '<li><input type="checkbox" id="programa-'.$perfil->id.'-'.$programa->programa_id.'" name="programas_acessos[]" value="'.$empresa->empresa_id.'chr'.$perfil->id.'chr'.$programa->programa_id.'" style="margin: 0px 2px;" '.($this->verificaAcessoPrograma($grupoAcessoId, $empresa->empresa_id, $perfil->id, $programa->programa_id) ? 'checked' : '').' /><span id="p-'.$programa->programa_id.'-'.$programa->perfil.'-'.$grupoAcessoId.'" style="margin: 0px; display: block; float: left;">'.$programa->nome_programa.'</span><button id="'.$programa->programa_id.'-'.$programa->perfil.'-'.$grupoAcessoId.'" style="margin: -2px 2px; padding: 0px; height: 20px; font-size: 9px;" class="permissoes"/>permissões</button></li>';

					$menu.= '</ul></li>';
				}
				$menu.= '</ul></li>';
			}
			$menu.= '</ul></li>';
		}
		return $menu;
	}

	function salvarGrupoAcessoPrograma($grupoAcessoPrograma){
		$retErro = $this->validaSalvarGrupoAcessoPrograma($grupoAcessoPrograma);
		if($retErro)
			return false;

		$this->db->trans_begin();
			$a_programa_acessos = @$grupoAcessoPrograma['programas_acessos'];

			$this->db->where('grupo_acesso_id', $grupoAcessoPrograma['txtGrupoAcessoIdPrograma']);
			$this->db->delete('grupos_acessos_programas');

			for($i = 0; $i < count($a_programa_acessos); $i++){
				$a_programa_empresa = explode('chr', $a_programa_acessos[$i]);

				$this->db->set('grupo_acesso_id', $grupoAcessoPrograma['txtGrupoAcessoIdPrograma']);
				$this->db->set('empresa_id', $a_programa_empresa[0]);
				$this->db->set('perfil_id', $a_programa_empresa[1]);
				$this->db->set('programa_id', $a_programa_empresa[2]);
				$this->db->insert('grupos_acessos_programas');
			}

			$sql = 'delete
					  from grupos_acessos_programas_permissoes
					 where id in (select gapp.id
							  from grupos_acessos_programas_permissoes as gapp
							  join sys_metodos as sm
							    on gapp.sys_metodo_id = sm.id
							 where gapp.grupo_acesso_id = '.$grupoAcessoPrograma['txtGrupoAcessoIdPrograma'].'
							   and sm.classe not in (select p.link
									       from grupos_acessos_programas as gap
									       join programas as p
										 on gap.programa_id = p.id
									      where gap.grupo_acesso_id = '.$grupoAcessoPrograma['txtGrupoAcessoIdPrograma'].'))';
			$this->db->query($sql);

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}

		$this->db->trans_commit();
		return true;
	}

	function getPermissoesGrupoAcesso($grupoAcessoId, $programaId){
		$programa = $this->programaModel->getPrograma($programaId);
		$metodosPrograma = $this->permissaoModel->getMetodos($programa->link);

		$aMetodosPrograma = array();
		foreach ($metodosPrograma as $metodoPrograma)
			array_push($aMetodosPrograma, $metodoPrograma->id);

		if(count($aMetodosPrograma) > 0){
			$this->db->where_in('sys_metodo_id', $aMetodosPrograma);
			$this->db->where('grupo_acesso_id', $grupoAcessoId);
			return $this->db->get('grupos_acessos_programas_permissoes')->result();
		}else{
			return null;
		}
	}
	
	function salvarPermissoes($permissoes){
		$this->db->trans_start();
			$programa = $this->programaModel->getPrograma($permissoes['programaId']);
			$metodosPrograma = $this->permissaoModel->getMetodos($programa->link);
			$aMetodosPrograma = array();

			foreach ($metodosPrograma as $metodoPrograma)
				array_push($aMetodosPrograma, $metodoPrograma->id);

			if(count($aMetodosPrograma) > 0){
				$this->db->where_in('sys_metodo_id', $aMetodosPrograma);
				$this->db->where('grupo_acesso_id', $permissoes['grupoAcessoId']);
				$this->db->delete('grupos_acessos_programas_permissoes');
			}
			
			if($permissoes['metodos'] != ''){
				$metodos = explode(',', $permissoes['metodos']);
				$ExcluirCursos = array();
				for($i = 0; $i < count($metodos); $i++)
					if($metodos[$i] != 'undefined'){
						$this->db->set('sys_metodo_id', $metodos[$i]);
						$this->db->set('grupo_acesso_id', $permissoes['grupoAcessoId']);
						$this->db->insert('grupos_acessos_programas_permissoes');
					}
			}

		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE)
			return false;

		return true;
	}

	function validaSalvarGrupoAcessoPrograma($grupos_acessos_programas){
		$this->validate->setData($grupos_acessos_programas);
		$this->validate->validateField('txtGrupoAcessoIdPrograma', array('required'), 'Grupo deve ser informado');
		return $this->validate->existsErrors();
	}

	function validaGrupoAcessoEmpresa($grupoAcessoEmpresa){
		$this->validate->setData($grupoAcessoEmpresa);
		$this->validate->validateField('cmbSetor', array('required'), 'Setor deve ser informado');
		return $this->validate->existsErrors();
	}

	function validaGrupoAcesso($grupoAcesso){
		$this->validate->setData($grupoAcesso);
		$this->validate->validateField('txtNome', array('required'), 'Nome deve ser informado');
		return $this->validate->existsErrors();
	}

}