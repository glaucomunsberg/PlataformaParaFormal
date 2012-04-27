<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Biblioteca responsável por manipular retornos Ajax
 * @package libraries
 * @subpackage ajax
 */
class Ajax {

    protected $_data = array();
    protected $_parametersJqGrid = '';

    /**
     * Adiciona uma mensagem à lista de retorno Ajax
     * @param string $key Identificador da mensagem, utilizado para seu acesso na view (data.$key.message)
     * @param string $value Mensagem
     */
    public function ajaxMessage($key, $value) {
        $this->_data[$key] = array(
            "message" => $value
        );
    }

    /**
     * Adiciona informações à lista de retorno retorno Ajax
     * @param string $key Chave da informação (nome, identificação). Utilizado para identificar os valores via Javascript na view
     * @param mixed $value Valor da informação
     */
    public function addAjaxData($key, $value) {
        $this->_data[$key] = $value;
    }

    /**
     * Adiciona um combo junto ao resultado Ajax. Utilizado em conjunto com o {@link form_textFieldAutoComplete}
     * @param result $data Os valores para popular o combo ( $this->db->get()->result() ).
     * Geralmente estes valores são o resultado de uma pesquisa de autocompletar, selecionando id e nome 
     */
    public function addAjaxCombo($data) {
        $returnJSON = array();

        if (count($data) > 0 && !empty($data)) {
            foreach ($data as $arrayObject) {
                $i = 0;
                foreach ($arrayObject as $key => $value) {
                    if ($i == 0) {
                        $optionValue = $value;
                        $i++;
                    } else {
                        $optionText = $value;
                        $i = 0;
                    }
                }
                $value = (string) $optionValue;
                $optionName = (string) $optionText;

                array_push($returnJSON, array(
                    'value' => $value,
                    'optionName' => $optionName
                ));
            }
        }

        $this->_data['combo'] = $returnJSON;
    }

    /**
     * Informa se existem dados para retornar
     * @return boolean
     */
    public function existsData() {
        if (count($this->_data) == 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Retorna os dados via ajax
     * @return json Os dados previamente adicionados, utilizando json_encode()
     */
    public function returnAjax() {
        echo json_encode($this->_data);
    }

    public function returnGrid($data) {
        echo $_GET['callback'] . '(' . json_encode($data) . ')';
    }

    /**
     * @deprecated Utilize $this->db->sendToGrid()
     * Retorna as informações necessárias para a grid via ajax
     * @param jqGridData $data As informações para popular a grid
     * @return json Os dados informados, utilizando json_encode()
     */
    public function returnJqGrid($data) {
        if (is_null($data) || is_bool($data)) {
            log_message('error', 'Undefined parameter in call of Ajax::returnJqGrid(). returnJqGrid MUST NOT RECEIVE NULL OR BOOLEAN DATA');
            logVar($data);
        } else {
            echo json_encode($data);
        }
    }

    /**
     * Método auxiliar para quando precisamos deixar uma grid vazia
     * @param array $params Os parâmetros recebidos pela requisição, via $_GET
     */
    public function returnEmptyJqGrid($params) {
        $this->returnJqGrid(
                $this->setStartLimitJqGrid($params, 0)
        );
    }

    /**
     * @deprecated Utilize $this->db->sendToGrid()
     * Analisa os parâmetros recebidos do jqGrid e os manipula conforma necessário para fornecer informações sobre paginação
     * @param array $parametersJqGrid Os parâmetros recebidos pela requisição, via $_GET
     * @param integer $count O total de itens, caso a grid utilize o recurso de paginação
     * @param boolean $noPagination TRUE para informar ausência de paginação
     * @return jqGridData Parâmetros da grid, com as informações de paginação, conforme os dados recebidos
     */
    public function setStartLimitJqGrid($parametersJqGrid, $count, $noPagination = false) {
        $page = $parametersJqGrid['page'];
        if ($noPagination)
            $parametersJqGrid['rows'] = $count;

        $limit = $parametersJqGrid['rows'];
        $sidx = $parametersJqGrid['sidx'];
        $sord = $parametersJqGrid['sord'];

        $totalrows = isset($parametersJqGrid['totalrows']) ? $parametersJqGrid['totalrows'] : false;
        if ($totalrows)
            $limit = $totalrows;

        if ($count > 0)
            $total_pages = ceil($count / $limit);
        else
            $total_pages = 0;

        if ($page > $total_pages)
            $page = $total_pages;

        $start = $limit * $page - $limit;
        if ($start < 0)
            $start = 0;

        $this->_parametersJqGrid->page = $page;
        $this->_parametersJqGrid->total = $total_pages;
        $this->_parametersJqGrid->records = $count;
        $this->_parametersJqGrid->sortField = $sidx;
        $this->_parametersJqGrid->sortDirection = $sord;
        $this->_parametersJqGrid->start = $start;
        $this->_parametersJqGrid->limit = $limit;
        return $this->_parametersJqGrid;
    }

    /**
     * Retorna os parâmetros de configurações do jqGrid
     * @return jqGridData Parâmetros de configuração para a grid
     */
    public function getParametersJqGrid() {
        return $this->_parametersJqGrid;
    }

    /**
     * Seta os parâmetros de configurações do jqGrid
     * @return jqGridData Parâmetros de configuração para a grid
     */
    function setParametersJqGrid($parametersJqGrid) {
        $this->_parametersJqGrid->page = $parametersJqGrid['page'];
        $this->_parametersJqGrid->sortField = $parametersJqGrid['sidx'];
        $this->_parametersJqGrid->sortDirection = $parametersJqGrid['sord'];
        $this->_parametersJqGrid->limit = $parametersJqGrid['rows'];
        return $this->_parametersJqGrid;
    }

}