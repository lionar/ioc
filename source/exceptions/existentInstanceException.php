<?php

namespace ioc\exceptions;

use RuntimeException as runtimeException;

class existentInstanceException extends runtimeException
{
	public function __construct ( string $abstract )
	{
		$this->message = "An instance for type: $abstract already exists.";
	}
}