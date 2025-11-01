<?php

namespace App\Solutions\Traits;

trait GraphHelpers
{
    protected function dijkstra(array $graph, $start, $end = null): array
    {
        $distances = [$start => 0];
        $visited = [];
        $queue = new \SplPriorityQueue();
        $queue->insert($start, 0);

        while (!$queue->isEmpty()) {
            $current = $queue->extract();

            if (isset($visited[$current])) continue;
            $visited[$current] = true;

            if ($end !== null && $current === $end) break;

            foreach ($graph[$current] ?? [] as $neighbor => $weight) {
                $newDist = $distances[$current] + $weight;
                
                if (!isset($distances[$neighbor]) || $newDist < $distances[$neighbor]) {
                    $distances[$neighbor] = $newDist;
                    $queue->insert($neighbor, -$newDist);
                }
            }
        }

        return $distances;
    }

    protected function bfs($start, callable $getNeighbors, callable $isGoal = null): array
    {
        $queue = [[$start, 0]];
        $visited = [$start => 0];
        $index = 0;

        while ($index < count($queue)) {
            [$current, $dist] = $queue[$index++];

            if ($isGoal && $isGoal($current)) {
                return ['found' => $current, 'distance' => $dist, 'visited' => $visited];
            }

            foreach ($getNeighbors($current) as $neighbor) {
                if (!isset($visited[$neighbor])) {
                    $visited[$neighbor] = $dist + 1;
                    $queue[] = [$neighbor, $dist + 1];
                }
            }
        }

        return ['found' => null, 'visited' => $visited];
    }
}
