<?php

namespace ioc;

use Closure as closure;
use ioc\exceptions\alreadyBoundException;
use ioc\exceptions\notBoundException;
use ioc\parameters\resolver;

class container
{
	use parameters\resolver;

	private $instances = [ ];
	private $bindings = [ 'shared' => [ ] ];

	public function bind ( string $abstract, closure $concrete, bool $shared = false )
	{
		if ( $this->bound ( $abstract ) )
			throw new alreadyBoundException ( $abstract );

		$this->set ( $abstract, $concrete, $shared );
	}

	public function share ( string $abstract, closure $concrete )
	{
		$this->bind ( $abstract, $concrete, true );
	}

	public function bound ( string $abstract ) : bool
	{
		return ( array_key_exists ( $abstract, $this->bindings ) or
			( $this->isShared ( $abstract ) ) );
	}

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

	private function isShared ( string $abstract )
	{
		return ( array_key_exists ( $abstract, $this->bindings [ 'shared' ] ) );
	}

	private function set ( string $abstract, closure $concrete, bool $shared )
	{
		if ( $shared )
			$this->bindings [ 'shared' ] [ $abstract ] = $concrete;
		else
			$this->bindings [ $abstract ] = $concrete;
	}
}