<?php

namespace App\Solutions\Year_2025;

use App\Solutions\AbstractSolution;

class Solution_10 extends AbstractSolution
{

    public function __construct(bool $useExample = false)
    {
        parent::__construct(2025, 10, $useExample);
    }

    protected function parseInput(): array
    {
        return $this->getLines();
    }

    public function silver(): int|string
    {
        ray($this->parsedInput);
        return 'todo';
    }

    public function gold(): int|string
    {
        return 'todo';
    }

}
