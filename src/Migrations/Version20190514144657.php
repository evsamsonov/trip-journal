<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190514144657 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE regions (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, duration INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE couriers (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trips (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, courier_id INT DEFAULT NULL, date DATE NOT NULL, INDEX IDX_AA7370DA98260155 (region_id), INDEX IDX_AA7370DAE3D8151C (courier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trips ADD CONSTRAINT FK_AA7370DA98260155 FOREIGN KEY (region_id) REFERENCES regions (id)');
        $this->addSql('ALTER TABLE trips ADD CONSTRAINT FK_AA7370DAE3D8151C FOREIGN KEY (courier_id) REFERENCES couriers (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trips DROP FOREIGN KEY FK_AA7370DA98260155');
        $this->addSql('ALTER TABLE trips DROP FOREIGN KEY FK_AA7370DAE3D8151C');
        $this->addSql('DROP TABLE regions');
        $this->addSql('DROP TABLE couriers');
        $this->addSql('DROP TABLE trips');
    }
}
