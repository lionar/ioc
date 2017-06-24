<?php

require __DIR__ . '/../vendor/autoload.php';


$container = new ioc\container;

class Text
{

}

class Greeting
{
	public $text = 'Hi there';

	public function __toString ( )
	{
		return $this->text;
	}
}

$container->bind ( 'Text', function ( )
{
	return new Text;
} );

$container->bind ( 'Greeting', function ( Text $text )
{
	return new Greeting;
} );

$container->bind ( 'greet', function ( Greeting $greeting, $hello )
{
	echo $greeting;
	echo $hello;
} );

// $container->make ( 'greet', [ 'hello' => '<h1>Hello man</h1>' ] );


class testing
{

}

$container->share ( 'testing', function ( )
{
	return new testing;
} );

var_dump ( $container->make ( 'testing' ) === $container->make ( 'testing' ) );