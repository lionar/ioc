<?php

namespace ioc\exceptions;

use RuntimeException as runtimeException;

class inexistentBindingException extends runtimeException
{
	public function __construct ( string $abstract )
	{
		$this->message = "A binding for type: $abstract can not be found.";
	}
}