<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108164430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE point_user (point_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_413312BC028CEA2 (point_id), INDEX IDX_413312BA76ED395 (user_id), PRIMARY KEY(point_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE point_user ADD CONSTRAINT FK_413312BC028CEA2 FOREIGN KEY (point_id) REFERENCES point (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE point_user ADD CONSTRAINT FK_413312BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE point DROP FOREIGN KEY FK_B7A5F324A76ED395');
        $this->addSql('DROP INDEX IDX_B7A5F324A76ED395 ON point');
        $this->addSql('ALTER TABLE point DROP user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE point_user DROP FOREIGN KEY FK_413312BC028CEA2');
        $this->addSql('ALTER TABLE point_user DROP FOREIGN KEY FK_413312BA76ED395');
        $this->addSql('DROP TABLE point_user');
        $this->addSql('ALTER TABLE point ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE point ADD CONSTRAINT FK_B7A5F324A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B7A5F324A76ED395 ON point (user_id)');
    }
}
