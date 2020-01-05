<?php

namespace App\Model;

class CalculatorManager
{
    const
    ADD = 1,
    SUBTRACT = 2,
    MULTIPLY = 3,
    DIVIDE = 4;
    
    public function add($x, $y)
    {
        return $x + $y;
    }

    public function subtract($x, $y)
    {
        return $x - $y;
    }

    public function multiply($x, $y)
    {
        return $x * $y;
    }

    public function divide($x, $y)
    {
        return round($x / $y);
    }

    public function getOperations()
    {
        return array(
            self::ADD => 'Sčítání',
            self::SUBTRACT => 'Odčítání',
            self::MULTIPLY => 'Násobení',
            self::DIVIDE => 'Dělení'
        );
    }

    public function calculate($operation, $x, $y)
    {
        switch ($operation) {
            case self::ADD:
                return $this->add($x, $y);
            case self::SUBTRACT:
                return $this->subtract($x, $y);
            case self::MULTIPLY:
                return $this->multiply($x, $y);
            case self::DIVIDE:
                return $this->divide($x, $y);
            default:
                return null;
        }
    }
}
