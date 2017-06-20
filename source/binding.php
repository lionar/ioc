<?php

namespace ioc;

use Closure as closure;

trait binding
{
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