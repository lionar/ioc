# IOC container

## Issues

- How to arrange recursive ( nested ) resolving of scalar dependency values when directly providing the parameters in the first call to make: example

```php

class package
{
    public function __construct ( string $name, measurements $measurements )
    {
        $this->name = $name;
        $this->measurements = $measurements;
    }
}

class measurements
{
    public function __construct ( int $quantity )
    {
        $this->quantity = $quantity;
    }
}


// how to inject the provided quantity into the measurements class?
$container->make ( 'package', [ 'name' => '1 kg bag', 'quantity' => 1 ] );


// or should we make the measurements class first?

$measurements = $container->make ( 'measurements', [ 'quantity' => 1 ] );
$container->make ( 'package', [ 'name' => '1 kg bag', 'measurements' => $measurements ] );


```
