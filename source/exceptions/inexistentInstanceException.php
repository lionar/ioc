<?php

namespace ioc\exceptions;

use RuntimeException as runtimeException;

class inexistentInstanceException extends runtimeException
{
	public function __construct ( string $abstract )
	{
		$this->message = "An instance for type: $abstract can not be found.";
	}
}