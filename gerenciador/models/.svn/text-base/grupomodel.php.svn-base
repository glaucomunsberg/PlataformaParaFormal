<?php

class GrupoModel extends Model {

    function __construct() {
        parent::__construct();
        $this->load->library('Validate', 'validate');
    }

    function incluirGrupo($grupo) {
        $retErro = $this->validaGrupo($grupo);
        if ($retErro) {
            return false;
        }

        $dados = array('empresa_id' => $grupo['cmbEmpresa'],
            'nome_grupo' => $grupo['txtNome'],
            'dt_cadastro' => 'now()');
        $this->db->insert('grupos', $dados);

        $this->ajax->addAjaxData('grupo', $this->getGrupo($this->db->insert_id()));
        return true;
    }

    function alterarGrupo($grupo) {
        $retErro = $this->validaGrupo($grupo);
        if ($retErro) {
            return false;
        }

        $dados = array('empresa_id' => $grupo['cmbEmpresa'],
            'nome_grupo' => $grupo['txtNome']);
        $this->db->where('id', $grupo['txtCodigo']);
        $this->db->update('grupos', $dados);

        $this->ajax->addAjaxData('grupo', $this->getGrupo($grupo['txtCodigo']));
        return true;
    }

    function excluirGrupo($id) {
        $this->db->trans_begin();

        $this->db->where('grupo_id', $id);
        $this->db->delete('grupos_programas');

        $this->db->where('id', $id);
        $this->db->delete('grupos');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();
        return true;
    }

    function getGrupos($start, $limit, $idEmpresa = '', $nomeGrupo = '', $data = '') {
        $this->db->select('grupos.id as id, empresas.nome as empresa, grupos.nome_grupo as nome, grupos.dt_cadastro');
        $this->db->from('grupos');
        $this->db->join('empresas', 'empresas.id = grupos.empresa_id');
        if ($idEmpresa != '') {
            $this->db->where('grupos.empresa_id', $idEmpresa);
        }
        if ($data != '') {
            $this->db->where('grupos.dt_cadastro', $data);
        }
        $this->db->like('grupos.nome_grupo', $nomeGrupo);
        $this->db->orderby('grupos.nome_grupo', 'asc');
        $this->db->limit($limit, $start);
        $result = $this->db->get();
        $dados['total'] = $result->num_rows();
        $dados['results'] = $result->result();
        return $dados;
    }

    function getAllGrupos() {
        $this->db->select('id, nome_grupo');
        $this->db->orderby('nome_grupo', 'asc');
        $result = $this->db->get('grupos');
        $dados['total'] = $result->num_rows();
        $dados['results'] = $result->result();
        return $dados;
    }

    function getGrupo($id) {
        $this->db->select('id, empresa_id as ger_empresas_id, nome_grupo as nome, dt_cadastro');
        $this->db->where('id', $id);
        return $this->db->get('grupos')->row();
    }

    function getGrupoProgramas($idGrupo, $idPai) {
        $this->db->select('grupos_programas.id ||\'chr\'||programas.id as id, nome_programa as nome, dt_entrada, dt_saida', false);
        $this->db->from('grupos_programas');
        $this->db->join('programas', 'programas.id = grupos_programas.programa_id');
        $this->db->where('grupo_id', $idGrupo);
        $this->db->where('pai', $idPai);
        $this->db->orderby('ordem', 'asc');
        $result = $this->db->get();
        $dados['total'] = $result->num_rows();
        $dados['results'] = $result->result();
        return $dados;
    }

    function getProgramaGrupo($id) {
        $this->db->select('id, grupo_id as ger_grupos_id, programa_id as ger_programas_id, ordem, pai, dt_entrada, dt_saida');
        $this->db->where('id', $id);
        return $this->db->get('grupos_programas')->row();
    }

    function incluirProgramaPai($programa, $pai = 0) {
        $retErro = $this->validaGrupoProgramaPai($programa);
        if ($retErro) {
            return false;
        }
        $dados = array('grupo_id' => $programa['txtIdGrupoPai'],
            'programa_id' => $programa['cmbProgramaPai'],
            'ordem' => $this->maxOrdem($programa['txtIdGrupoPai'], $pai),
            'pai' => $pai,
            'flg_ativo' => 'S');
        if ($programa['dtEntradaPai'] != '') {
            $dados['dt_entrada'] = array("to_date('" . $programa['dtEntradaPai'] . "', '%d/%m/%Y')");
        } else {
            $dados['dt_entrada'] = null;
        }
        if ($programa['dtSaidaPai'] != '') {
            $dados['dt_saida'] = array("to_date('" . $programa['dtSaidaPai'] . "', '%d/%m/%Y')");
        } else {
            $dados['dt_saida'] = null;
        }
        $this->db->insert('grupos_programas', $dados);

        $this->ajax->addAjaxData('programaPai', $this->getProgramaGrupo($this->db->insert_id()));
        return true;
    }

