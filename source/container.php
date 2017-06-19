<?php

namespace ioc;

use Closure as closure;
use ioc\exceptions\alreadyBoundException;
use ioc\exceptions\notBoundException;
use ioc\parameters\resolver;

class container
{
	use parameters\resolver;

	private $bindings = [ ];

	public function bind ( string $abstract, closure $concrete )
	{
		if ( $this->bound ( $abstract ) )
			throw new alreadyBoundException ( $abstract );
		$this->bindings [ $abstract ] = $concrete;
	}

	public function bound ( string $abstract ) : bool
	{
		return ( array_key_exists ( $abstract, $this->bindings ) );
	}

	public function make ( string $abstract, array $payload = [ ] )
	{
		if ( ! $this->bound ( $abstract ) )
			throw new notBoundException ( $abstract );

		$concrete = $this->bindings [ $abstract ];

		$parameters = $this->resolve ( $concrete, $payload );
		return call_user_func_array ( $concrete, $parameters );
	}
}