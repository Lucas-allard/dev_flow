<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230204090648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media_object DROP content_url');
        $this->addSql('ALTER TABLE user ADD profil_picture_id INT DEFAULT NULL, DROP profil_picture');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D583E641 FOREIGN KEY (profil_picture_id) REFERENCES media_object (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D583E641 ON user (profil_picture_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media_object ADD content_url VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D583E641');
        $this->addSql('DROP INDEX IDX_8D93D649D583E641 ON user');
        $this->addSql('ALTER TABLE user ADD profil_picture VARCHAR(255) DEFAULT NULL, DROP profil_picture_id');
    }
}
