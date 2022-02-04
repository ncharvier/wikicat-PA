<?php
namespace App\Model;

use App\Core\BaseSQL;

class User extends BaseSQL
{

    protected $id = null;
    protected $login;
    protected $email;
    protected $password;
    protected $status = 0;
    protected $token = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function updateUserSession(): void{
        $this->generateToken();
        $this->save();
        $_SESSION["connectedUser"]["id"] = $this->getId();
        $_SESSION["connectedUser"]["login"] = $this->getLogin();
        $_SESSION["connectedUser"]["email"] = $this->getEmail();
        $_SESSION["connectedUser"]["token"] = $this->getToken();
    }

    public function getByEmail($email): ?object{
        return parent::getFromValue(strtolower(trim($email)), "email");
    }

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login): void
    {
        $this->login = trim($login);
    }

    /**
     * @return mixed
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = strtolower(trim($email));
    }

    /**
     * @return mixed
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @return null
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param null $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param null
     * Token char 32
     */
    public function generateToken(): void
    {
        $this->token = str_shuffle(md5(uniqid()));
    }

    public function clearToken(): void{
        $this->token = null;
    }

    public function save()
    {
        parent::save();
    }

    public function getFormRegister(): array
    {
        $className = explode("\\",get_called_class());
        $className = end($className);

        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "className"=>$className,
                "submit"=>"S'inscrire"
            ],
            "inputs"=>[
                "login"=>[
                    "type"=>"text",
                    "placeholder"=>"Pseudonyme",
                    "id"=>"loginRegister",
                    "class"=>"inputRegister",
                    "required"=>true,
                    "error"=>"Pseudonyme invalide"
                ],
                "email"=>[
                    "type"=>"email",
                    "placeholder"=>"Votre email ...",
                    "id"=>"emailRegister",
                    "class"=>"inputRegister",
                    "required"=>true,
                    "error"=>"Email incorrect",
                    "unicity"=>true,
                    "errorUnicity"=>"Un compte existe déjà sur cette adresse email"
                ],
                "password"=>[
                    "type"=>"password",
                    "placeholder"=>"Votre mot de passe ...",
                    "id"=>"pwdRegister",
                    "class"=>"inputRegister",
                    "required"=>true,
                    "error"=>"Votre mot de passe doit faire entre 8 et 16 et contenir des chiffres et des lettres",
                ],
            ]

        ];
    }

    public function getFormLogin(): array
    {
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "submit"=>"Se connecter"
            ],
            "inputs"=>[
                "email"=>[
                    "type"=>"email",
                    "placeholder"=>"Votre email ...",
                    "id"=>"emailRegister",
                    "class"=>"inputRegister",
                    "required"=>true,
                ],
                "password"=>[
                    "type"=>"password",
                    "placeholder"=>"Votre mot de passe ...",
                    "id"=>"pwdRegister",
                    "class"=>"inputRegister",
                    "required"=>true,
                ]
            ]

        ];
    }
    public function getLoginUpdate(): array
    {
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "submit"=>"Mettre à jour votre Pseudo"
            ],
            "inputs"=>[
                "login"=>[
                    "type"=>"text",
                    "placeholder"=>"Pseudonyme",
                    "id"=>"loginRegister",
                    "class"=>"inputRegister",
                    "required"=>true,
                    "error"=>"Pseudonyme invalide"
                ]
            ]
        ];
    }
    public function getEmailUpdate(): array
    {
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "submit"=>"Mettre à jour votre mail"
            ],
            "inputs"=>[
                "email"=>[
                    "type"=>"email",
                    "placeholder"=>"Votre email ...",
                    "id"=>"emailRegister",
                    "class"=>"inputRegister",
                    "required"=>true,
                ],
            ]
        ];
    }
    public function getPasswordUpdate(): array
    {
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "submit"=>"Mettre à jour votre mdp"
            ],
            "inputs"=>[
                "password"=>[
                    "type"=>"password",
                    "placeholder"=>"Votre mot de passe ...",
                    "id"=>"pwdRegister",
                    "class"=>"inputRegister",
                    "required"=>true,
                    "error"=>"Votre mot de passe doit faire entre 8 et 16 et contenir des chiffres et des lettres",
                ],
            ]
        ];
    }
}