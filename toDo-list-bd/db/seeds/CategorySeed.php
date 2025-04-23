<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class CategorySeed extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            ['name' => 'Education'],
            ['name' => 'Professional'],
            ['name' => 'Financial'],
            ['name' => 'Personal']
        ];
        $this->table('category')
            ->insert($data)
            ->saveData();
    }
}
