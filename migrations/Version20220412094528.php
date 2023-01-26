<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412094528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, country VARCHAR(100) NOT NULL, city VARCHAR(100) NOT NULL, zip INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, fk_cart_id_id INT NOT NULL, fk_shipping_comp_id INT NOT NULL, fk_user_id_id INT NOT NULL, order_date DATE NOT NULL, UNIQUE INDEX UNIQ_F5299398D0C039CC (fk_cart_id_id), INDEX IDX_F5299398FD2F5A78 (fk_shipping_comp_id), UNIQUE INDEX UNIQ_F52993986DE8AF9C (fk_user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_method (id INT AUTO_INCREMENT NOT NULL, fk_type_id INT NOT NULL, fk_user_id_id INT NOT NULL, card_nr INT NOT NULL, valid_date DATE NOT NULL, INDEX IDX_7B61A1F63563B1BF (fk_type_id), INDEX IDX_7B61A1F66DE8AF9C (fk_user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prod_answer (id INT AUTO_INCREMENT NOT NULL, fk_question_id_id INT NOT NULL, fk_user_id_id INT NOT NULL, answer VARCHAR(1000) NOT NULL, answer_date DATE NOT NULL, INDEX IDX_EE024563AA166BA (fk_question_id_id), INDEX IDX_EE024566DE8AF9C (fk_user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prod_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prod_question (id INT AUTO_INCREMENT NOT NULL, fk_user_id_id INT NOT NULL, fk_product_id_id INT NOT NULL, question VARCHAR(1000) NOT NULL, question_date DATE NOT NULL, INDEX IDX_18EFFB196DE8AF9C (fk_user_id_id), INDEX IDX_18EFFB19BA5290C9 (fk_product_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, fk_category_id INT NOT NULL, fk_supplier_id INT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(1000) DEFAULT NULL, picture VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, size DOUBLE PRECISION NOT NULL, weight DOUBLE PRECISION NOT NULL, stock INT NOT NULL, discount INT DEFAULT NULL, INDEX IDX_D34A04AD7BB031D6 (fk_category_id), INDEX IDX_D34A04AD432BC1B8 (fk_supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, fk_user_id_id INT NOT NULL, fk_product_id_id INT NOT NULL, rating INT NOT NULL, review VARCHAR(1000) NOT NULL, INDEX IDX_794381C66DE8AF9C (fk_user_id_id), INDEX IDX_794381C6BA5290C9 (fk_product_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ship_comp (id INT AUTO_INCREMENT NOT NULL, fk_location_id INT NOT NULL, name VARCHAR(100) NOT NULL, address VARCHAR(100) NOT NULL, phone INT NOT NULL, INDEX IDX_6928BC7B6FBB8DBA (fk_location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shopping_cart (id INT AUTO_INCREMENT NOT NULL, fk_user_id_id INT NOT NULL, fk_product_id_id INT NOT NULL, INDEX IDX_72AAD4F66DE8AF9C (fk_user_id_id), INDEX IDX_72AAD4F6BA5290C9 (fk_product_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supp_sales (id INT AUTO_INCREMENT NOT NULL, fk_product_id_id INT NOT NULL, fk_supplier_id INT NOT NULL, sale_date DATE NOT NULL, INDEX IDX_5483ACB7BA5290C9 (fk_product_id_id), INDEX IDX_5483ACB7432BC1B8 (fk_supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supplier (id INT AUTO_INCREMENT NOT NULL, fk_location_id INT NOT NULL, name VARCHAR(100) NOT NULL, address VARCHAR(255) NOT NULL, phone INT NOT NULL, picture VARCHAR(255) DEFAULT NULL, INDEX IDX_9B2A6C7E6FBB8DBA (fk_location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, fk_location_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, f_name VARCHAR(50) NOT NULL, l_name VARCHAR(50) NOT NULL, address VARCHAR(100) NOT NULL, ban_status DATE DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6496FBB8DBA (fk_location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398D0C039CC FOREIGN KEY (fk_cart_id_id) REFERENCES shopping_cart (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398FD2F5A78 FOREIGN KEY (fk_shipping_comp_id) REFERENCES ship_comp (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993986DE8AF9C FOREIGN KEY (fk_user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE payment_method ADD CONSTRAINT FK_7B61A1F63563B1BF FOREIGN KEY (fk_type_id) REFERENCES payment_type (id)');
        $this->addSql('ALTER TABLE payment_method ADD CONSTRAINT FK_7B61A1F66DE8AF9C FOREIGN KEY (fk_user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE prod_answer ADD CONSTRAINT FK_EE024563AA166BA FOREIGN KEY (fk_question_id_id) REFERENCES prod_question (id)');
        $this->addSql('ALTER TABLE prod_answer ADD CONSTRAINT FK_EE024566DE8AF9C FOREIGN KEY (fk_user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE prod_question ADD CONSTRAINT FK_18EFFB196DE8AF9C FOREIGN KEY (fk_user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE prod_question ADD CONSTRAINT FK_18EFFB19BA5290C9 FOREIGN KEY (fk_product_id_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7BB031D6 FOREIGN KEY (fk_category_id) REFERENCES prod_category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD432BC1B8 FOREIGN KEY (fk_supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C66DE8AF9C FOREIGN KEY (fk_user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6BA5290C9 FOREIGN KEY (fk_product_id_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE ship_comp ADD CONSTRAINT FK_6928BC7B6FBB8DBA FOREIGN KEY (fk_location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE shopping_cart ADD CONSTRAINT FK_72AAD4F66DE8AF9C FOREIGN KEY (fk_user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE shopping_cart ADD CONSTRAINT FK_72AAD4F6BA5290C9 FOREIGN KEY (fk_product_id_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE supp_sales ADD CONSTRAINT FK_5483ACB7BA5290C9 FOREIGN KEY (fk_product_id_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE supp_sales ADD CONSTRAINT FK_5483ACB7432BC1B8 FOREIGN KEY (fk_supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE supplier ADD CONSTRAINT FK_9B2A6C7E6FBB8DBA FOREIGN KEY (fk_location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496FBB8DBA FOREIGN KEY (fk_location_id) REFERENCES location (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ship_comp DROP FOREIGN KEY FK_6928BC7B6FBB8DBA');
        $this->addSql('ALTER TABLE supplier DROP FOREIGN KEY FK_9B2A6C7E6FBB8DBA');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496FBB8DBA');
        $this->addSql('ALTER TABLE payment_method DROP FOREIGN KEY FK_7B61A1F63563B1BF');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD7BB031D6');
        $this->addSql('ALTER TABLE prod_answer DROP FOREIGN KEY FK_EE024563AA166BA');
        $this->addSql('ALTER TABLE prod_question DROP FOREIGN KEY FK_18EFFB19BA5290C9');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6BA5290C9');
        $this->addSql('ALTER TABLE shopping_cart DROP FOREIGN KEY FK_72AAD4F6BA5290C9');
        $this->addSql('ALTER TABLE supp_sales DROP FOREIGN KEY FK_5483ACB7BA5290C9');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398FD2F5A78');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398D0C039CC');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD432BC1B8');
        $this->addSql('ALTER TABLE supp_sales DROP FOREIGN KEY FK_5483ACB7432BC1B8');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993986DE8AF9C');
        $this->addSql('ALTER TABLE payment_method DROP FOREIGN KEY FK_7B61A1F66DE8AF9C');
        $this->addSql('ALTER TABLE prod_answer DROP FOREIGN KEY FK_EE024566DE8AF9C');
        $this->addSql('ALTER TABLE prod_question DROP FOREIGN KEY FK_18EFFB196DE8AF9C');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C66DE8AF9C');
        $this->addSql('ALTER TABLE shopping_cart DROP FOREIGN KEY FK_72AAD4F66DE8AF9C');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE payment_method');
        $this->addSql('DROP TABLE payment_type');
        $this->addSql('DROP TABLE prod_answer');
        $this->addSql('DROP TABLE prod_category');
        $this->addSql('DROP TABLE prod_question');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE ship_comp');
        $this->addSql('DROP TABLE shopping_cart');
        $this->addSql('DROP TABLE supp_sales');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
