<?php
/**
 * A kind of monadic wrapper
 *
 * @author    Dmytro Karpovych
 * @copyright 2019 NRE
 */

namespace Crawler;

class Arg
{
    protected $value;

    protected function __construct($value)
    {
        $this->value = $value;
    }

    public static function cli($index, $default)
    {
        $value = function () use ($index, $default) {

            if (isset($_SERVER['argv'][$index])) {
                return $_SERVER['argv'][$index];
            }

            return $default;
        };
        return new static($value);
    }

    public function file()
    {
        $filename = $this->val();
        if (!file_exists($filename)) {
            $this->error("File $filename doesn't exist");
        }
        return $this;
    }

    public function val()
    {
        $value = $this->value;
        if (!is_callable($value)) {
            $this->error("Can't get value");
        }
        return $value();
    }

    protected function error($message, $code = 1)
    {
        print($message);
        exit($code);
    }

    public function readFile()
    {
        $file = $this->val();
        $this->value = function () use ($file) {
            return file_get_contents($file);
        };
        return $this;
    }

    public function splitBy($delimiter)
    {
        $this->apply(function ($value) use ($delimiter) {
            return explode($delimiter, $value);
        });
        return $this;
    }
    
    public function map($cb)
    {
        $value = $this->val();
        $this->value = function () use ($value, $cb) {
            return array_map($cb, $value);
        };
        return $this;
    }

    public function reduce($cb, $acc)
    {
        $value = $this->val();
        $this->value = function () use ($value, $cb, $acc) {
            return array_reduce($value, $cb, $acc);
        };
        return $this;
    }

    public function apply($cb) 
    {
        $value = $this->val();
        $this->value = function () use ($value, $cb) {
            return call_user_func_array($cb, [$value]);
        };
        return $this;
    }
}
