<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230109152605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_trophy (user_id INT NOT NULL, trophy_id INT NOT NULL, INDEX IDX_7478E1D4A76ED395 (user_id), INDEX IDX_7478E1D4F59AEEEF (trophy_id), PRIMARY KEY(user_id, trophy_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_trophy ADD CONSTRAINT FK_7478E1D4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_trophy ADD CONSTRAINT FK_7478E1D4F59AEEEF FOREIGN KEY (trophy_id) REFERENCES trophy (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_trophy DROP FOREIGN KEY FK_7478E1D4A76ED395');
        $this->addSql('ALTER TABLE user_trophy DROP FOREIGN KEY FK_7478E1D4F59AEEEF');
        $this->addSql('DROP TABLE user_trophy');
    }
}
