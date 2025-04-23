<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class TaskSeed extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            ['title' => 'PHP', 'description' => 'Lab 5', 'priority_id' => 1],
        ];

        $this->table('task')
            ->insert($data)
            ->saveData();
    }
}
