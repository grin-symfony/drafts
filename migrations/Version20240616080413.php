<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240616080413 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_passport (id INT AUTO_INCREMENT NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_552F8A08E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user ADD passport_id INT NOT NULL, DROP name, DROP email');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649ABF410D0 FOREIGN KEY (passport_id) REFERENCES user_passport (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649ABF410D0 ON user (passport_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_passport');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649ABF410D0');
        $this->addSql('DROP INDEX UNIQ_8D93D649ABF410D0 ON user');
        $this->addSql('ALTER TABLE user ADD name VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, DROP passport_id');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }
}
