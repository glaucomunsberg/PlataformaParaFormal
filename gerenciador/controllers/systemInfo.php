<?php

class SystemInfo extends Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('PessoaModel', 'pessoaModel');
        $this->load->model('ProgramaModel', 'programaModel');
        $this->load->model('SystemInfoModel', 'systemInfoModel');
    }

    function index() {
        $data['path_bread'] = $this->programaModel->pathBread($_SERVER['REQUEST_URI']);
        $data['db_version'] = $this->systemInfoModel->getDBVersion();
        $data['db_corrent'] = $this->systemInfoModel->getDBCorrent();
        $data['db_host'] = $this->systemInfoModel->getDBHost();
        $this->load->view('systemInfoFiltroView', $data);
    }
}
