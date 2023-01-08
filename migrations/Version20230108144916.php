<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108144916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, mentorship_id INT NOT NULL, project_id INT NOT NULL, amount DOUBLE PRECISION DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_6D28840DA76ED395 (user_id), INDEX IDX_6D28840D39CF49FD (mentorship_id), INDEX IDX_6D28840D166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D39CF49FD FOREIGN KEY (mentorship_id) REFERENCES mentorship (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DA76ED395');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D39CF49FD');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D166D1F9C');
        $this->addSql('DROP TABLE payment');
    }
}
