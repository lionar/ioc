<?php

namespace ioc;

use Closure as closure;
use ioc\exceptions\unresolvableDependencyException;
use ReflectionFunction as reflection;
use ReflectionParameter as parameter;

class resolver
{	
	private $container = null;

	public function __construct ( container $container )
	{
		$this->container = $container;
	}

	public function resolve ( closure $concrete, array $payload = [ ] )
	{
		$parameters = $this->getParameters ( $concrete, $payload );
		return call_user_func_array ( $concrete, $parameters );
	}

	private function getParameters ( closure $concrete, array $payload = [ ] ) : array
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
		if ( ! empty ( $type ) and $this->container->bound ( $type ) )
			return $this->container->make ( $type );
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