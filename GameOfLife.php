<?php

class GameOfLife
{
    private $rows;
    private $cols;
    private $board = [];
    // Initialize grid size and create starting board
    public function __construct($rows = 25, $cols = 25)
    {
        $this->rows = $rows;
        $this->cols = $cols;

        $this->createBoard();
        $this->placeGlider();
    }
    // Create empty grid and mark all cells as dead
    private function createBoard()
    {
        for ($i = 0; $i < $this->rows; $i++) {
            $this->board[$i] = array_fill(0, $this->cols, 0);
        }
    }
    // Place initial glider pattern in the middle of grid
    private function placeGlider()
    {
        $midRow = floor($this->rows / 2);
        $midCol = floor($this->cols / 2);
        // Glider starting pattern
        $glider = [
            [0,1,0],
            [0,0,1],
            [1,1,1]
        ];
        // Insert glider into board
        foreach ($glider as $r => $row) {
            foreach ($row as $c => $value) {
                $this->board[$midRow + $r - 1][$midCol + $c - 1] = $value;
            }
        }
    }
    // Run given number of generations
    public function start($steps = 10)
    {
        for ($i = 1; $i <= $steps; $i++) {
            echo "Generation $i\n";
            $this->display();
            $this->update();
            echo "\n";
        }
    }
    // Update board based on Game of Life rules
    private function update()
    {
        $next = [];

        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                // Count live neighbors
                $live = $this->getLiveNeighbors($i, $j);
                // Apply game rules
                if ($this->board[$i][$j] == 1) {
                    $next[$i][$j] = ($live == 2 || $live == 3) ? 1 : 0;
                } else {
                    $next[$i][$j] = ($live == 3) ? 1 : 0;
                }
            }
        }
        $this->board = $next;
    }
    // Count number of live neighbors around cell
    private function getLiveNeighbors($row, $col)
    {
        $count = 0;
        // Check all 8 directions
        for ($i = -1; $i <= 1; $i++) {
            for ($j = -1; $j <= 1; $j++) {
                // Skip current cell
                if ($i == 0 && $j == 0) continue;
                $r = $row + $i;
                $c = $col + $j;
                // Check if neighbor exists
                if (isset($this->board[$r][$c])) {
                    $count += $this->board[$r][$c];
                }
            }
        }
        return $count;
    }
    // Print board 
    private function display()
    {
        foreach ($this->board as $row) {
            foreach ($row as $cell) {
                echo $cell ? "X " : ". ";
            }
            echo "\n";
        }
    }
}
// Create 25x25 game board
$game = new GameOfLife(25,25);
// Run 20 generations
$game->start(20);