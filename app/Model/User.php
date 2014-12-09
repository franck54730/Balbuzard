<?php
class User extends AppModel {
	
	var $name = 'User';
	var $useTable = 'users';
	
	
public $validate = array(
	'login' => array(
		'rule' => array('notEmpty'),
		'message'=>'Ce champ ne doit pas etre vide!'
	),
	'password' => array(
        'confirm' => array(
            'rule' => array('password', 'password_r', 'confirm'),
            'message' => 'Les mots se doivent d\'être identiques.',
            'last' => true
        ),
        'length' => array(
            'rule' => array('password', 'password_r', 'length'),
            'message' => '6 caracteres minimum.'
        )
    ),
    'password_r' => array(
        'notempty' => array(
            'rule' => array('notEmpty'),
            'allowEmpty' => false,
            'message' => 'Confirmer votre mot de passe.'
        )
    )
);



public function password($data, $controlField, $test) {
	
    if (!isset($this->data[$this->alias][$controlField])) {
        trigger_error('Password control field not set.');
        return false;
    }

    $field = key($data);
    $password = current($data);
    $controlPassword = $this->data[$this->alias][$controlField];

    switch ($test) {
        case 'confirm' :
            if ($password !== $controlPassword) {
                $this->invalidate($controlField, 'Veuillez confirmer votre mot de passe.');
                return false;
            }
            return true;

        case 'length' :
            return strlen($controlPassword) >= 6;

        default :
            trigger_error("Unknown password test '$test'.");
    }

	}
}