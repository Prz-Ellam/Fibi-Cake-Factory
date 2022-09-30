<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;
use Fibi\Validation\Rules\Email;
use Fibi\Validation\Rules\EqualTo;
use Fibi\Validation\Rules\HasLower;
use Fibi\Validation\Rules\HasNumber;
use Fibi\Validation\Rules\HasSpecialChars;
use Fibi\Validation\Rules\HasUpper;
use Fibi\Validation\Rules\MaxLength;
use Fibi\Validation\Rules\MinLength;
use Fibi\Validation\Rules\Required;
use Fibi\Validation\Rules\Uuid;

/**
 * Usuario de la aplicación
 */
class User implements Model
{
    /**
     * El identificador global unico del usuario en la base de datos
     *
     * @var string|null
     */
    #[Required]
    #[Uuid]
    private ?string $userId;

    /**
     * Correo electrónico del usuario
     *
     * @var string|null
     */
    #[Required]
    #[Email]
    #[MaxLength(255)]
    private ?string $email;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    #[MinLength(3)]
    #[MaxLength(18)]
    private ?string $username;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    #[MaxLength(50)]
    private ?string $firstName;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    #[MaxLength(50)]
    private ?string $lastName;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    private ?string $birthDate;

    /**
     * Undocumented variable
     *
     * @var bool|null
     */
    #[Required]
    private ?bool $visible;

    /**
     * Undocumented variable
     *
     * @var integer|null
     */
    #[Required]
    private ?int $gender;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    #[MinLength(8)]
    #[MaxLength(255)]
    #[HasUpper]
    #[HasLower]
    #[HasNumber]
    #[HasSpecialChars]
    //#[EqualTo('confirmPassword')]
    private ?string $password;

    /**
     * Undocumented variable
     *
     * @var integer|null
     */
    #[Required]
    private ?string $userRole;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required]
    #[Uuid]
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

    public function getVisibility() : ?bool
    {
        return $this->visible;
    }

    public function setVisibility(?bool $visible) : self
    {
        $this->visible = $visible;
        return $this;
    }

    public function getGender() : ?int
    {
        return $this->gender;
    }

    public function setGender(?int $gender) : self
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

    public function getUserRole() : ?string
    {
        return $this->userRole;
    }

    public function setUserRole(?string $userRole) : self
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

    public function toObject() : array
    {
        $members = get_object_vars($this);
        return json_decode(json_encode($members), true);
    }

    public static function getProperties() : array
    {
        return array_keys(get_class_vars(self::class));
    }
}

?>