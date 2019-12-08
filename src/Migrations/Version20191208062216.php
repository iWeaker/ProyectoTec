<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191208062216 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post_entity CHANGE image_post image_post VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE heart_entity CHANGE post_heart post_id_id INT NOT NULL, CHANGE user_heart user_heart_id_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE heart_entity ADD CONSTRAINT FK_D6158101E85F12B8 FOREIGN KEY (post_id_id) REFERENCES post_entity (id)');
        $this->addSql('ALTER TABLE heart_entity ADD CONSTRAINT FK_D6158101E6B1E46A FOREIGN KEY (user_heart_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D6158101E85F12B8 ON heart_entity (post_id_id)');
        $this->addSql('CREATE INDEX IDX_D6158101E6B1E46A ON heart_entity (user_heart_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE heart_entity DROP FOREIGN KEY FK_D6158101E85F12B8');
        $this->addSql('ALTER TABLE heart_entity DROP FOREIGN KEY FK_D6158101E6B1E46A');
        $this->addSql('DROP INDEX IDX_D6158101E85F12B8 ON heart_entity');
        $this->addSql('DROP INDEX IDX_D6158101E6B1E46A ON heart_entity');
        $this->addSql('ALTER TABLE heart_entity CHANGE user_heart_id_id user_heart VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE post_id_id post_heart INT NOT NULL');
        $this->addSql('ALTER TABLE post_entity CHANGE image_post image_post VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
