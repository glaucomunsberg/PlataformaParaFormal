<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * librarie responsavel por manipular diversos componentes form do sistema
 * @package libraries
 * @subpackage validate
 */
class Validate {

    protected $_errors = array();
    protected $_data;

    /**
     * Valida um campo do formulário.<br>
     * O formulário deve ser passado atravéz de {@link setData()}
     * @param string $field O nome do campo a ser validado, em caso de erro este campo receberá o foco
     * @param string|array $typeValidator O tipo de validação.
     * Ex.:
     * <ol>
     *  <li/>array: min_length, max_length, between, any
     *  <li/>string: is_numeric, alpha_dash, alpha_numeric, alpha, valid_email, exact_length, matches, required, real
     *  <li/>string: nome de qualquer função php que aceite um parâmetro e retorne TRUE ou FALSE
     * <ol>
     * @param string $message
     * @see setData()
     *
     */
    public function validateField($field, $typeValidator, $message) {
        if (array_key_exists($field, $this->_data)) {
            $valid = $this->execValidate($typeValidator, $this->_data[$field]);

            if ($valid == false) {
                $this->addError($field, $message);
            }
        } else if ($typeValidator == 'required' || @in_array('required', $typeValidator)) {
            $this->addError($field, $message);
        }
    }

    /**
     * Adiciona uma mensagem de erro
     * @param string $field O nome do campo a receber o foco após a mensagem de erro
     * @param string $message A mensagem de erro
     */
    public function addError($field, $message) {
        if (!isset($this->_errors[$field])) {
            $this->_errors[$field] = $message;
        }
    }

    /**
     * 
     * @param type $field
     * @param type $message 
     * @todo IMPLEMENTAR!!!
     */
    public function removeError($field, $message) {
        ;
    }

    /**
     * Verifica a existência de erros
     * @return boolean
     */
    public function existsErrors() {
        if (count($this->_errors) == 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return array Um array com os erros
     */
    public function getErrors() {
        $errors = array();
        foreach ($this->_errors as $field => $message) {
            array_push($errors, array(
                "printErrorForm" => array("message" => $message,
                    "field" => $field
                    )));
        }
        return $errors;
    }

    /**
     * @return array O primeiro erro encontrado, ou um array vazio se não houverem erros
     */
    public function getError() {
        $error = array();
        foreach ($this->_errors as $field => $message) {
            $error = array("message" => $message,
                "field" => $field
            );
            return $error;
        }
        return $error;
    }

    /**
     * @return array
     */
    public function getData() {
        return $this->_data;
    }

    /**
     * Armazena todos os campos de formulário recebidos
     * @internal Os campos são recebidos via $_GET ou $_POST
     * @internal não podia pegar um array_merge($_GET, $_POST) automáticamente?????
     */
    public function setData($data) {
        $this->_errors = array();
        $this->_data = $data;
    }

    /**
     * @ignore
     * @internal Caso o parâmetro não seja array, loga uma mensagem de erro e retorna FALSE
     * @see execValidate()
     */
    private function validationNotArray($regex) {
        if (!is_array($regex)) {
            logVar("ERRO\n\$typeValidator em validateField(\$field, \$typeValidator, \$message) deve ser um array para este tipo de validação.");
            return false;
        }
        return true;
    }

    /**
     * Valida $data de acordo com $regex
     * @param string|array $regex O tipo de validação, veja {@link validateField()}
     * @param type $data
     * @return boolean
     * @see validateField()
     */
    public function execValidate($regex, $data) {
        if (is_array($regex)) {
            $regexExpression = $regex[0];
        } else {
            $regexExpression = $regex;
        }

        switch (strtolower($regexExpression)) {
            case 'min_length':
                if ($this->validationNotArray($regex)) {
                    return false;
                }
                return $this->validate_min_length($data, $regex[1]);
            case 'max_length':
                if ($this->validationNotArray($regex)) {
                    return false;
                }
                return $this->validate_max_length($data, $regex[1]);
            case 'between':
                if ($this->validationNotArray($regex)) {
                    return false;
                }
                return $this->validate_between($data, $regex[1], $regex[2]);
            case 'any':
                if ($this->validationNotArray($regex)) {
                    return false;
                }
                array_shift($regex);
                return $this->validate_any($data, $regex);
            case 'is_numeric':
                return $this->validate_is_numeric($data);
            case 'alpha_dash':
                return $this->validate_alpha_dash($data);
            case 'alpha_numeric':
                return $this->validate_alpha_numeric($data);
            case 'alpha':
                return $this->validate_alpha($data);
            case 'valid_email':
                return $this->validate_valid_email($data);
            case 'exact_length':
                return $this->validate_exact_length($data);
            case 'matches':
                return $this->validate_matches($data);
            case 'required':
                return $this->validate_required($data);
            case 'real':
                return $this->validate_real($data);
            case 'recaptcha':
            	return $this->validate_recaptcha($data);
        }
        if (is_callable($regexExpression)) {
            return $regexExpression($data);
        }
    }

    function validate_real($val) {
        return preg_match('/^(?:[1-9](?:[\d]{0,2}(?:\.[\d]{3})*|[\d]+)|0)(?:,[\d]{0,2})?$/', $val);
    }

    /**
     * Any passed value
     * @param string $str
     * @param array $values
     * @return bool
     */
    function validate_any($str, array $values) {
        foreach ($values as $value) {
            if ($str == $value) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * Required
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function validate_required($str) {
        if (!is_array($str)) {
            return (trim($str) == '') ? FALSE : TRUE;
        } else {
            return (!empty($str));
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
        if (!isset($_POST[$field])) {
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
    function validate_min_length($str, $val) {
        if (preg_match("/[^0-9]/", $val)) {
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
    function validate_max_length($str, $val) {
        if (preg_match("/[^0-9]/", $val)) {
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
    function validate_exact_length($str, $val) {
        if (preg_match("/[^0-9]/", $val)) {
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
    function validate_valid_email($str) {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }

    /**
     * Alpha
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function validate_alpha($str) {
        return (!preg_match("/^([a-z])+$/i", $str)) ? FALSE : TRUE;
    }

    /**
     * Alpha-numeric
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function validate_alpha_numeric($str) {
        return (!preg_match("/^([a-z0-9])+$/i", $str)) ? FALSE : TRUE;
    }

    /**
     * Alpha-numeric with underscores and dashes
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function validate_alpha_dash($str) {
        return (!preg_match("/^([-a-z0-9_-])+$/i", $str)) ? FALSE : TRUE;
    }

    /**
     * Numeric
     *
     * @access	public
     * @param	int
     * @return	bool
     */
    function validate_numeric($str) {
        return (!ereg("^[0-9\.]+$", $str)) ? FALSE : TRUE;
    }

    /**
     * Is Numeric
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function validate_is_numeric($str) {
        return (!is_numeric($str)) ? FALSE : TRUE;
    }

    /**
     * Between
     *
     * @access	public
     * @param	integer
     * @param	integer
     * @return	bool
     */
    function validate_between($str, $min, $max) {
        return ($this->validate_max_length($max, $str) && $this->validate_min_length($min, $str));
    }

	/**
	 * Valida a resposta do desafio do componente recaptcha
	 * @param string resposta do usuário ao desafio recaptcha
	 * @return boolean Retorna true caso a resposta seja válida e false caso contrário
	 */
    function validate_recaptcha($str){
    	$returnRecaptcha = recaptcha_check_answer(KEY_PRIVATE_RECAPTCHA, $_SERVER["REMOTE_ADDR"], $this->_data['recaptcha_challenge_field'], $str);
    	return $returnRecaptcha->is_valid;
    }

}