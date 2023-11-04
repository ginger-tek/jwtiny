# jwtiny
Super small PHP lib for generating and verifying JWT tokens

To use, just require and call on the static methods to generate/verify a token.

On the `sign` function, the third parameter for expiration is optional, and defaults to 1 hour when not specified. The value must be in milliseconds, so calculate accordingly beforehand.

```php
require 'jwtiny.php'

$data = [
  'id' => 1,
  'username' => '...'
];
$secret = 'mysecretkey';
$expires = time() + (24 * 60 * 1000); // expire in 24 hours

$token = JWTiny::sign($data, $secret, $expires);
```

```php
$token = '...';
$secret = 'mysecretkey';
try {
  $data = JWTiny::verify($token, $secret);
  $data->username // access data
} catch(Exception $ex) {
  // handle failure to verify token
}
```
