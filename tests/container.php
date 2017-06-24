<?php

use ioc\container;

require __DIR__ . '/../vendor/autoload.php';

$container = new container;
$container->share ( 'ioc\container', function ( ) use ( $container ) { return $container; } );
$container->bind ( 'test', function ( )
{
	return 'Testing the ioc container';
} );

$container->bind ( 'first', function ( ) { return 'Irsan'; } );
$container->bind ( 'last', function ( ) { return 'van Wel'; } );


$container->share ( 'name', function ( container $container )
{
	$first = $container->make ( 'first' );
	$last = $container->make ( 'last' );
	return "$first $last";
} );

echo $container->make ( 'name' );