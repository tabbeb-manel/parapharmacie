<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\ArticleLike;
use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /*
     * @var UserPasswordEncoderInterface
     */
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    private static $articleImages = [
        '21dbb291553fffd9a2d0c1b7331adcd0.jpeg',
        '852905373a83c2a56591239191635501.jpeg',
        'a8f13c475c76efbf93423e01cac20f5a.png',
    ];
    private static $skintypes = [
        'Peau Séche',
        'Peau normale',
        'Peau Mixte',
        'Peau Grasse',
    ];
    public function load(ObjectManager $manager)
    {
       $faker = Factory::create();
        $users = [];
        $user = new User();
        $user->setLogin('NadaLabidi')
              ->setPassword($this->encoder->encodePassword($user,'password'))
        ->setAdress($faker->address)
        ->setFirstName($faker->firstName)
        ->setLastName($faker->lastName)
        ->setEmail($faker->email)
        ->setDateBirth($faker->dateTimeBetween( +10 , 'now', null))
        ->setSkinType($faker->randomElement(self::$skintypes));

        $manager->persist($user);

        $users[]=$user;

        for($i=0; $i<20; $i++){
            $user=new User();
            $user->setLogin($faker->userName)
                 ->setPassword($this->encoder->encodePassword($user, 'password'))
                    ->setAdress($faker->address)
                    ->setFirstName($faker->firstName)
                    ->setLastName($faker->lastName)
                    ->setEmail($faker->email)
                    ->setDateBirth($faker->dateTimeBetween( +10 , 'now', null))
                    ->setSkinType($faker->randomElement(self::$skintypes));


            $manager->persist($user);
            $users[]=$user;
        }
        for ($i = 0; $i< 20; $i++){
            $article= new Article();
            $article->setTitle($faker->sentence(6))
                ->setDescription( join(',', $faker->paragraphs()) )
                ->setImage($faker->randomElement(self::$articleImages))
                ->setCreatedAt($faker->dateTimeBetween('-100 days', '-1 days'));

                $manager->persist($article);


                for($j = 0; $j<mt_rand(0, 100); $j++){
                    $like = new ArticleLike();
                    $like->setArticle($article)
                        ->setUser($faker->randomElement($users));
                    $manager->persist($like);
            }


        }



        $manager->flush();
    }
}
