<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161226202134 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        if ($schema->hasTable('blo_blog')) {
            $table = $schema->getTable('blo_blog');
            $table->dropColumn('blo_image');
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        if ($schema->hasTable('blo_blog')) {
            $table = $schema->getTable('blo_blog');
            if (!$table->hasColumn('blo_image')) {
                $table->addColumn('blo_image', 'string', ['length' => 20]);
            }
        }
    }
}
