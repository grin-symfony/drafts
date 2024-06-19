<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240619013051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE food_product (expires_at DATETIME(6) NOT NULL, id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE furniture_product (color VARCHAR(255) NOT NULL, id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price VARCHAR(255) NOT NULL, is_public TINYINT(1) DEFAULT 0 NOT NULL, updated_at DATETIME(6) DEFAULT NULL, created_at DATETIME(6) NOT NULL, passport_id INT DEFAULT NULL, user_id BINARY(16) DEFAULT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D34A04ADABF410D0 (passport_id), INDEX IDX_D34A04ADA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE product_passport (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, category JSON NOT NULL, updated_at DATETIME(6) DEFAULT NULL, created_at DATETIME(6) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE toy_product (for_kids_more_than INT NOT NULL, id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id BINARY(16) NOT NULL, passport_id INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649ABF410D0 (passport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user_passport (id INT AUTO_INCREMENT NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, updated_at DATETIME(6) DEFAULT NULL, created_at DATETIME(6) NOT NULL, first_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_552F8A08E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME(6) NOT NULL, available_at DATETIME(6) NOT NULL, delivered_at DATETIME(6) DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE food_product ADD CONSTRAINT FK_9CD5D895BF396750 FOREIGN KEY (id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE furniture_product ADD CONSTRAINT FK_56AAF15BBF396750 FOREIGN KEY (id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADABF410D0 FOREIGN KEY (passport_id) REFERENCES product_passport (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE toy_product ADD CONSTRAINT FK_9BB08057BF396750 FOREIGN KEY (id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649ABF410D0 FOREIGN KEY (passport_id) REFERENCES user_passport (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE food_product DROP FOREIGN KEY FK_9CD5D895BF396750');
        $this->addSql('ALTER TABLE furniture_product DROP FOREIGN KEY FK_56AAF15BBF396750');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADABF410D0');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA76ED395');
        $this->addSql('ALTER TABLE toy_product DROP FOREIGN KEY FK_9BB08057BF396750');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649ABF410D0');
        $this->addSql('DROP TABLE food_product');
        $this->addSql('DROP TABLE furniture_product');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_passport');
        $this->addSql('DROP TABLE toy_product');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_passport');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
