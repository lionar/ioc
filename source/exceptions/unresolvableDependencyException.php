<?php

namespace ioc\exceptions;

use RuntimeException as runtimeException;

class unresolvableDependencyException extends runtimeException
{
	public function __construct ( string $type, string $name )
	{
		$type = ( ! empty ( $type ) ) ? "the type: $type" : 'unknown type';
		$this->message = "A parameter with $type and the name: $name can not be resolved. Check the bindings in your container.";
	}
}