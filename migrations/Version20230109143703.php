<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230109143703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trophy ADD challenge_id INT DEFAULT NULL, ADD required_point INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trophy ADD CONSTRAINT FK_112AFAE998A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_112AFAE998A21AC6 ON trophy (challenge_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trophy DROP FOREIGN KEY FK_112AFAE998A21AC6');
        $this->addSql('DROP INDEX UNIQ_112AFAE998A21AC6 ON trophy');
        $this->addSql('ALTER TABLE trophy DROP challenge_id, DROP required_point');
    }
}
