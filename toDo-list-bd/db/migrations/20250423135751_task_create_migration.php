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
            ->addColumn('priority_id', 'integer')
            ->addForeignKey('priority_id', 'priority', 'id', ['delete' => 'SET_NULL'])
            ->create();
    }
}
