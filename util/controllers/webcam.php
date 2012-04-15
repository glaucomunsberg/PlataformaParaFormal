<?php

	class WebCam extends Controller {
		
		function __construct(){
			parent::__construct();
		}
		
		function index(){
			$this->load->view('webcam/webCamView');
		}
		
		function choiceImagem($objectId, $objectName, $methodReturn){
			$data['objectId'] = $objectId;
			$data['objectName'] = $objectName;
			$data['methodReturn'] = $methodReturn;
			$this->load->view('webcam/webCamView', $data);
		}

	}