<?php

namespace Kimitri;

/**
 * The CurriedCall class.
 */
class CurriedCall {
  protected $fn;
  protected $paramCount;
  protected $arguments;
  protected $paramMap;

  /**
   * Constructor.
   * 
   * @param callable $fn
   * Function to curry.
   * 
   * @param int        $paramCount
   * Number of parameters used to call the function.
   * 
   * @param array      $arguments
   * Collected arguments.
   *
   * @param array|null $paramMap
   * An array of parameter indices. This array can be used to reorder function
   * arguments before calling the curried function.
   */
  public function __construct(callable $fn, int $paramCount, array $arguments, array $paramMap = null) {
    $this->fn = $fn;
    $this->paramCount = $paramCount;
    $this->arguments = $arguments;
    $this->paramMap = $paramMap;
  }

  /**
   * The __invoke magic method implementation.
   * 
   * @param  mixed  $arg
   * Current call argument.
   * 
   * @return mixed
   * A callable CurriedCall instance if more arguments need to be passed to the
   * function or the result of the actual function call if all arguments are
   * collected.
   */
  public function __invoke($arg) {
    $arguments = array_merge($this->arguments, [$arg]);
    
    if (count($arguments) === $this->paramCount) {
      return self::call($this->fn, $arguments, $this->paramMap);
    }
    
    return new CurriedCall($this->fn, $this->paramCount, $arguments);
  }

  /**
   * Calls the curried function with reordered arguments.
   * 
   * @param  callable   $fn
   * The curried function.
   * 
   * @param  array      $arguments
   * Arguments in the order they were passed to the currying pipeline.
   * 
   * @param  array|null $map
   * Parameter mapping array.
   * 
   * @return mixed
   * The function call result.
   */
  protected static function call(callable $fn, array $arguments, array $map = null) {
    $callArgs = $arguments;

    if (is_array($map) && !empty($map)) {
      $callArgs = array_map(function($index) use ($arguments) {
        return $arguments[$index];
      }, $map);
    }
    
    return call_user_func_array($fn, $callArgs);
  }
}