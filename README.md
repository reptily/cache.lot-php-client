# cache.lot-php-client

## Install
```
composer require cache.lot/client
```

## Example
```php
require "./vendor/autoload.php";

//Connect ro server
$Cachelot = new Cachelot("127.0.0.1", 3000);

$Cachelot->set("car","hyundai"); //setting variable
echo $Cachelot->get("car") . "\n"; //getting the variable

echo $Cachelot->show() . "\n"; //getting list the keys

$Cachelot->set("bike",['ktm', 'yamaha', 'suzuki']); //setting variable in type array
print_r($Cachelot->get("bike")); //get value array

$Cachelot->del("bike"); //delete value
$Cachelot->die("bike",5); //setting the lifetime of the variable

$Cachelot->close();
```