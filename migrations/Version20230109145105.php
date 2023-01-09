<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230109145105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_point (user_id INT NOT NULL, point_id INT NOT NULL, INDEX IDX_5567087CA76ED395 (user_id), INDEX IDX_5567087CC028CEA2 (point_id), PRIMARY KEY(user_id, point_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_point ADD CONSTRAINT FK_5567087CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_point ADD CONSTRAINT FK_5567087CC028CEA2 FOREIGN KEY (point_id) REFERENCES point (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_point DROP FOREIGN KEY FK_5567087CA76ED395');
        $this->addSql('ALTER TABLE user_point DROP FOREIGN KEY FK_5567087CC028CEA2');
        $this->addSql('DROP TABLE user_point');
    }
}
