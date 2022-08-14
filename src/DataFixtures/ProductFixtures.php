<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product();
        $product->setName('Keychron Q7');
        $product->setPrice(175.25);
        $product ->setQuantity(rand(10,100));
        $product->setImage("https://img.cdn.vncdn.io/nvn/ncdn/store1/51905/ps/20220802/02082022020837_Q7_C.jpg");
        $product->setDescription('Keychron Q7 is a 70% layout and all-metal mechanical keyboard. With its all-metal
             CNC machined body, a full-size layout, double-gasket design, and QMK/VIA support, the Q7 meets all your practical needs.');
        $manager->persist($product);

        $manager->flush();
        $product = new Product();
        $product->setName('Logitech G PRO X SUPERLIGHT');
        $product->setPrice(135.72);
        $product ->setQuantity(rand(10,100));
        $product->setImage("https://product.hstatic.net/1000026716/product/gearvn-chuot-logitech-g-pro-x-superlight-wireless-black-666_83650815ce2e486f9108dbbb17c29159.jpg");
        $product->setDescription("Eliminate all obstacles on your way to 
                victory with our lightest and fastest PRO mouse ever. The new weapon of choice for the world's top professional e-sports athletes");
        $manager->persist($product);

        $manager->flush();
        $product = new Product();
        $product->setName('Glorious Model O');
        $product->setPrice(49.99);
        $product ->setQuantity(rand(10,100));
        $product->setImage("https://techspace.vn/wp-content/uploads/2022/03/Chuot-Glorious-Model-O-Wireless-Matte-White-5.png");
        $product->setDescription('Envisioned by a community of passionate gamers, and developed by a team who accepts nothing less than perfection - Model O 
                will elevate your play to unimaginable heights.');
        $manager->persist($product);

        $manager->flush();
        $product = new Product();
        $product->setName('FL-Esports CMK87');
        $product->setPrice(164.53);
        $product ->setQuantity(rand(10,100));
        $product->setImage("https://nguyenvu.store/wp-content/uploads/2021/11/e1-1.jpg");
        $product->setDescription('The keyboard has an 87-button layout, Cherry Profile with hot swap feature for easy switching. Kailh Box, Cool Mint and FL-CMMK Cercis 
            Switch are 3 types of switches used on this keyboard.');
        $manager->persist($product);

        $manager->flush();
        $product = new Product();
        $product->setName('MK 68');
        $product->setPrice(75.25);
        $product ->setQuantity(rand(10,100));
        $product->setImage("https://ae01.alicdn.com/kf/H3ef181d6124a40b58623af28774939edS/GamaKay-MK68-68-Ph-m-RGB-Trao-i-N-ng-Lo-i-C-C-D-y.jpg_640x640.jpg");
        $product->setDescription('MK 68 is a 70% layout and all-metal mechanical keyboard. With its all-metal
             CNC machined body, a full-size layout, double-gasket design.');
        $manager->persist($product);

        $manager->flush();
        $product = new Product();
        $product->setName('DareU EM901');
        $product->setPrice(23.89);
        $product ->setQuantity(rand(10,100));
        $product->setImage("https://lh3.googleusercontent.com/zDcEyTYv-mYeA-ljbodGo2ggtzxDYC0sZ-yt4WsbU1yZZdCO6vLs-x6jWrsaRXA0mKo08DRawg5fOI-5OhM=w500-rw");
        $product->setDescription('DareU EM901 wireless gaming computer mouse is designed to be compact and lightweight with only 100g of plastic material.');
        $manager->persist($product);

        $manager->flush();
        $product = new Product();
        $product->setName('Razer DeathAdder V2 Pro - Black');
        $product->setPrice(129.99);
        $product ->setQuantity(rand(10,100));
        $product->setImage("https://product.hstatic.net/1000026716/product/gearvn-chuot-razer-deathadder-v2-pro-666_3c8fd48ca8fc4ede9991d810da6297a3.jpg");
        $product->setDescription('Wireless gaming mouse with best-in-class ergonomics.');
        $manager->persist($product);

        $manager->flush();
        $product = new Product();
        $product->setName('Razer BlackWidow V3 Mini');
        $product->setPrice(199.99);
        $product ->setQuantity(rand(10,100));
        $product->setImage("https://ae01.alicdn.com/kf/H613ddba43f8c4a5197c9fcc8a0359e4fZ/B-n-Ph-m-Razer-BlackWidow-V3-Mini-HyperSpeed-M-u-V-ng-Xanh-C-ng.jpg_Q90.jpg_.webp");
        $product->setDescription('Wireless 65% Mechanical Gaming Keyboard with Razer Chroma™ RGB.');
        $manager->persist($product);

        $manager->flush();
        $product = new Product();
        $product->setName('K70 PRO MINI WIRELESS ');
        $product->setPrice(175.25);
        $product ->setQuantity(rand(10,100));
        $product->setImage("https://fmen.net/wp-content/uploads/2022/07/Corsair-K70-Pro-Mini-Wireless-Mechanical-Gaming-Keyboard-10.jpg");
        $product->setDescription('The CORSAIR K70 PRO MINI WIRELESS RGB 60% Mechanical Gaming Keyboard is big on both performance and customization, equipped with hyper-fast, sub-1ms 
                SLIPSTREAM WIRELESS and swappable CHERRY MX keyswitches in a portable profile.');
        $manager->persist($product);

        $manager->flush();
        $product = new Product();
        $product->setName('KATAR PRO Wireless');
        $product->setPrice(105.25);
        $product ->setQuantity(rand(10,100));
        $product->setImage("https://www.corsair.com/medias/sys_master/images/images/h72/h22/9591321657374/base-katar-pro-wireless-config/Gallery/KATAR_PRO_WIRELESS_01/-base-katar-pro-wireless-config-Gallery-KATAR-PRO-WIRELESS-01.png_1200Wx1200H");
        $product->setDescription('Experience lightweight design and heavyweight performance with the CORSAIR KATAR PRO WIRELESS Gaming Mouse, connecting via hyper-fast.');
        $manager->persist($product);

        $manager->flush();
    }
}
