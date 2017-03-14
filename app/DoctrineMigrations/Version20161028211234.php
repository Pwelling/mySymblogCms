<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20161028211234 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        if (!$schema->hasTable('com_comments')) {
            $table = $schema->createTable('com_comments');
            $table->addColumn('com_id', 'integer', ['autoincrement' => true]);
            $table->addColumn('com_blog_id', 'integer', ['notnull' => false]);
            $table->addColumn('com_user', 'string');
            $table->addColumn('com_comment', 'text');
            $table->addColumn('com_approved', 'smallint', ['default' => 0]);
            $table->addColumn('com_created', 'datetime');
            $table->addColumn('com_updated', 'datetime', ['notnull' => false]);
            $table->setPrimaryKey(['com_id']);
            $table->addIndex(['com_blog_id'], 'IDX_547B524DE4FB3858');
            if ($schema->hasTable('blo_blog')) {
                $table->addForeignKeyConstraint('blo_blog', ['com_blog_id'], ['blo_id'], [], 'FK_547B524DE4FB3858');
            }
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        if ($schema->hasTable('com_comments')) {
//            $table = $schema->getTable('com_comments');
//            $table->removeForeignKey('FK_547B524DE4FB3858');
            $schema->dropTable('com_comments');
        }
    }
}
