<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221004095454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expedition DROP FOREIGN KEY FK_692907E4584665A');
        $this->addSql('DROP INDEX IDX_692907E4584665A ON expedition');
        $this->addSql('ALTER TABLE expedition DROP product_id, DROP packaging, DROP label, DROP quantity');
        $this->addSql('ALTER TABLE user ADD locale VARCHAR(5) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP locale');
        $this->addSql('ALTER TABLE expedition ADD product_id INT NOT NULL, ADD packaging INT NOT NULL, ADD label INT NOT NULL, ADD quantity DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE expedition ADD CONSTRAINT FK_692907E4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_692907E4584665A ON expedition (product_id)');
    }
}
