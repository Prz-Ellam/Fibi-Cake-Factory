<?php

namespace CakeFactory\Build;

use CakeFactory\Models\Image;
use CakeFactory\Models\User;
use CakeFactory\Models\UserRole;
use CakeFactory\Repositories\ImageRepository;
use CakeFactory\Repositories\UserRepository;
use CakeFactory\Repositories\UserRoleRepository;
use Ramsey\Uuid\Nonstandard\Uuid;

class Startup
{
    /**
     * Carga los registros default para utilizar la aplicacion
     *
     * @return bool
     */
    public function load() : bool
    {
        print("Start");
        $userRoleRepository = new UserRoleRepository();

        $userRoleId = Uuid::uuid4()->toString();
        $name = "Super Administrador";
        $userRole = new UserRole();
        $userRole
            ->setUserRoleId($userRoleId)
            ->setName($name);
        $result = $userRoleRepository->create($userRole);
        if ($result === false)
        {
            return false;
        }
        $superAdminRoleId = $userRoleId;
        print("First");

        $userRoleId = Uuid::uuid4()->toString();
        $name = "Administrador";
        $userRole = new UserRole();
        $userRole
            ->setUserRoleId($userRoleId)
            ->setName($name);
        $result = $userRoleRepository->create($userRole);
        if ($result === false)
        {
            return false;
        }

        $userRoleId = Uuid::uuid4()->toString();
        $name = "Vendedor";
        $userRole = new UserRole();
        $userRole
            ->setUserRoleId($userRoleId)
            ->setName($name);
        $result = $userRoleRepository->create($userRole);
        if ($result === false)
        {
            return false;
        }

        $userRoleId = Uuid::uuid4()->toString();
        $name = "Comprador";
        $userRole = new UserRole();
        $userRole
            ->setUserRoleId($userRoleId)
            ->setName($name);
        $result = $userRoleRepository->create($userRole);
        if ($result === false)
        {
            return false;
        }

        $userId = Uuid::uuid4()->toString();
        $imageId = Uuid::uuid4()->toString();
        $imageName = "pyramid.png";
        $imageType = "image/jpeg";
        $imageContent = file_get_contents(__DIR__ . '/pyramid.jpg');
        $imageSize = strlen($imageContent);

        $image = new Image();
        $image
            ->setImageId($imageId)
            ->setName($imageName)
            ->setType($imageType)
            ->setSize($imageSize)
            ->setContent($imageContent)
            ->setMultimediaEntityId($userId)
            ->setMultimediaEntityType('users');

        $imageRepository = new ImageRepository();
        $result = $imageRepository->create($image);
        if ($result === false)
        {
            return false;
        }
        
        $email = "admin@localhost.com";
        $username = "admin";
        $birthDate = "2001-10-26";
        $firstName = "Eliam";
        $lastName = "P??rez";
        $visible = 1;
        $gender = 1;
        $password = password_hash("123Abc!!", PASSWORD_DEFAULT);

        $superAdmin = new User();
        $superAdmin->setUserId($userId)
            ->setEmail($email)
            ->setUsername($username)
            ->setBirthDate($birthDate)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setVisible($visible)
            ->setGender($gender)
            ->setPassword($password)
            ->setUserRole($superAdminRoleId)
            ->setProfilePicture($imageId);

        $userRepository = new UserRepository();
        $result = $userRepository->create($superAdmin);
        if ($result === false)
        {
            return false;
        }

        return false;
    }
}
