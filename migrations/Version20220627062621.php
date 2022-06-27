<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220627062621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A8F93B6FC');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A8F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A8F93B6FC');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A8F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
