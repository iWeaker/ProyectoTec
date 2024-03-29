<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191215001029 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE files_post_group_entity (id INT AUTO_INCREMENT NOT NULL, post_group_id_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, INDEX IDX_22E64AEDC3283F1F (post_group_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_post_entity (id INT AUTO_INCREMENT NOT NULL, groupid_id INT NOT NULL, content_post LONGTEXT NOT NULL, INDEX IDX_1BB2BFCCB3BB53C (groupid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE files_post_group_entity ADD CONSTRAINT FK_22E64AEDC3283F1F FOREIGN KEY (post_group_id_id) REFERENCES group_post_entity (id)');
        $this->addSql('ALTER TABLE group_post_entity ADD CONSTRAINT FK_1BB2BFCCB3BB53C FOREIGN KEY (groupid_id) REFERENCES group_entity (id)');
        $this->addSql('ALTER TABLE post_entity CHANGE image_post image_post VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE files_post_group_entity DROP FOREIGN KEY FK_22E64AEDC3283F1F');
        $this->addSql('DROP TABLE files_post_group_entity');
        $this->addSql('DROP TABLE group_post_entity');
        $this->addSql('ALTER TABLE post_entity CHANGE image_post image_post VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
