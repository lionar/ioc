<?php

namespace ioc;

use Closure as closure;
use ioc\exceptions\inexistentBindingException;

class container
{
	private $resolver = null;
	private $instances = null;
	private $bindings = null;

	public function __construct ( resolver $resolver = null, instances $instances = null, bindings $bindings = null )
	{
		$this->resolver = ( $resolver ) ?: new resolver ( $this );
		$this->instances = ( $instances ) ?: new instances ( $this->resolver );
		$this->bindings = ( $bindings ) ?: new bindings ( $this->resolver );
	}

	public function bind ( string $abstract, closure $concrete, bool $shared = false )
	{
		if ( $shared )
			$this->instances->add ( $abstract, $concrete );
		else
			$this->bindings->add ( $abstract, $concrete );
	}

	public function share ( string $abstract, closure $concrete )
	{
		$this->bind ( $abstract, $concrete, true );
	}

	public function make ( string $abstract, array $payload = [ ] )
	{
		if ( $this->instances->has ( $abstract ) )
			return $this->instances->resolve ( $abstract, $payload );
		if ( $this->bindings->has ( $abstract ) )
			return $this->bindings->resolve ( $abstract, $payload );
		throw new inexistentBindingException ( $abstract );
	}

	public function call ( closure $concrete, array $payload = [ ] )
	{
		return $this->resolver->resolve ( $concrete, $payload );
	}

	public function bound ( string $abstract ) : bool
	{
		return ( $this->instances->has ( $abstract ) or
			$this->bindings->has ( $abstract ) );
	}
}