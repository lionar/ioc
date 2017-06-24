<?php

namespace ioc\exceptions;

use RuntimeException as runtimeException;

class existentBindingException extends runtimeException
{
	public function __construct ( string $abstract )
	{
		$this->message = "A binding for type: $abstract already exists.";
	}
}