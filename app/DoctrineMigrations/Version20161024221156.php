<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20161024221156 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        if (!$schema->hasTable('blo_blog')) {
            $table = $schema->createTable('blo_blog');
            $table->addColumn('blo_id', 'integer', ['autoincrement' => true]);
            $table->addColumn('blo_title', 'string', ['length' => 255]);
            $table->addColumn('blo_author', 'string', ['length' => 100]);
            $table->addColumn('blo_blog', 'text');
            $table->addColumn('blo_image', 'string', ['length' => 20]);
            $table->addColumn('blo_tags', 'text');
            $table->addColumn('blo_created', 'datetime');
            $table->addColumn('blo_updated', 'datetime', ['notnull' => false]);
            $table->setPrimaryKey(['blo_id']);
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        if ($schema->hasTable('blo_blog')) {
            $schema->dropTable('blo_blog');
        }
    }
}
