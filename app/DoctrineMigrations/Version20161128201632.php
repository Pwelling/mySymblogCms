<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20161128201632 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        if ($schema->hasTable('blo_blog')) {
            $table = $schema->getTable('blo_blog');
            if (!$table->hasColumn('blo_slug')) {
                $table->addColumn('blo_slug', 'string', ['notnull' => false]);
            }
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        if ($schema->hasTable('blo_blog')) {
            $table = $schema->getTable('blo_blog');
            if ($table->hasColumn('blo_slug')) {
                $table->dropColumn('blo_slug');
            }
        }
    }
}
