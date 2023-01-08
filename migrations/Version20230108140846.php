<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108140846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE point ADD course_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE point ADD CONSTRAINT FK_B7A5F324591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B7A5F324591CC992 ON point (course_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE point DROP FOREIGN KEY FK_B7A5F324591CC992');
        $this->addSql('DROP INDEX UNIQ_B7A5F324591CC992 ON point');
        $this->addSql('ALTER TABLE point DROP course_id');
    }
}
