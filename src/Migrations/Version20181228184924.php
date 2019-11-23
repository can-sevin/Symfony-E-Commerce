<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181228184924 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE order_detail (id INT AUTO_INCREMENT NOT NULL, orderid INT DEFAULT NULL, userid INT DEFAULT NULL, productid INT DEFAULT NULL, price INT DEFAULT NULL, quantity INT DEFAULT NULL, amount INT DEFAULT NULL, name VARCHAR(150) DEFAULT NULL, status VARCHAR(15) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, userid INT DEFAULT NULL, amount INT DEFAULT NULL, name VARCHAR(20) DEFAULT NULL, address VARCHAR(150) DEFAULT NULL, city VARCHAR(15) DEFAULT NULL, phone VARCHAR(15) DEFAULT NULL, shipinfo VARCHAR(255) DEFAULT NULL, status VARCHAR(15) DEFAULT NULL, note VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD address VARCHAR(255) DEFAULT NULL, ADD city VARCHAR(20) DEFAULT NULL, ADD phone VARCHAR(15) DEFAULT NULL, CHANGE roles roles VARCHAR(50) DEFAULT NULL, CHANGE name name VARCHAR(100) DEFAULT NULL, CHANGE status status VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE category DROP status, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE messages CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE subject subject VARCHAR(255) DEFAULT NULL, CHANGE message message VARCHAR(255) DEFAULT NULL, CHANGE comment comment VARCHAR(255) DEFAULT NULL, CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE title title VARCHAR(150) DEFAULT NULL, CHANGE keywords keywords VARCHAR(255) DEFAULT NULL, CHANGE type type VARCHAR(20) DEFAULT NULL, CHANGE marka_id marka_id INT DEFAULT NULL, CHANGE amount amount INT DEFAULT NULL, CHANGE pprice pprice DOUBLE PRECISION DEFAULT NULL, CHANGE sprice sprice DOUBLE PRECISION DEFAULT NULL, CHANGE minamount minamount INT DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE kategori_id kategori_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE status status VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE shop_cart CHANGE userid userid INT DEFAULT NULL, CHANGE productid productid INT DEFAULT NULL, CHANGE quantity quantity INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE order_detail');
        $this->addSql('DROP TABLE orders');
        $this->addSql('ALTER TABLE category ADD status VARCHAR(255) DEFAULT \'\'True\'\' COLLATE utf8mb4_unicode_ci, CHANGE created_at created_at DATETIME DEFAULT \'NULL\', CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE messages CHANGE email email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE subject subject VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE message message VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE comment comment VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE status status VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE product CHANGE title title VARCHAR(150) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE keywords keywords VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE description description VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE type type VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE marka_id marka_id INT DEFAULT NULL, CHANGE amount amount INT DEFAULT NULL, CHANGE pprice pprice DOUBLE PRECISION DEFAULT \'NULL\', CHANGE sprice sprice DOUBLE PRECISION DEFAULT \'NULL\', CHANGE minamount minamount INT DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE kategori_id kategori_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE status status VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE shop_cart CHANGE userid userid INT DEFAULT NULL, CHANGE productid productid INT DEFAULT NULL, CHANGE quantity quantity INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP address, DROP city, DROP phone, CHANGE roles roles VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE name name VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE status status VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