    function alterarProgramaPai($programa) {
        $retErro = $this->validaGrupoProgramaPai($programa);
        if ($retErro) {
            return false;
        }
        $dados = array('grupo_id' => $programa['txtIdGrupoPai'],
            'programa_id' => $programa['cmbProgramaPai']);

        if ($programa['dtEntradaPai'] != '') {
            $dados['dt_entrada'] = array("to_date('" . $programa['dtEntradaPai'] . "', '%d/%m/%Y')");
        } else {
            $dados['dt_entrada'] = null;
        }
        if ($programa['dtSaidaPai'] != '') {
            $dados['dt_saida'] = array("to_date('" . $programa['dtSaidaPai'] . "', '%d/%m/%Y')");
        } else {
            $dados['dt_saida'] = null;
        }

        $this->db->where('id', $programa['txtIdProgramaGrupoPai']);
        $this->db->update('grupos_programas', $dados);

        $this->ajax->addAjaxData('programaPai', $this->getProgramaGrupo($programa['txtIdProgramaGrupoPai']));
        return true;
    }

    function incluirPrograma($programa, $idGrupo, $pai) {
        $retErro = $this->validaGrupoPrograma($programa);
        if ($retErro) {
            return false;
        }
        $dados = array('grupo_id' => $idGrupo,
            'programa_id' => $programa['cmbPrograma'],
            'ordem' => $this->maxOrdem($idGrupo, $pai),
            'pai' => $pai,
            'flg_ativo' => 'S');
        if ($programa['dtEntrada'] != '') {
            $dados['dt_entrada'] = array("to_date('" . $programa['dtEntrada'] . "', '%d/%m/%Y')");
        } else {
            $dados['dt_entrada'] = null;
        }
        if ($programa['dtSaida'] != '') {
            $dados['dt_saida'] = array("to_date('" . $programa['dtSaida'] . "', '%d/%m/%Y')");
        } else {
            $dados['dt_saida'] = null;
        }
        $this->db->insert('grupos_programas', $dados);

        $this->ajax->addAjaxData('programa', $this->getProgramaGrupo($this->db->insert_id()));
        return true;
    }

    function alterarPrograma($programa, $idGrupo) {
        $retErro = $this->validaGrupoPrograma($programa);
        if ($retErro) {
            return false;
        }
        $dados = array('grupo_id' => $idGrupo, 'programa_id' => $programa['cmbPrograma']);

        if ($programa['dtEntrada'] != '') {
            $dados['dt_entrada'] = array("to_date('" . $programa['dtEntrada'] . "', '%d/%m/%Y')");
        } else {
            $dados['dt_entrada'] = null;
        }
        if ($programa['dtSaida'] != '') {
            $dados['dt_saida'] = array("to_date('" . $programa['dtSaida'] . "', '%d/%m/%Y')");
        } else {
            $dados['dt_saida'] = null;
        }

        $this->db->where('id', $programa['txtIdProgramaGrupo']);
        $this->db->update('grupos_programas', $dados);

        $this->ajax->addAjaxData('programa', $this->getProgramaGrupo($programa['txtIdProgramaGrupo']));
        return true;
    }

    function alterarProgramas($idGrupo, $idPai, $ids, $idsProgramas) {
        $this->db->trans_begin();

        $idGrupoPrograma = explode(",", $ids);
        $idPrograma = explode(",", $idsProgramas);

        for ($i = 0; $i <= count($idGrupoPrograma) - 1; $i++) {
            $dados = array(
                'grupo_id' => $idGrupo,
                'programa_id' => trim($idPrograma[$i]),
                'ordem' => $i,
                'pai' => $idPai
            );
            $this->db->where('id', trim($idGrupoPrograma[$i]));
            $this->db->update('grupos_programas', $dados);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            }
        }

        $this->db->trans_commit();
        return true;
    }

    function excluirProgramaPai($idPrograma, $programaId, $idGrupo) {
        $this->db->trans_begin();

        $this->db->where('pai', $programaId);
        $this->db->where('grupo_id', $idGrupo);
        $this->db->delete('grupos_programas');

        $this->db->where('id', $idPrograma);
        $this->db->delete('grupos_programas');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }

    function excluirPrograma($idPrograma) {
        $this->db->trans_begin();
        $this->db->where('id', $idPrograma);
        $this->db->delete('grupos_programas');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }

    function maxOrdem($idGrupo, $idPai) {
        $this->db->select('max(ordem) as max_ordem');
        $this->db->where('grupo_id', $idGrupo);
        $this->db->where('pai', $idPai);
        $return = $this->db->get('grupos_programas')->row();
        return $return->max_ordem + 1;
    }

    function validaGrupoProgramaPai($data) {
        $this->validate->setData($data);
        $this->validate->validateField('cmbProgramaPai', array('required'), lang('grupo_programa_nao_informado'));
        return $this->validate->existsErrors();
    }

    function validaGrupoPrograma($data) {
        $this->validate->setData($data);
        $this->validate->validateField('cmbPrograma', array('required'), lang('grupo_programa_nao_informado'));
        return $this->validate->existsErrors();
    }

    function validaGrupo($data) {
        $this->validate->setData($data);
        $this->validate->validateField('cmbEmpresa', array('required'), lang('grupo_empresa_nao_informada'));
        $this->validate->validateField('txtNome', array('required'), lang('grupo_nome_nao_informado'));
        return $this->validate->existsErrors();
    }

}
