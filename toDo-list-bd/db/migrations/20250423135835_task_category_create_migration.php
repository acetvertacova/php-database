<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class TaskCategoryCreateMigration extends AbstractMigration
{
    public function change(): void
    {
        $this->table('task_category')
            ->addColumn('task_id', 'integer')
            ->addColumn('category_id', 'integer')
            ->addForeignKey('task_id', 'task', 'id', ['delete' => 'SET_NULL'])
            ->addForeignKey('category_id', 'category', 'id', ['delete' => 'SET_NULL'])
            ->create();
    }
}
