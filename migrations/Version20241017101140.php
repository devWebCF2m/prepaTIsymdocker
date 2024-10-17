<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241017101140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_section (article_id INT UNSIGNED NOT NULL, section_id INT UNSIGNED NOT NULL, INDEX IDX_C0A13E587294869C (article_id), INDEX IDX_C0A13E58D823E37A (section_id), PRIMARY KEY(article_id, section_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_section ADD CONSTRAINT FK_C0A13E587294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_section ADD CONSTRAINT FK_C0A13E58D823E37A FOREIGN KEY (section_id) REFERENCES section (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_section DROP FOREIGN KEY FK_C0A13E587294869C');
        $this->addSql('ALTER TABLE article_section DROP FOREIGN KEY FK_C0A13E58D823E37A');
        $this->addSql('DROP TABLE article_section');
    }
}
