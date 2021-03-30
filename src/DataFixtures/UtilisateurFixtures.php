<?php

namespace App\DataFixtures;

use App\Entity\Adresse;
use App\Entity\Specialite;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $adresse = new Adresse();
        $adresse->setVille("vile");
        $adresse->setRue("rue");
        $adresse->setNumero(1212);
        $adresse->setCodePostal(2020);
        $manager->persist($adresse);
        $manager->flush();

        $specialite = new Specialite();
        $specialite->setNom("Specialite 1");
        $specialite->setDescription("desc 1");
        $manager->persist($specialite);
        $manager->flush();

        $user = new Utilisateur();
        $user->setUsername("user");
        $user->setPassword($this->encoder->encodePassword($user,"admin"));
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setNom("admin");
        $user->setPrenom("admin prenom");
        $user->setUsername("admin");
        $user->setEmail("admi@gmail.com");
        $user->setTelephone("0101010101001");
        $user->setIsDeleted(false);
        $user->setAdresse($adresse);
        $user->setSpecialite($specialite);
        $manager->persist($user);
        $manager->flush();


    }
}
