<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191114183237 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, parent_id INT NOT NULL, title VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, keywords VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, images VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, email VARCHAR(255) DEFAULT NULL, subject VARCHAR(255) DEFAULT NULL, message VARCHAR(255) DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(150) DEFAULT NULL, keywords VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, type VARCHAR(20) DEFAULT NULL, marka_id INT DEFAULT NULL, amount INT DEFAULT NULL, pprice DOUBLE PRECISION DEFAULT NULL, sprice DOUBLE PRECISION DEFAULT NULL, minamount INT DEFAULT NULL, detail LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, kategori_id INT DEFAULT NULL, user_id INT DEFAULT NULL, status VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setting (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, keywords VARCHAR(255) DEFAULT NULL, company VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, fax VARCHAR(15) DEFAULT NULL, phone VARCHAR(15) DEFAULT NULL, email VARCHAR(50) DEFAULT NULL, smtpserver VARCHAR(100) DEFAULT NULL, smtpemail VARCHAR(50) DEFAULT NULL, smtppassword VARCHAR(20) DEFAULT NULL, smtpport INT DEFAULT NULL, aboutus VARCHAR(1000) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, referances VARCHAR(255) DEFAULT NULL, status VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE name (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(100) NOT NULL, status VARCHAR(10) NOT NULL, role VARCHAR(10) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_detail (id INT AUTO_INCREMENT NOT NULL, orderid INT DEFAULT NULL, userid INT DEFAULT NULL, productid INT DEFAULT NULL, price INT DEFAULT NULL, quantity INT DEFAULT NULL, amount INT DEFAULT NULL, name VARCHAR(150) DEFAULT NULL, status VARCHAR(15) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, userid INT DEFAULT NULL, amount INT DEFAULT NULL, name VARCHAR(20) DEFAULT NULL, address VARCHAR(150) DEFAULT NULL, city VARCHAR(15) DEFAULT NULL, phone VARCHAR(15) DEFAULT NULL, shipinfo VARCHAR(255) DEFAULT NULL, status VARCHAR(15) DEFAULT NULL, note VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_cart (id INT AUTO_INCREMENT NOT NULL, userid INT DEFAULT NULL, productid INT DEFAULT NULL, quantity INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD address VARCHAR(255) DEFAULT NULL, ADD city VARCHAR(20) DEFAULT NULL, ADD phone VARCHAR(15) DEFAULT NULL, CHANGE roles roles VARCHAR(50) DEFAULT NULL, CHANGE name name VARCHAR(100) DEFAULT NULL, CHANGE status status VARCHAR(20) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE setting');
        $this->addSql('DROP TABLE name');
        $this->addSql('DROP TABLE order_detail');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE shop_cart');
        $this->addSql('ALTER TABLE user DROP address, DROP city, DROP phone, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE name name VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE status status VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
