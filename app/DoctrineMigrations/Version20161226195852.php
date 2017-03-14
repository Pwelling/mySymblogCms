<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161226195852 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        if (!$schema->hasTable('fos_user')) {
            $table = $schema->createTable('fos_user');
            $table->addColumn('id', 'integer', ['autoincrement' => true]);
            $table->addColumn('username', 'string', ['length' => 180]);
            $table->addColumn('username_canonical', 'string', ['length' => 180]);
            $table->addColumn('email', 'string', ['length' => 180]);
            $table->addColumn('email_canonical', 'string', ['length' => 180]);
            $table->addColumn('enabled', 'boolean');
            $table->addColumn('salt', 'string', ['notnull' => false]);
            $table->addColumn('password', 'string');
            $table->addColumn('last_login', 'datetime', ['notnull' => false]);
            $table->addColumn('confirmation_token', 'string', ['notnull' => false]);
            $table->addColumn('password_requested_at', 'datetime', ['notnull' => false]);
            $table->addColumn('roles', 'text', ['comment' => '(DC2Type:array)']);
            $table->addUniqueIndex(['username_canonical'], 'UNIQ_957A647992FC23A8');
            $table->addUniqueIndex(['email_canonical'], 'UNIQ_957A6479A0D96FBF');
            $table->addUniqueIndex(['confirmation_token'], 'UNIQ_957A6479C05FB297');
            $table->setPrimaryKey(['id']);
        }
        /*
         CREATE TABLE fos_user (
         roles LONGTEXT NOT NULL COMMENT '(DC2Type:array)',
         UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical),
         UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical),
         UNIQUE INDEX UNIQ_957A6479C05FB297 (confirmation_token),
        PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

         */
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        if ($schema->hasTable('fos_user')) {
            $schema->dropTable('fos_user');
        }
    }
}
