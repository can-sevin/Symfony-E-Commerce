<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181224191832 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE messages CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE subject subject VARCHAR(255) DEFAULT NULL, CHANGE message message VARCHAR(255) DEFAULT NULL, CHANGE comment comment VARCHAR(255) DEFAULT NULL, CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE title title VARCHAR(150) DEFAULT NULL, CHANGE keywords keywords VARCHAR(255) DEFAULT NULL, CHANGE type type VARCHAR(20) DEFAULT NULL, CHANGE marka_id marka_id INT DEFAULT NULL, CHANGE amount amount INT DEFAULT NULL, CHANGE pprice pprice DOUBLE PRECISION DEFAULT NULL, CHANGE sprice sprice DOUBLE PRECISION DEFAULT NULL, CHANGE minamount minamount INT DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE kategori_id kategori_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE status status VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE name name VARCHAR(100) DEFAULT NULL, CHANGE status status VARCHAR(20) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category CHANGE created_at created_at DATETIME DEFAULT \'NULL\', CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE messages CHANGE email email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE subject subject VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE message message VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE comment comment VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE status status VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE product CHANGE title title VARCHAR(150) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE keywords keywords VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE description description VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE type type VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE marka_id marka_id INT DEFAULT NULL, CHANGE amount amount INT DEFAULT NULL, CHANGE pprice pprice DOUBLE PRECISION DEFAULT \'NULL\', CHANGE sprice sprice DOUBLE PRECISION DEFAULT \'NULL\', CHANGE minamount minamount INT DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE kategori_id kategori_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE status status VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE name name VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE status status VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
