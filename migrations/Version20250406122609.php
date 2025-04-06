<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250406122609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE user_course_view (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, course_id INT NOT NULL, viewed_at DATETIME NOT NULL, INDEX IDX_9F44BF1DA76ED395 (user_id), INDEX IDX_9F44BF1D591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_course_view ADD CONSTRAINT FK_9F44BF1DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_course_view ADD CONSTRAINT FK_9F44BF1D591CC992 FOREIGN KEY (course_id) REFERENCES course (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE user_course_view DROP FOREIGN KEY FK_9F44BF1DA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_course_view DROP FOREIGN KEY FK_9F44BF1D591CC992
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_course_view
        SQL);
    }
}
