<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class TaskCreateMigration extends AbstractMigration
{
    public function change(): void
    {
        $this->table('task')
            ->addColumn('title', 'string', ['limit' => 20])
            ->addColumn('description', 'text', ['limit' => 200])
            ->addColumn('priority', 'text', ['limit' => 50])
            ->addColumn('steps', 'text', ['limit' => 1000])
            ->addColumn('category_id', 'integer',)
            ->addColumn('created_at', 'datetime')
            ->addForeignKey('category_id', 'category', 'id', ['delete' => 'SET_NULL'])
            ->create();
    }
}
