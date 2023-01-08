<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108135145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_level (user_id INT NOT NULL, level_id INT NOT NULL, INDEX IDX_7828374BA76ED395 (user_id), INDEX IDX_7828374B5FB14BA7 (level_id), PRIMARY KEY(user_id, level_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_level ADD CONSTRAINT FK_7828374BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_level ADD CONSTRAINT FK_7828374B5FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_level DROP FOREIGN KEY FK_7828374BA76ED395');
        $this->addSql('ALTER TABLE user_level DROP FOREIGN KEY FK_7828374B5FB14BA7');
        $this->addSql('DROP TABLE user_level');
    }
}
