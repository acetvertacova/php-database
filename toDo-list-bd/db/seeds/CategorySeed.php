<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class CategorySeed extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            ['name' => 'Education', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Professional', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Financial', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Personal', 'created_at' => date('Y-m-d H:i:s')]
        ];
        $this->table('category')
            ->insert($data)
            ->saveData();
    }
}
