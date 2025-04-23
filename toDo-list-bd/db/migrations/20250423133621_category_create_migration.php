<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CategoryCreateMigration extends AbstractMigration
{
    public function change(): void
    {
        $this->table('category')
            ->addColumn('name', 'string')
            ->create();
    }
}
