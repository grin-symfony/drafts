<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240617181250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_passport DROP FOREIGN KEY FK_7E12049F4584665A');
        $this->addSql('DROP INDEX UNIQ_7E12049F4584665A ON product_passport');
        $this->addSql('ALTER TABLE product_passport DROP product_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_passport ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_passport ADD CONSTRAINT FK_7E12049F4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7E12049F4584665A ON product_passport (product_id)');
    }
}
