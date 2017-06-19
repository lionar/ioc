<?php

namespace ioc\exceptions;

use InvalidArgumentException as invalidArgumentException;

class notBoundException extends invalidArgumentException
{
	public function __construct ( string $abstract )
	{
		$this->message = "The type: $abstract is not bound in the container.";
	}
}