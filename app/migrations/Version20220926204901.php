<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220926204901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expedition_item ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE expedition_item ADD CONSTRAINT FK_115121174584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_115121174584665A ON expedition_item (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expedition_item DROP FOREIGN KEY FK_115121174584665A');
        $this->addSql('DROP INDEX IDX_115121174584665A ON expedition_item');
        $this->addSql('ALTER TABLE expedition_item DROP product_id');
    }
}
