<?php

class Colaborar extends Controller{
    function __construct(){
        parent::__construct();

    }
    
    function index(){
        $this->load->view('colaborarFiltroView');
    }
    
}