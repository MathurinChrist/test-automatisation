<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260521083241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, todo_list_id INT DEFAULT NULL, INDEX IDX_1F1B251EE8A7DCFA (todo_list_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE todo_list (id INT AUTO_INCREMENT NOT NULL, user_concern_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_1B199E071B0A0A39 (user_concern_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, first_name VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EE8A7DCFA FOREIGN KEY (todo_list_id) REFERENCES todo_list (id)');
        $this->addSql('ALTER TABLE todo_list ADD CONSTRAINT FK_1B199E071B0A0A39 FOREIGN KEY (user_concern_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251EE8A7DCFA');
        $this->addSql('ALTER TABLE todo_list DROP FOREIGN KEY FK_1B199E071B0A0A39');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE todo_list');
        $this->addSql('DROP TABLE `user`');
    }
}
