<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Uniqueness;

class Users extends \Phalcon\Mvc\Model
{
	public $id;
	public $nombre;
	public $apellidos;
	public $email;
    public $password;
    public $nivel;
	public $lang;

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'email',
            new Email(
                [
                    'message' => 'Please enter a correct email address',
                ]
            )
        );
		$validator->add(
			"email",
			new Uniqueness(
				[
					'message' => "Ya existe esta dirección e-mail",
				]
			)
		);

        return $this->validate($validator);
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("tecmp_base");
        $this->setSource("users");
    }
}
