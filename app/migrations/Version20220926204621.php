<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220926204621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('CREATE TABLE expedition (id INT AUTO_INCREMENT NOT NULL, expedition_date DATETIME NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expedition_item (id INT AUTO_INCREMENT NOT NULL, expedition_id INT NOT NULL, INDEX IDX_11512117576EF81E (expedition_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE expedition_item ADD CONSTRAINT FK_11512117576EF81E FOREIGN KEY (expedition_id) REFERENCES expedition (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expedition_item DROP FOREIGN KEY FK_11512117576EF81E');
        $this->addSql('DROP TABLE expedition');
        $this->addSql('DROP TABLE expedition_item');
    }
}
