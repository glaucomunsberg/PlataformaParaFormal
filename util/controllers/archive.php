<?php

	class Archive extends Controller {
		
		function __construct(){
			parent::__construct();
			$this->load->model('UploadModel', 'uploadModel');
		}

		function getArchiveByUploadId($uploadId){
			$arquivo = $this->uploadModel->getUpload($uploadId);
			if(IS_AJAX){
				$this->ajax->addAjaxData('arquivo', $arquivo);
				$this->ajax->returnAjax();
			}else{
				$uploadContents = file_get_contents('../archives/'.$arquivo->nome_gerado);
				header('Pragma: public');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Cache-Control: public');
				header('Content-Description: File Transfer');
				header('Content-Type: '.$arquivo->tipo.'');
				header('Content-Disposition: attachment; filename= '.$arquivo->nome_original.'');
				header('Content-Transfer-Encoding: binary');
				echo $uploadContents;
			}
		}
		
		function getImageThumb48x48ByUploadId($uploadId){
			$arquivo = $this->uploadModel->getUpload($uploadId);
			$uploadContents = file_get_contents('../archives/thumbs_48x48/'.$arquivo->nome_gerado);

			header('Pragma: public');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Cache-Control: public');
			header('Content-Description: File Transfer');
			header('Content-Type: '.$arquivo->tipo.'');
			header('Content-Disposition: attachment; filename= '.$arquivo->nome_original.'');
			header('Content-Transfer-Encoding: binary');
			echo $uploadContents;
		}
		
	}