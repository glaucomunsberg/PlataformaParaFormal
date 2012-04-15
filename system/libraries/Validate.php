<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Validate {
	
	protected $_errors = array();
	protected $_data;

	public function validateField($field, $typeValidator, $message) {
		$valid = null;
		
		if (array_key_exists($field,$this->_data)){
		
			$valid = $this->execValidate($typeValidator,$this->_data[$field]);			
			
			if ($valid == false) {				
				$this->addError($field, $message);
			}	
		}
		return;
	}

	public function addError($field, $message) {
		$this->_errors[$field] = $message;
	}

	public function removeError($field, $message) {
		//IMPLEMENTES
	}

	public function existsErrors() {
		if (count($this->_errors) == 0){
			return false;
		} else {
			return true;
		}
	}

	public function getErrors() {
		$errors = array ();
		foreach ($this->_errors as $field => $message) {
			array_push($errors, array (
				                       "printErrorForm" => array ("message" => $message,
																  "field" => $field
				                                                  )));
		}
		return $errors;
	}
	
	public function getError() {
		$error = array ();
		foreach ($this->_errors as $field => $message) {
			$error = array ("message" => $message,
					        "field" => $field
					        );
			return $error;
		}
		return $error;
	}	

	public function getData(){
		return $this->_data;
	}
	
	public function setData($data){
		$this->_data = $data;
	}

	public function execValidate($regex,$data){		
		$regexExpression = $regex[0];		
		
		switch (strtoupper($regexExpression)) {
			case strtoupper('is_numeric'):
				return $this->validate_is_numeric($data);
			case strtoupper('alpha_dash'):	 
			  	return $this->validate_alpha_dash($data);
			case strtoupper('alpha_numeric'):	 
			  	return $this->validate_alpha_numeric($data);
			case strtoupper('alpha'):	 
			  	return $this->validate_alpha($data);
			case strtoupper('valid_email'):	 
			  	return $this->validate_valid_email($data);
			case strtoupper('exact_length'):
			  	return $this->validate_exact_length($data);
			case strtoupper('min_length'):
			  	return $this->validate_min_length($data,$regex[1]);
			case strtoupper('max_length'):
			  	return $this->validate_max_length($data,$regex[1]);
			case strtoupper('between'):
			  	return $this->validate_between($data,$regex[1],$regex[2]);
			case strtoupper('matches'):	 
			  	return $this->validate_matches($data);
			case strtoupper('required'):	 
			  	return $this->validate_required($data);			  					  					  					  					  					  					  					  					  						  	
		}
	}

	/**
	 * Required
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function validate_required($str)	{
		if ( ! is_array($str)){
			return (trim($str) == '') ? FALSE : TRUE;
		}
		else{
			return ( ! empty($str));
		}
	}
	
	/**
	 * Match one field to another
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function validate_matches($str, $field) {
		if ( ! isset($_POST[$field])){
			return FALSE;
		}
		
		return ($str !== $_POST[$field]) ? FALSE : TRUE;
	}
	
	/**
	 * Minimum Length
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */	
	function validate_min_length($str, $val)	{
		if (preg_match("/[^0-9]/", $val)){
			return FALSE;
		}
	
		return (strlen($str) < $val) ? FALSE : TRUE;
	}
	
	/**
	 * Max Length
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */	
	function validate_max_length($str, $val)	{
		if (preg_match("/[^0-9]/", $val)){
			return FALSE;
		}
	
		return (strlen($str) > $val) ? FALSE : TRUE;
	}
	
	/**
	 * Exact Length
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */	
	function validate_exact_length($str, $val){
		if (preg_match("/[^0-9]/", $val)){
			return FALSE;
		}
	
		return (strlen($str) != $val) ? FALSE : TRUE;
	}
	
	/**
	 * Valid Email
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */	
	function validate_valid_email($str){
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
	}

	/**
	 * Alpha
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */		
	function validate_alpha($str){
		return ( ! preg_match("/^([a-z])+$/i", $str)) ? FALSE : TRUE;
	}
	
	/**
	 * Alpha-numeric
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */	
	function validate_alpha_numeric($str){
		return ( ! preg_match("/^([a-z0-9])+$/i", $str)) ? FALSE : TRUE;
	}
	
	/**
	 * Alpha-numeric with underscores and dashes
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */	
	function validate_alpha_dash($str){
		return ( ! preg_match("/^([-a-z0-9_-])+$/i", $str)) ? FALSE : TRUE;
	}
	
	/**
	 * Numeric
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */	
	function validate_numeric($str){
		return ( ! ereg("^[0-9\.]+$", $str)) ? FALSE : TRUE;
	}
	
	/**
	 * Is Numeric
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */	
	function validate_is_numeric($str){
		return ( ! is_numeric($str)) ? FALSE : TRUE;
	}

	/**
	 * Between
	 *
	 * @access	public
	 * @param	integer
	 * @param	integer
	 * @return	bool
	 */	
	function validate_between($str,$min,$max){
		if(!$this->validate_max_length($max, $str) || !$this->validate_min_length($min, $str))
			return FALSE;			
		else
			return TRUE;
	}
}
?>