<?php

namespace ioc;

use ioc\exceptions\alreadyBoundException;
use ioc\exceptions\notBoundException;
use ioc\parameters\resolver;

class container
{
	use binding;
	use parameters\resolver;

	private $instances = [ ];

	public function make ( string $abstract, array $payload = [ ] )
	{
		if ( ! $this->bound ( $abstract ) )
			throw new notBoundException ( $abstract );

		return ( $this->instances [ $abstract ] ) ?? $this->build ( $abstract, $payload );
	}

	private function build ( string $abstract, array $payload = [ ] )
	{
		$concrete = ( $this->bindings [ $abstract ] ) ?? $this->bindings [ 'shared' ] [ $abstract ];

		$parameters = $this->resolve ( $concrete, $payload );
		$concrete = call_user_func_array ( $concrete, $parameters );

		return $this->resolving ( $abstract, $concrete );
	}

	private function resolving ( string $abstract, $concrete )
	{
		if ( $this->isShared ( $abstract ) )
			$this->instances [ $abstract ] = $concrete;
		
		return $concrete;
	}
}