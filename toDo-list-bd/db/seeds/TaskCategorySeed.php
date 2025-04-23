<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class TaskCategorySeed extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            ['task_id' => 1,  'category_id' => 1],
            ['task_id' => 1,  'category_id' => 2],
        ];

        $this->table('task_category')
            ->insert($data)
            ->saveData();
    }
}
