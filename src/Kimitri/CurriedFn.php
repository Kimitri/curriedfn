<?php

namespace Kimitri;

/**
 * The CurriedFn class.
 */
class CurriedFn {
  protected $fn;              // Function to curry
  protected $paramCount;      // Parameters to collect before calling
  protected $paramMap;

  /**
   * Constructor.
   * 
   * @param callable   $fn
   * Function to curry.
   * 
   * @param int|null   $numParams
   * Number of parameters used to call the function. By default, function arity
   * (number of parameters defined in the function signature) is used.
   *
   * @param array|null $paramMap
   * An array of parameter indices. This array can be used to reorder function
   * arguments before calling the curried function.
   */
  public function __construct(callable $fn, int $numParams = null, array $paramMap = null) {
    $this->fn = $fn;

    $reflection = new \ReflectionFunction($fn);
    $arity = $reflection->getNumberOfParameters();

    $this->paramCount = (is_null($numParams) || $numParams < 2 || $numParams > $arity) ? $arity : $numParams;

    $this->paramMap = (!is_null($paramMap) && count($paramMap) == $this->paramCount) ? $paramMap : null;
  }

  /**
   * The __invoke magic method implementation.
   * 
   * @param  mixed  $firstArg
   * Argument to collect on the first call iteration.
   * 
   * @return CurriedCall
   * A CurriedCall instance.
   */
  public function __invoke($firstArg) {
    return new CurriedCall($this->fn, $this->paramCount, [$firstArg], $this->paramMap);
  }
}