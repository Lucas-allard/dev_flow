<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108144253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_tracking (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, student_id INT NOT NULL, completion_date DATETIME NOT NULL, INDEX IDX_9532E9C7166D1F9C (project_id), INDEX IDX_9532E9C7CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project_tracking ADD CONSTRAINT FK_9532E9C7166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE project_tracking ADD CONSTRAINT FK_9532E9C7CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_tracking DROP FOREIGN KEY FK_9532E9C7166D1F9C');
        $this->addSql('ALTER TABLE project_tracking DROP FOREIGN KEY FK_9532E9C7CB944F1A');
        $this->addSql('DROP TABLE project_tracking');
    }
}
