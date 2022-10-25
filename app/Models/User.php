<?php

namespace CakeFactory\Models;

use DateTime;
use Fibi\Model\Model;
use Fibi\Validation\Rules\DateRange;
use Fibi\Validation\Rules\Email;
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
    private ?string $userId = null;

    /**
     * Correo electrónico del usuario
     *
     * @var string|null
     */
    #[Required("El correo electrónico no puede estar vacío")]
    #[Email("El correo electrónico no es válido")]
    #[MaxLength(255, "El correo electrónico es muy largo")]
    private ?string $email = null;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required("El nombre de usuario no puede estar vacío")]
    #[MinLength(3, "El nombre de usuario es muy corto")]
    #[MaxLength(18, "El nombre de usuario es muy largo")]
    private ?string $username = null;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required("El nombre no puede estar vacío")]
    #[MaxLength(50, "El nombre es muy largo")]
    private ?string $firstName = null;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required("El apellido no puede estar vacío")]
    #[MaxLength(50, "El apellido es muy largo")]
    private ?string $lastName = null;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required("La fecha de nacimiento no puede estar vacía")]
    #[DateRange("1900-01-01", "now", "La fecha que ingresó no es valida")]
    private ?string $birthDate = null;

    /**
     * Undocumented variable
     *
     * @var bool|null
     */
    #[Required("La visibilidad no puede estar vacía")]
    private ?bool $visible = null;

    /**
     * Undocumented variable
     *
     * @var integer|null
     */
    #[Required("El sexo no puede estar vacío")]
    private ?int $gender = null;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    #[Required("La contraseña no puede estar vacía")]
    #[MinLength(8, "La contraseña es muy corta")]
    #[MaxLength(255, "La contraseña es muy larga")]
    #[HasUpper("La contraseña debe tener al menos una mayúscula")]
    #[HasLower("La contraseña debe tener al menos una minuscula")]
    #[HasNumber("La contraseña debe tener al menos un número")]
    #[HasSpecialChars("La contraseña debe tener al menos un caracter especial")]
    //#[EqualTo('confirmPassword')]
    private ?string $password = null;

    /**
     * Rol que ocupa el usuario en la aplicacion
     *
     * @var integer|null
     */
    #[Required("El rol de usuario no puede estar vacío")]
    private ?string $userRole = null;

    /**
     * Identificador de la foto de perfil del usuario
     *
     * @var string|null
     */
    #[Required("La foto de perfil no puede estar vacía")]
    #[Uuid]
    private ?string $profilePicture = null;

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

    public function isVisible() : ?int
    {
        return $this->visible ? 1 : 0;
    }

    public function setVisible(?bool $visible) : self
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
