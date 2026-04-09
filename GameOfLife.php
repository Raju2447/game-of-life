<?php

class GameOfLife
{
    private $rows;
    private $cols;
    private $board = [];

    public function __construct($rows = 25, $cols = 25)
    {
        $this->rows = $rows;
        $this->cols = $cols;

        $this->createBoard();
        $this->placeGlider();
    }

    private function createBoard()
    {
        for ($i = 0; $i < $this->rows; $i++) {
            $this->board[$i] = array_fill(0, $this->cols, 0);
        }
    }

    private function placeGlider()
    {
        $midRow = floor($this->rows / 2);
        $midCol = floor($this->cols / 2);

        $glider = [
            [0,1,0],
            [0,0,1],
            [1,1,1]
        ];

        foreach ($glider as $r => $row) {
            foreach ($row as $c => $value) {
                $this->board[$midRow + $r - 1][$midCol + $c - 1] = $value;
            }
        }
    }

    public function start($steps = 10)
    {
        for ($i = 1; $i <= $steps; $i++) {

            echo "Generation $i\n";
            $this->display();

            $this->update();
            echo "\n";
        }
    }

    private function update()
    {
        $next = [];

        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {

                $live = $this->getLiveNeighbors($i, $j);

                if ($this->board[$i][$j] == 1) {
                    $next[$i][$j] = ($live == 2 || $live == 3) ? 1 : 0;
                } else {
                    $next[$i][$j] = ($live == 3) ? 1 : 0;
                }
            }
        }

        $this->board = $next;
    }

    private function getLiveNeighbors($row, $col)
    {
        $count = 0;

        for ($i = -1; $i <= 1; $i++) {
            for ($j = -1; $j <= 1; $j++) {

                if ($i == 0 && $j == 0) continue;

                $r = $row + $i;
                $c = $col + $j;

                if (isset($this->board[$r][$c])) {
                    $count += $this->board[$r][$c];
                }
            }
        }

        return $count;
    }

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

$game = new GameOfLife(25,25);
$game->start(20);