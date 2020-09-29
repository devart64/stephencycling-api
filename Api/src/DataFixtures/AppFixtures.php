<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){

        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $fake = Factory::create();

        for ($u = 0; $u < 10; $u++) {
            // on créé un utilisateur
            $User = new User();
            // on lui encode un faut password = "password"
            $passhash = $this->encoder->encodePassword($User, 'password');
            // on lui set un faut email
            $User->setEmail($fake->email)
                // et le password
                 ->setPassword($passhash);
            if ($u % 3 === 0) {
                $User->setStatus(false)
                     ->setAge(23);
            }

            // on persist notre utilisateur
            $manager->persist($User);
           for ($a = 0; $a < random_int(5, 15); $a++) {
               $Article = (new Article())->setAuthor($User)
                                         ->setContent($fake->text(300))
                                         ->setName($fake->text(50 ));
               $manager->persist($Article);

           }
        }
        $manager->flush();
    }
}
