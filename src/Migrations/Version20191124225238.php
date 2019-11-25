<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191124225238 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE post_entity (id INT AUTO_INCREMENT NOT NULL, user_post_id VARCHAR(255) NOT NULL, content_post LONGTEXT DEFAULT NULL, image_post VARCHAR(255) DEFAULT NULL, date_post DATETIME NOT NULL, INDEX IDX_3E0AA00D13841D26 (user_post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id VARCHAR(255) NOT NULL, user VARCHAR(255) NOT NULL, last_m VARCHAR(255) NOT NULL, last_f VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, image VARCHAR(100) NOT NULL, cover VARCHAR(100) NOT NULL, date_register DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post_entity ADD CONSTRAINT FK_3E0AA00D13841D26 FOREIGN KEY (user_post_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post_entity DROP FOREIGN KEY FK_3E0AA00D13841D26');
        $this->addSql('DROP TABLE post_entity');
        $this->addSql('DROP TABLE user');
    }
}
