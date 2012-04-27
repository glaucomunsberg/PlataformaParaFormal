<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * librarie responsavel por manipular diversos componentes form do sistema
 * @package libraries
 * @subpackage jasper
 */

class Jasperreportgenerate {
	
	public function pdf_create($nameReportJasper, $nameReport='', $params='', $format='PDF', $stream=true, $codeValidator=false){
		$path = array_reverse(explode('/', $_SERVER['DOCUMENT_ROOT']));
		$pathArchive = $_SERVER['DOCUMENT_ROOT'].($path[1] != 'cobalto' ? '/cobalto/' : '');
		
		$pathReport = array();
		$outputJasperReportGenerate = array();
		$code_validator_report = strtoupper(random_string('alnum', 2)).str_pad(date('zy'), 5, '0', STR_PAD_LEFT).strtoupper(random_string('alnum', 3));
		
		if($codeValidator)
			$params['CODE_VALIDATOR'] = 'Para validar este documento acesse o site da UFPEL item <b>Validador de documentos</b> e informe o código <b>'.$code_validator_report.'</b>';

		$formatReport = 0;
		switch ($format) {
			case 'PDF':
				$formatReport = 1;
				break;
			case 'HTML':
				$formatReport = 2;
				break;
			case 'XML':
				$formatReport = 3;
				break;
			case 'XLS':
				$formatReport = 4;
				break;
			case 'CSV':
				$formatReport = 5;
				break;
			case 'ODT':
				$formatReport = 6;
				break;
			case 'ODS':
				$formatReport = 7;
				break;
		}
				
		exec('pwd', $pathReport);
		$params['SUBREPORT_DIR'] = $this->_getsubReportDir($pathReport[0].'/reports/'.$nameReportJasper);
		exec('java -jar ../static/jasper_report_generate/JasperReportGenerate.jar '.$pathReport[0].'/reports/'.$nameReportJasper.' '.($params == '' ? 'null' : '"'.str_replace('"', '\"', json_encode($params)).'"').' '.$formatReport, $outputJasperReportGenerate);

		if($codeValidator){
			$CI =& get_instance();
			$mongo = new Mongo('mongodb://'.$CI->config->item('mongo_host'));
			$db = $mongo->selectDB($CI->config->item('mongo_db'));
			$gridFS = $db->getGridFS();
			
			$upload = array('file_name' => $outputJasperReportGenerate[0], 'orig_name' => $nameReport.'.pdf', 'file_size' => round(filesize('../archives/reports/'.$outputJasperReportGenerate[0])/1024, 2), 'file_type' => 'application/pdf');
			$storedfile = $gridFS->storeFile($pathArchive.'archives/reports/'.$upload['file_name'],
													array('filename' => $upload['file_name'],
															'filename_original' => $upload['orig_name'],
															'type' => $upload['file_type'],
															'no_thumb' => true,
															'code_validator' => $code_validator_report));
		}

		if($stream){
			$pdfcontents = file_get_contents('../archives/reports/'.$outputJasperReportGenerate[0]);
			header('Pragma: public');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Cache-Control: public');
			header('Content-Description: File Transfer');
			header('Content-Type: application/pdf');
			header('Content-Disposition: attachment; filename= '.$nameReport.'.pdf');
			header('Content-Transfer-Encoding: binary');
			echo $pdfcontents;
		}else{
			force_download($nameReport.'.pdf', file_get_contents('../archives/reports/'.$outputJasperReportGenerate[0]));
		}
	}
	
	private function _getsubReportDir($pathReport){
		$stringPathSubReport = '';
		foreach(explode('/', $pathReport) as $pathSubReport)
			if(!strpos($pathSubReport, '.jasper'))
				$stringPathSubReport.= $pathSubReport.'/';
				
		return $stringPathSubReport;		 
	}
	
}