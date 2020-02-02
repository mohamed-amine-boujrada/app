<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Invoice;
use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * l'encodeur de mots de passe
     *
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        
    }
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');
     

        for($u = 0;$u < 10 ; $u++){
            $chrono = 1;
            $user = new User(); 

      //      $hash = $this->encoder->encodePassword($user, "password");
            $hash =  "password";
            $user->setFirstName($faker->firstName)
                 ->setLastName($faker->lastName)
                 ->setEmail($faker->email)
                 ->setPassword($hash);

            $manager->persist($user);
            for($c = 0;$c < mt_rand(5,20) ; $c++){
            
                $customer = new Customer();
                $customer->setFirstname($faker->firstName())
                         ->setLastname($faker->lastName)
                         ->setCompany($faker->company)
                         ->setEmail($faker->email)
                         ->setUser($user);
                         
                $manager->persist($customer);
    
                for($i = 0 ; $i < mt_rand(3,10);$i++ ){
                   
                    $invoice = new Invoice();
                    $invoice->setAmount($faker->randomFloat(2,2))
                            ->setSentAt($faker->dateTimeBetween('-6 months'))
                            ->setStatus($faker->randomElement(['SEND','PAID','CANCELLED']))
                            ->setChrono($chrono)
                            ->setCustomer($customer);
                            $manager->persist($invoice);
                    $chrono++;
                }
    
            }
        }   

       
        $manager->flush();
    }
}
