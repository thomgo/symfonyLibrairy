<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190212105914 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE librairy (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD librairy_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498E44FC3E FOREIGN KEY (librairy_id) REFERENCES librairy (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6498E44FC3E ON user (librairy_id)');
        $this->addSql('ALTER TABLE book ADD librairy_id INT NOT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3318E44FC3E FOREIGN KEY (librairy_id) REFERENCES librairy (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A3318E44FC3E ON book (librairy_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498E44FC3E');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3318E44FC3E');
        $this->addSql('DROP TABLE librairy');
        $this->addSql('DROP INDEX IDX_CBE5A3318E44FC3E ON book');
        $this->addSql('ALTER TABLE book DROP librairy_id');
        $this->addSql('DROP INDEX IDX_8D93D6498E44FC3E ON user');
        $this->addSql('ALTER TABLE user DROP librairy_id');
    }
}
