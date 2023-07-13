<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230713082413 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE en_word ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE en_word ADD CONSTRAINT FK_2EEA2001A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_2EEA2001A76ED395 ON en_word (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE en_word DROP FOREIGN KEY FK_2EEA2001A76ED395');
        $this->addSql('DROP INDEX IDX_2EEA2001A76ED395 ON en_word');
        $this->addSql('ALTER TABLE en_word DROP user_id');
    }
}
