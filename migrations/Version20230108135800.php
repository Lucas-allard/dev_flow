<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108135800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courses ADD category_id INT NOT NULL, ADD level_id INT NOT NULL');
        $this->addSql('ALTER TABLE courses ADD CONSTRAINT FK_A9A55A4C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE courses ADD CONSTRAINT FK_A9A55A4C5FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('CREATE INDEX IDX_A9A55A4C12469DE2 ON courses (category_id)');
        $this->addSql('CREATE INDEX IDX_A9A55A4C5FB14BA7 ON courses (level_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courses DROP FOREIGN KEY FK_A9A55A4C12469DE2');
        $this->addSql('ALTER TABLE courses DROP FOREIGN KEY FK_A9A55A4C5FB14BA7');
        $this->addSql('DROP INDEX IDX_A9A55A4C12469DE2 ON courses');
        $this->addSql('DROP INDEX IDX_A9A55A4C5FB14BA7 ON courses');
        $this->addSql('ALTER TABLE courses DROP category_id, DROP level_id');
    }
}
