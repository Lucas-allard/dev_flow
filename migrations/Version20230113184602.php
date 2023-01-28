<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230113184602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trophy ADD required_message INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_course DROP has_read, DROP has_liked');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trophy DROP required_message');
        $this->addSql('ALTER TABLE user_course ADD has_read TINYINT(1) NOT NULL, ADD has_liked TINYINT(1) NOT NULL');
    }
}
