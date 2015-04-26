<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Product;



/**
 * Description of LoadCommentsData
 *
 * @author Buba
 */
class LoadCommentsData extends AbstractFixture implements OrderedFixtureInterface {
    
    public function getOrder() {
        
        return 4;
    }
    
    public function load(ObjectManager $manager) {
        
        $faker = \Faker\Factory::create('pl_PL');
        
        for ($commentAmount = 0; $commentAmount < 500; $commentAmount ++) {
            
            $comment = new Comment();
            
            $comment->setContent($faker->text());
            $comment->setCreatedAt($faker->dateTimeThisYear);
            $comment->setProduct($this->getReference('user' . $faker->numberBetween(1,200)));
            //$comment->setUser($this->getReference('product' . $faker->numberBetween(1, 200)));
            $comment->setVerified(TRUE);
            
            $manager->persist($comment);
        }
        
        $manager->flush();
    }
}
