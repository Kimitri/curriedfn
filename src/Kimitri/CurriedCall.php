<?php

namespace Kimitri;

/**
 * The CurriedCall class.
 */
class CurriedCall {
  protected $fn;
  protected $paramCount;
  protected $arguments;

  /**
   * Constructor.
   * 
   * @param callable $fn
   * Function to curry.
   * 
   * @param int      $paramCount
   * Number of parameters used to call the function.
   * 
   * @param array    $arguments
   * Collected arguments.
   */
  public function __construct(callable $fn, int $paramCount, array $arguments) {
    $this->fn = $fn;
    $this->paramCount = $paramCount;
    $this->arguments = $arguments;
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
      return call_user_func_array($this->fn, $arguments);
    }
    
    return new CurriedCall($this->fn, $this->paramCount, $arguments);
  }
}