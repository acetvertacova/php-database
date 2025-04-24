<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class TaskSeed extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            ['title' => 'PHP', 'description' => 'Lab 5', 'priority' => 'High', 'steps' => 'migration', 'category_id' => 1, 'created_at' => date('Y-m-d H:i:s')],
        ];

        $this->table('task')
            ->insert($data)
            ->saveData();
    }
}
