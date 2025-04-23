<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class StepSeed extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            ['description' => 'connect db', 'order' => 1, 'task_id' => 1],
            ['description' => 'migrations', 'order' => 2, 'task_id' => 1]
        ];

        $this->table('step')
            ->insert($data)
            ->saveData();
    }
}
