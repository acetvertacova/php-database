<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class PriorityCreateMigration extends AbstractMigration
{
    public function change(): void
    {
        $this->table('priority')
            ->addColumn('name', 'string')
            ->create();
    }
}
