<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230112170417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge ADD category_id INT DEFAULT NULL, ADD level_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE challenge ADD CONSTRAINT FK_D709895112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE challenge ADD CONSTRAINT FK_D70989515FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('CREATE INDEX IDX_D709895112469DE2 ON challenge (category_id)');
        $this->addSql('CREATE INDEX IDX_D70989515FB14BA7 ON challenge (level_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge DROP FOREIGN KEY FK_D709895112469DE2');
        $this->addSql('ALTER TABLE challenge DROP FOREIGN KEY FK_D70989515FB14BA7');
        $this->addSql('DROP INDEX IDX_D709895112469DE2 ON challenge');
        $this->addSql('DROP INDEX IDX_D70989515FB14BA7 ON challenge');
        $this->addSql('ALTER TABLE challenge DROP category_id, DROP level_id');
    }
}
