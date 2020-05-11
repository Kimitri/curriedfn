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

Function arguments can also be reordered right before calling the curried function. Compare this example to the previous one:

```php
use Kimitri\CurriedFn;

$fn = new CurriedFn('strpos', 2, [1, 0]);
$strings = ['soap', 'Laos', 'oops'];

$indices = array_map($fn('o'), $strings);

print_r($indices);
```

Here, the `CurriedFn` class is instantiated with a parameter mapping array that tells the order in which the arguments should be passed on to the curried function. In the previous example we had an array of substrings we wanted to map to their indices in a static haystack string. In this example we have an array of haystack strings that we want to map to substring indices of a static substring.