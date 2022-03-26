<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220326193803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job_ads ADD recruiters_id INT NOT NULL');
        $this->addSql('ALTER TABLE job_ads ADD CONSTRAINT FK_BA1C65B18B1C6ED FOREIGN KEY (recruiters_id) REFERENCES recruiters (id)');
        $this->addSql('CREATE INDEX IDX_BA1C65B18B1C6ED ON job_ads (recruiters_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job_ads DROP FOREIGN KEY FK_BA1C65B18B1C6ED');
        $this->addSql('DROP INDEX IDX_BA1C65B18B1C6ED ON job_ads');
        $this->addSql('ALTER TABLE job_ads DROP recruiters_id');
    }
}
