# The CurriedFn class - curried function calls in PHP

Transforming a function call with multiple parameters into a series of single parameter function calls is called _currying_. Currying is a useful tool with higher order functions when a partially applied function is needed.

## Usage

```php
use Kimitri\CurriedFn;

$fn = new CurriedFn('strpos', 2);
$subs = ['a', 'p', 'oa'];

$indices = array_map($fn('soap'), $subs);

print_r($indices); // [2, 3, 1]
```

In this example a curried version of the `strpos` function is created. We limit the `CurriedFn` class to call the function with two arguments to make use of the default argument defined in the third function parameter. Without the limiting parameter all three arguments would need to be passed.

The curried function object is used to create a partially applied version of the `strpos` function. In this case the string `'soap'` is bound as the first argument to the partially applied function. This partially applied function is then used as a mapping function in the `array_map` call, giving us a nice, clean way of mapping substrings to substring indices in a given string.