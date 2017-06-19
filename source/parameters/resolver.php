<?php

namespace ioc\parameters;

use Closure as closure;
use ioc\exceptions\unresolvableDependencyException;
use ReflectionFunction as reflection;
use ReflectionParameter as parameter;

trait resolver
{	
	public function resolve ( closure $concrete, array $payload = [ ] ) : array
	{
		$reflection = new reflection ( $concrete );

		foreach ( $reflection->getParameters ( ) as $parameter )
			$parameters [ $parameter->getName ( ) ] = $this->fill ( $parameter, $payload );

		return ( $parameters ) ?? [ ];
	}

	private function fill ( parameter $parameter, array $payload )
	{
		$name = $parameter->getName ( );
		$type = $this->type ( $parameter );

		if ( array_key_exists ( $name, $payload ) )
			return $payload [ $name ];
		if ( ! empty ( $type ) and $this->bound ( $type ) )
			return $this->make ( $type );
		if ( $parameter->isDefaultValueAvailable ( ) )
			return $parameter->getDefaultValue ( );

		throw new unresolvableDependencyException ( $type, $name );
	}

	private function type ( parameter $parameter )
	{
		return ( $parameter->hasType ( ) ) ?
			$parameter->getClass ( )->getName ( ) : '';
	}
}