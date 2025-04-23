<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class StepCreateMigration extends AbstractMigration
{
    public function change(): void
    {
        $this->table('step')
            ->addColumn('description', 'text', ['limit' => 100])
            ->addColumn('order', 'integer')
            ->addColumn('task_id', 'integer')
            ->addForeignKey('task_id', 'task', 'id', ['delete' => 'SET_NULL'])
            ->create();
    }
}
