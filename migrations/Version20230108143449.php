<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108143449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mentorship (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, mentor_id INT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, INDEX IDX_ADE55FF4CB944F1A (student_id), INDEX IDX_ADE55FF4DB403044 (mentor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mentorship ADD CONSTRAINT FK_ADE55FF4CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE mentorship ADD CONSTRAINT FK_ADE55FF4DB403044 FOREIGN KEY (mentor_id) REFERENCES mentor (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mentorship DROP FOREIGN KEY FK_ADE55FF4CB944F1A');
        $this->addSql('ALTER TABLE mentorship DROP FOREIGN KEY FK_ADE55FF4DB403044');
        $this->addSql('DROP TABLE mentorship');
    }
}
