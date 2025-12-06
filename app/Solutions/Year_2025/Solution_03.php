<?php

namespace App\Solutions\Year_2025;

use App\Solutions\AbstractSolution;
use function PHPUnit\Framework\stringContains;

class Solution_03 extends AbstractSolution
{
    public function __construct(bool $useExample = false)
    {
        parent::__construct(2025, 03, $useExample);
    }

    protected function parseInput(): array
    {
        // Parse and return structured data from $this->input
        return $this->getLines();
    }

    public function silver(): int|string
    {
        $total = 0;
        foreach ($this->parsedInput as $bank) {
            $total += $this->getLargestJoltageSilver($bank);
        }
        return $total;
    }

    public function gold(): int|string
    {
        $total = 0;
        foreach ($this->parsedInput as $bank) {
            $total += $this->getLargestJoltageGold($bank);
        }
        return $total;
    }

    private function getLargestJoltageSilver(string $bank): int
    {
        $max1 = max(str_split(substr($bank, 0, strlen($bank) - 1)));
        $max2 = max(str_split(substr($bank, strpos($bank, $max1) + 1)));

        return (int)$max1 . $max2;

    }

    private function getLargestJoltageGold(string $bank): int
    {
        $number = 11;
        $searchLength = strlen($bank) - $number--;
        $searchString = substr($bank, 0, $searchLength);
        $max1 = max(str_split($searchString));
        $startIndex = strpos($searchString, $max1) + 1;
        $searchLength = strlen(substr($bank, $startIndex)) - $number--;
        $searchString = substr($bank, $startIndex, $searchLength);
        $max2 = max(str_split($searchString));
        $startIndex += strpos($searchString, $max2) + 1;
        $searchLength = strlen(substr($bank, $startIndex)) - $number--;
        $searchString = substr($bank, $startIndex, $searchLength);
        $max3 = max(str_split($searchString));
        $startIndex += strpos($searchString, $max3) + 1;
        $searchLength = strlen(substr($bank, $startIndex)) - $number--;
        $searchString = substr($bank, $startIndex, $searchLength);
        $max4 = max(str_split($searchString));
        $startIndex += strpos($searchString, $max4) + 1;
        $searchLength = strlen(substr($bank, $startIndex)) - $number--;
        $searchString = substr($bank, $startIndex, $searchLength);
        $max5 = max(str_split($searchString));
        $startIndex += strpos($searchString, $max5) + 1;
        $searchLength = strlen(substr($bank, $startIndex)) - $number--;
        $searchString = substr($bank, $startIndex, $searchLength);
        $max6 = max(str_split($searchString));
        $startIndex += strpos($searchString, $max6) + 1;
        $searchLength = strlen(substr($bank, $startIndex)) - $number--;
        $searchString = substr($bank, $startIndex, $searchLength);
        $max7 = max(str_split($searchString));
        $startIndex += strpos($searchString, $max7) + 1;
        $searchLength = strlen(substr($bank, $startIndex)) - $number--;
        $searchString = substr($bank, $startIndex, $searchLength);
        $max8 = max(str_split($searchString));
        $startIndex += strpos($searchString, $max8) + 1;
        $searchLength = strlen(substr($bank, $startIndex)) - $number--;
        $searchString = substr($bank, $startIndex, $searchLength);
        $max9 = max(str_split($searchString));
        $startIndex += strpos($searchString, $max9) + 1;
        $searchLength = strlen(substr($bank, $startIndex)) - $number--;
        $searchString = substr($bank, $startIndex, $searchLength);
        $max10 = max(str_split($searchString));
        $startIndex += strpos($searchString, $max10) + 1;
        $searchLength = strlen(substr($bank, $startIndex)) - $number--;
        $searchString = substr($bank, $startIndex, $searchLength);
        $max11 = max(str_split($searchString));
        $startIndex += strpos($searchString, $max11) + 1;
        $searchLength = strlen(substr($bank, $startIndex)) - $number--;
        $searchString = substr($bank, $startIndex, $searchLength);
        $max12 = max(str_split($searchString));

        return (int)$max1 . $max2 . $max3 . $max4 . $max5 . $max6 . $max7 . $max8 . $max9 . $max10 . $max11 . $max12;
    }
}
