<?php

namespace ioc;

use Closure as closure;
use ioc\exceptions\existentInstanceException;
use ioc\exceptions\inexistentInstanceException;

class instances
{
	private $resolver = null;
	private $collection = [ ];
	private $resolved = [ ];

	public function __construct ( resolver $resolver )
	{
		$this->resolver = $resolver;
	}

	public function add ( string $abstract, closure $concrete )
	{
		if ( $this->has ( $abstract ) )
			throw new existentInstanceException ( $abstract );
		$this->collection [ $abstract ] = $concrete;
	}

	public function resolve ( string $abstract )
	{
		if ( array_key_exists ( $abstract, $this->resolved ) )
			return $this->resolved [ $abstract ];
		if ( $this->has ( $abstract ) )
			return $this->cache ( $abstract );
		throw new inexistentInstanceException ( $abstract );
	}

	public function has ( string $abstract ) : bool
	{
		return ( array_key_exists ( $abstract, $this->collection ) );
	}

	private function cache ( string $abstract )
	{
		$resolved = $this->resolver->resolve ( $this->collection [ $abstract ] );
		$this->resolved [ $abstract ] = $resolved;
		return $resolved;
	}
}