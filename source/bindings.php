<?php

namespace ioc;

use Closure as closure;
use ioc\exceptions\existentBindingException;
use ioc\exceptions\inexistentBindingException;

class bindings
{
	private $collection = [ ];
	private $resolver = null;

	public function __construct ( resolver $resolver )
	{
		$this->resolver = $resolver;
	}

	public function add ( string $abstract, closure $concrete )
	{
		if ( $this->has ( $abstract ) )
			throw new existentBindingException ( $abstract );
		$this->collection [ $abstract ] = $concrete;
	}

	public function resolve ( string $abstract, array $payload = [ ] )
	{
		if ( ! $this->has ( $abstract ) )
			throw new inexistentBindingException ( $abstract );
		$concrete = $this->collection [ $abstract ];
		return $this->resolver->resolve ( $concrete, $payload );
	}

	public function has ( string $abstract ) : bool
	{
		return ( array_key_exists ( $abstract, $this->collection ) );
	}
}