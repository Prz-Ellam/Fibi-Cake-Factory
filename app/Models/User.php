<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;
use Fibi\Validation\Rules\Email;
use Fibi\Validation\Rules\Required;

class User extends Model
{
    #[Required]
    private ?string $userId;

    #[Required]
    #[Email]
    private ?string $email;

    #[Required]
    private ?string $username;

    #[Required]
    private ?string $birthDate;

    #[Required]
    private ?string $firstName;

    #[Required]
    private ?string $lastName;

    #[Required]
    private ?int $visibility;

    #[Required]
    private ?string $gender;

    #[Required]
    private ?string $password;

    #[Required]
    private ?string $confirmPassword;

    #[Required]
    private ?int $userRole;

    #[Required]
    private ?string $profilePicture;

    public function getUserId() : ?string
    {
        return $this->userId;
    }

    public function setUserId(?string $userId) : self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getEmail() : ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email) : self
    {
        $this->email = $email;
        return $this;
    }

    public function getUsername() : ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username) : self
    {
        $this->username = $username;
        return $this;
    }

    public function getFirstName() : ?string 
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName) : self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName() : ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName) : self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getBirthDate() : ?string
    {
        return $this->birthDate;
    }

    public function setBirthDate(?string $birthDate) : self
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function getVisibility() : ?int
    {
        return $this->visibility;
    }

    public function setVisibility(?int $visibility) : self
    {
        $this->visibility = $visibility;
        return $this;
    }

    public function getGender() : ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender) : self
    {
        $this->gender = $gender;
        return $this;
    }

    public function getPassword() : ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password) : self
    {
        $this->password = $password;
        return $this;
    }

    public function getConfirmPassword() : ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(?string $confirmPassword) : self
    {
        $this->confirmPassword = $confirmPassword;
        return $this;
    }

    public function getUserRole() : ?int
    {
        return $this->userRole;
    }

    public function setUserRole(?int $userRole) : self
    {
        $this->userRole = $userRole;
        return $this;
    }

    public function getProfilePicture() : ?string
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(?string $profilePicture) : self
    {
        $this->profilePicture = $profilePicture;
        return $this;
    }

    public function toObject()
    {
        $members = get_object_vars($this);
        return json_decode(json_encode($members), true);
    }

}

?>