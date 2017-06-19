<?php

namespace ioc\exceptions;

use InvalidArgumentException as invalidArgumentException;

class alreadyBoundException extends invalidArgumentException
{
	public function __construct ( string $abstract )
	{
		$this->message = "The type: $abstract is already bound in the container. We do not allow to overwrite it.";
	}
}