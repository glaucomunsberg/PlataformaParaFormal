<?php

class ProgramaModel extends Model {

    function inserir($programa) {
        $retErro = $this->validaPrograma($programa);
        if ($retErro) {
            return false;
        }
        $this->db->set('nome_programa', $programa['txtNome']);
        $this->db->set('descricao', $programa['txtDescricao']);
        $this->db->set('link', $programa['txtLink']);
        $this->db->set('onclick', $programa['txtOnClick']);
        $this->db->set('dt_cadastro', 'NOW()', false);
        $this->db->insert('programas');

        $this->ajax->addAjaxData('programa', $this->getPrograma($this->db->insert_id()));
        return true;
    }

    function alterar($programa) {
        $retErro = $this->validaPrograma($programa);
        if ($retErro) {
            return false;
        }
        $this->db->set('nome_programa', $programa['txtNome']);
        $this->db->set('descricao', $programa['txtDescricao']);
        $this->db->set('link', $programa['txtLink']);
        $this->db->set('onclick', $programa['txtOnClick']);
        $this->db->where('id', $programa['txtCodigo']);
        $this->db->update('programas');

        $this->ajax->addAjaxData('programa', $this->getPrograma($programa['txtCodigo']));
        return true;
    }

    function excluir($id) {
        $this->db->trans_begin();

        $aProgramas = explode(',', $id);
        $aExcluirProgramas = array();
        for ($i = 0; $i < count($aProgramas); $i++) {
            if ($aProgramas[$i] != 'undefined') {
                array_push($aExcluirProgramas, $aProgramas[$i]);
            }
        }
        $this->db->where_in('id', $aExcluirProgramas);
        $this->db->delete('programas');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();
        return true;
    }

    function excluirProgramaParametros($id) {
        $this->db->trans_begin();

        $aProgramasParametros = explode(',', $id);
        $aExcluirProgramasParametros = array();
        for ($i = 0; $i < count($aProgramasParametros); $i++)
            if ($aProgramasParametros[$i] != 'undefined')
                array_push($aExcluirProgramasParametros, $aProgramasParametros[$i]);

        $this->db->where_in('id', $aExcluirProgramasParametros);
        $this->db->delete('programas_parametros');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();
        return true;
    }

    function getProgramas($parametros) {
        $this->db->select('count(*) as quantidade');
        $this->db->like('upper(nome_programa)', strtoupper(@$parametros['nome']));
        $total = $this->db->get('programas')->row();

        $paramsJqGrid = $this->ajax->setStartLimitJqGrid($parametros, $total->quantidade);

        $this->db->select('id, nome_programa as nome, link, dt_cadastro', false);
        $this->db->like('upper(nome_programa)', strtoupper(@$parametros['nome']));
        $this->db->order_by($paramsJqGrid->sortField, $paramsJqGrid->sortDirection);
        $result = $this->db->get('programas', $paramsJqGrid->limit, $paramsJqGrid->start);

        $paramsJqGrid->rows = $result->result();
        return $paramsJqGrid;
    }

    function getParametrosProgramas($parametros) {
        $paramsJqGrid = $this->ajax->setParametersJqGrid($parametros);
        $this->db->where('programa_id', $parametros['programaId']);
        $this->db->order_by($paramsJqGrid->sortField, $paramsJqGrid->sortDirection);
        $result = $this->db->get('programas_parametros');

        $paramsJqGrid = $this->ajax->setStartLimitJqGrid($parametros, $result->num_rows());
        $paramsJqGrid->rows = $result->result();
        return $paramsJqGrid;
    }

    function getProgramasRelatorio() {
        $this->db->select('id, nome_programa as nome, link, dt_cadastro', false);
        $this->db->orderby('nome_programa', 'asc');
        return $this->db->get('programas')->result();
    }

    function getProgramasCombo() {
        $this->db->select('id, nome_programa||\' (\'||link||\')\' as nome', false);
        $this->db->orderby('nome_programa', 'asc');
        return $this->db->get('programas')->result_array();
    }

    function getPrograma($id) {
        $this->db->select('id, nome_programa as nome, link, descricao, dt_cadastro, onclick', false);
        $this->db->where('id', $id);
        return $this->db->get('programas')->row();
    }

    function pathBread($uri) {
        $path = array_reverse(explode('/', $_SERVER['DOCUMENT_ROOT']));
        $startIndex = explode("/", BASE_URL);
        array_pop($startIndex);
        $startIndex = ($path[1] != end($startIndex) ? 2 : 1);

        $url = explode('/', $uri);
        $idPrograma = '';
        $nr_parameters = 0;
        while ($idPrograma == '') {
            $link = '';
            for ($i = $startIndex; $i < count($url) - $nr_parameters; $i++) {
                if ($link == '') {
                    $link = $url[$i];
                } else {
                    $link.= '/' . $url[$i];
                }
            }
            $this->db->where('link', $link);
            $programa = $this->db->get('programas')->row();
            $idPrograma = @$programa->id;
            $nr_parameters++;
        }

        $this->db->select("case when perfis.nome_perfil is null then '' else perfis.nome_perfil||' / ' end" .
                            "||case when pai.nome_programa is null then '' else pai.nome_programa||' / ' end" .
                            "||app.nome_programa as path_bread", false)
                    ->from('perfis_programas as perfil_app')
                    ->join('programas as app', 'app.id = perfil_app.programa_id')
                    ->join('programas as pai', 'pai.id = perfil_app.programa_pai', 'left')
                    ->join('perfis', 'perfil_app.perfil_id = perfis.id', 'left')
                    ->where('perfil_app.programa_id', $idPrograma);
            return @$this->db->get()->row()->path_bread;
    }

    function validaPrograma($data) {
        $this->validate->setData($data);
        $this->validate->validateField('txtNome', array('required'), lang('programaNomeRequerido'));
        return $this->validate->existsErrors();
    }

    function salvarProgramaParametro($programaParametro) {
        $retErro = $this->validaProgramaParametro($programaParametro);
        if ($retErro) {
            return false;
        }
        $this->db->set('programa_id', $programaParametro['txtIdPrograma']);
        $this->db->set('nome', $programaParametro['txtParametro']);
        if ($programaParametro['txtProgramaParametroId'] != '') {
            $this->db->where('id', $programaParametro['txtProgramaParametroId']);
            $this->db->update('programas_parametros');
        } else {
            $this->db->insert('programas_parametros');
        }
        $programa_parametro_id = ($programaParametro['txtProgramaParametroId'] != '' ? $programaParametro['txtProgramaParametroId'] : $this->db->insert_id());

        $this->ajax->addAjaxData('programa_parametro', $this->getProgramaParametro($programa_parametro_id));
        return true;
    }

    function getProgramaParametro($id) {
        $this->db->where('id', $id);
        return $this->db->get('programas_parametros')->row();
    }

    function validaProgramaParametro($programaParametro) {
        $this->validate->setData($programaParametro);
        $this->validate->validateField('txtIdPrograma', array('required'), 'Programa deve ser informado');
        $this->validate->validateField('txtParametro', array('required'), 'Parâmetro deve ser informado');
        return $this->validate->existsErrors();
    }

}