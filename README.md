GamePanel.io PHP API Client
===========================

This library is a basic PHP implementation of the [GamePanel.io API](https://docs.gamepanel.io/api).

## Installation

This library uses the [HTTPlug](https://github.com/php-http/httplug) HTTP client abstraction library -
 meaning you can use your favourite HTTP library with it!
 
For a quick and easy way to use this library in your project, via composer, run the following:

```bash
  composer require php-http/guzzle6-adapter gamepanelio/api
```

There is also [lots of different libraries](https://packagist.org/providers/php-http/client-implementation)
 that you can use with HTTPlug. To see how to use different libraries please
 [refer to the HTTPlug documentation](http://docs.php-http.org/en/latest/httplug/users.html).

## Usage

Simply instantiate a `new GamePanelio()` class, and use the methods it provides:

```php
<?php

use GamePanelio\GamePanelio;
use GamePanelio\AccessToken\PersonalAccessToken;

$accessToken = new PersonalAccessToken("my-personal-access-token");
$gamepanelio = new GamePanelio("cool-name.mypanel.io", $accessToken);

$gamepanelio->createServer([
    /* ... required parameters ... */
]);
```

## License

This library is licensed under the MIT license. See the `LICENSE` file for more info.
