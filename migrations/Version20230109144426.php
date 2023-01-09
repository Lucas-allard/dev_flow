<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230109144426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE challenge_user (challenge_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_843CD1CF98A21AC6 (challenge_id), INDEX IDX_843CD1CFA76ED395 (user_id), PRIMARY KEY(challenge_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE challenge_user ADD CONSTRAINT FK_843CD1CF98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_user ADD CONSTRAINT FK_843CD1CFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge_user DROP FOREIGN KEY FK_843CD1CF98A21AC6');
        $this->addSql('ALTER TABLE challenge_user DROP FOREIGN KEY FK_843CD1CFA76ED395');
        $this->addSql('DROP TABLE challenge_user');
    }
}
