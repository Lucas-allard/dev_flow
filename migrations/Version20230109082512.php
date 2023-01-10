<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230109082512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge DROP FOREIGN KEY FK_D7098951C028CEA2');
        $this->addSql('ALTER TABLE challenge DROP FOREIGN KEY FK_D7098951F59AEEEF');
        $this->addSql('DROP INDEX UNIQ_D7098951C028CEA2 ON challenge');
        $this->addSql('DROP INDEX UNIQ_D7098951F59AEEEF ON challenge');
        $this->addSql('ALTER TABLE challenge DROP point_id, DROP trophy_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge ADD point_id INT NOT NULL, ADD trophy_id INT NOT NULL');
        $this->addSql('ALTER TABLE challenge ADD CONSTRAINT FK_D7098951C028CEA2 FOREIGN KEY (point_id) REFERENCES point (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE challenge ADD CONSTRAINT FK_D7098951F59AEEEF FOREIGN KEY (trophy_id) REFERENCES trophy (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D7098951C028CEA2 ON challenge (point_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D7098951F59AEEEF ON challenge (trophy_id)');
    }
}
