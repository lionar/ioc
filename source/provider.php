<?php

namespace ioc;

abstract class provider
{
	protected $container = null;

	public function __construct ( container $container )
	{
		$this->container = $container;
	}

	abstract public function register ( );
}