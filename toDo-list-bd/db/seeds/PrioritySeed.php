<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class PrioritySeed extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            ['name' => 'Urgent'],
            ['name' => 'High'],
            ['name' => 'Low']
        ];
        $this->table('priority')
            ->insert($data)
            ->saveData();
    }
}
