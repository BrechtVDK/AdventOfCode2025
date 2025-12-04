<?php

namespace App\Solutions\Year_2024;

use App\Solutions\AbstractSolution;

class Solution_03 extends AbstractSolution
{
    public function __construct(bool $useExample = false)
    {
        parent::__construct(2024, 03, $useExample);
    }

    protected function parseInput(): array
    {
        // Parse and return structured data from $this->input
        return $this->getLines();
    }

    public function silver(): int|string
    {
        // Solve part 1 using $this->parsedInput
        return 'todo';
    }

    public function gold(): int|string
    {
        // Solve part 2 using $this->parsedInput
        return 'todo';
    }

    // Add helper methods here
}
