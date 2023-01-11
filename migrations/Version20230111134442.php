<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230111134442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, color VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge_user (challenge_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_843CD1CF98A21AC6 (challenge_id), INDEX IDX_843CD1CFA76ED395 (user_id), PRIMARY KEY(challenge_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat_message (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, content LONGTEXT NOT NULL, timestamp DATETIME NOT NULL, INDEX IDX_FAB3FC16A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, level_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, points INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_169E6FB912469DE2 (category_id), INDEX IDX_169E6FB95FB14BA7 (level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE level (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, required_point INT NOT NULL, color VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mentor (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_801562DEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mentorship (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, mentor_id INT NOT NULL, project_id INT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, INDEX IDX_ADE55FF4CB944F1A (student_id), INDEX IDX_ADE55FF4DB403044 (mentor_id), INDEX IDX_ADE55FF4166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, mentorship_id INT NOT NULL, project_id INT NOT NULL, user_id INT NOT NULL, amount DOUBLE PRECISION DEFAULT NULL, date DATETIME NOT NULL, method VARCHAR(255) NOT NULL, INDEX IDX_6D28840D39CF49FD (mentorship_id), INDEX IDX_6D28840D166D1F9C (project_id), INDEX IDX_6D28840DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, mentor_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, deadline DATETIME NOT NULL, INDEX IDX_2FB3D0EEDB403044 (mentor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_tracking (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, student_id INT NOT NULL, completion_date DATETIME NOT NULL, completion_status VARCHAR(255) NOT NULL, INDEX IDX_9532E9C7166D1F9C (project_id), INDEX IDX_9532E9C7CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_B723AF33A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trophy (id INT AUTO_INCREMENT NOT NULL, challenge_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, date DATETIME NOT NULL, required_point INT DEFAULT NULL, UNIQUE INDEX UNIQ_112AFAE998A21AC6 (challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, level_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) DEFAULT NULL, full_name VARCHAR(255) DEFAULT NULL, profil_picture VARCHAR(255) DEFAULT NULL, google_id VARCHAR(255) DEFAULT NULL, is_logged TINYINT(1) DEFAULT NULL, last_activity DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, profil_color VARCHAR(255) DEFAULT NULL, points INT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6495FB14BA7 (level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_trophy (user_id INT NOT NULL, trophy_id INT NOT NULL, INDEX IDX_7478E1D4A76ED395 (user_id), INDEX IDX_7478E1D4F59AEEEF (trophy_id), PRIMARY KEY(user_id, trophy_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_course (user_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_73CC7484A76ED395 (user_id), INDEX IDX_73CC7484591CC992 (course_id), PRIMARY KEY(user_id, course_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE challenge_user ADD CONSTRAINT FK_843CD1CF98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_user ADD CONSTRAINT FK_843CD1CFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chat_message ADD CONSTRAINT FK_FAB3FC16A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB95FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE mentor ADD CONSTRAINT FK_801562DEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE mentorship ADD CONSTRAINT FK_ADE55FF4CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE mentorship ADD CONSTRAINT FK_ADE55FF4DB403044 FOREIGN KEY (mentor_id) REFERENCES mentor (id)');
        $this->addSql('ALTER TABLE mentorship ADD CONSTRAINT FK_ADE55FF4166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D39CF49FD FOREIGN KEY (mentorship_id) REFERENCES mentorship (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEDB403044 FOREIGN KEY (mentor_id) REFERENCES mentor (id)');
        $this->addSql('ALTER TABLE project_tracking ADD CONSTRAINT FK_9532E9C7166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE project_tracking ADD CONSTRAINT FK_9532E9C7CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trophy ADD CONSTRAINT FK_112AFAE998A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE user_trophy ADD CONSTRAINT FK_7478E1D4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_trophy ADD CONSTRAINT FK_7478E1D4F59AEEEF FOREIGN KEY (trophy_id) REFERENCES trophy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_course ADD CONSTRAINT FK_73CC7484A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_course ADD CONSTRAINT FK_73CC7484591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge_user DROP FOREIGN KEY FK_843CD1CF98A21AC6');
        $this->addSql('ALTER TABLE challenge_user DROP FOREIGN KEY FK_843CD1CFA76ED395');
        $this->addSql('ALTER TABLE chat_message DROP FOREIGN KEY FK_FAB3FC16A76ED395');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB912469DE2');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB95FB14BA7');
        $this->addSql('ALTER TABLE mentor DROP FOREIGN KEY FK_801562DEA76ED395');
        $this->addSql('ALTER TABLE mentorship DROP FOREIGN KEY FK_ADE55FF4CB944F1A');
        $this->addSql('ALTER TABLE mentorship DROP FOREIGN KEY FK_ADE55FF4DB403044');
        $this->addSql('ALTER TABLE mentorship DROP FOREIGN KEY FK_ADE55FF4166D1F9C');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D39CF49FD');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D166D1F9C');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DA76ED395');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEDB403044');
        $this->addSql('ALTER TABLE project_tracking DROP FOREIGN KEY FK_9532E9C7166D1F9C');
        $this->addSql('ALTER TABLE project_tracking DROP FOREIGN KEY FK_9532E9C7CB944F1A');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33A76ED395');
        $this->addSql('ALTER TABLE trophy DROP FOREIGN KEY FK_112AFAE998A21AC6');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495FB14BA7');
        $this->addSql('ALTER TABLE user_trophy DROP FOREIGN KEY FK_7478E1D4A76ED395');
        $this->addSql('ALTER TABLE user_trophy DROP FOREIGN KEY FK_7478E1D4F59AEEEF');
        $this->addSql('ALTER TABLE user_course DROP FOREIGN KEY FK_73CC7484A76ED395');
        $this->addSql('ALTER TABLE user_course DROP FOREIGN KEY FK_73CC7484591CC992');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE challenge');
        $this->addSql('DROP TABLE challenge_user');
        $this->addSql('DROP TABLE chat_message');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE level');
        $this->addSql('DROP TABLE mentor');
        $this->addSql('DROP TABLE mentorship');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_tracking');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE trophy');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_trophy');
        $this->addSql('DROP TABLE user_course');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
