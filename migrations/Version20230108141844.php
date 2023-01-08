<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108141844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge ADD trophy_id INT NOT NULL');
        $this->addSql('ALTER TABLE challenge ADD CONSTRAINT FK_D7098951F59AEEEF FOREIGN KEY (trophy_id) REFERENCES trophy (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D7098951F59AEEEF ON challenge (trophy_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge DROP FOREIGN KEY FK_D7098951F59AEEEF');
        $this->addSql('DROP INDEX UNIQ_D7098951F59AEEEF ON challenge');
        $this->addSql('ALTER TABLE challenge DROP trophy_id');
    }
}
