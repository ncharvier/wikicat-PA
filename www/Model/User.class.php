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
    protected $connectionToken = null;
    protected $validationToken = null;
    protected $passwordForgetToken = null;

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
        $_SESSION["connectedUser"]["token"] = $this->getConnectionToken();
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
     * @return mixed
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->email = strtolower(trim($role));
    }

    /**
     * @return string
     */
    public function getConnectionToken(): ?string
    {
        return $this->connectionToken;
    }

    /**
     * @return string
     */
    public function getValidationToken(): ?string
    {
        return $this->validationToken;
    }

    /**
     * @return string
     */
    public function getPasswordForgetToken(): ?string
    {
        return $this->passwordForgetToken;
    }

    /**
     * @param string
     * Token char 32
     */
    private function generateToken(): string
    {
        return str_shuffle(md5(uniqid()));
    }

    public function generateConnectionToken(): void{
        $this->connectionToken = $this->generateToken();
    }

    public function generatePasswordForgetToken(): void{
        $this->passwordForgetToken = $this->generateToken();
    }

    public function generateValidationToken(): void{
        $this->validationToken = $this->generateToken();
    }

    public function clearConnectionToken(): void{
        $this->connectionToken = null;
    }

    public function clearValidationToken(): void{
        $this->validationToken = null;
    }

    public function clearToken(): void{
        $this->connectionToken = null;
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
                "submit"=>"S'inscrire",
                "submit-class"=>"btn btn--primary"
            ],
            "inputs"=>[
                "login"=>[
                    "type"=>"text",
                    "placeholder"=>"Pseudonyme",
                    "id"=>"loginRegister",
                    "class"=>"form-input",
                    "label"=>"Pseudonyme",
                    "labelClass"=>"form-label",
                    "required"=>true,
                    "error"=>"Pseudonyme invalide"
                ],
                "email"=>[
                    "type"=>"email",
                    "placeholder"=>"Votre email ...",
                    "id"=>"emailRegister",
                    "class"=>"form-input",
                    "label"=>"Email",
                    "labelClass"=>"form-label",
                    "required"=>true,
                    "error"=>"Email incorrect",
                    "unicity"=>true,
                    "errorUnicity"=>"Un compte existe déjà sur cette adresse email"
                ],
                "password"=>[
                    "type"=>"password",
                    "placeholder"=>"Votre mot de passe ...",
                    "id"=>"pwdRegister",
                    "class"=>"form-input",
                    "label"=>"Mot de passe",
                    "labelClass"=>"form-label",
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
                "submit"=>"Se connecter",
                "submit-class"=>"btn btn--primary"
            ],
            "inputs"=>[
                "email"=>[
                    "type"=>"email",
                    "placeholder"=>"Votre email ...",
                    "id"=>"emailRegister",
                    "class"=>"form-input",
                    "label"=>"Email",
                    "labelClass"=>"form-label",
                    "required"=>true,
                ],
                "password"=>[
                    "type"=>"password",
                    "placeholder"=>"Votre mot de passe ...",
                    "id"=>"pwdRegister",
                    "class"=>"form-input",
                    "label"=>"Mot de passe",
                    "labelClass"=>"form-label",
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

    public function getForgotPassword(): array {
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "submit"=>"Mot de passe oublié ?"
            ],
            "inputs"=>[
                "email"=>[
                    "type"=>"email",
                    "placeholder"=>"email linked to the account",
                    "id"=>"recoveryEmail",
                    "class"=>"inputEmail",
                    "required"=>true,
                ],
            ]
        ];
    }

    public function getChangePassword(): array{
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"changePassword",
                "submit"=>"Changer votre mot passe"
            ],
            "inputs"=>[
                "password"=>[
                    "type"=>"password",
                    "placeholder"=>"Votre nouveau mot de passe",
                    "id"=>"pwdChangePassword",
                    "class"=>"inputChangePassword",
                    "required"=>true,
                    "error"=>"Votre mot de passe doit faire entre 8 et 16 et contenir des chiffres et des lettres",
                ],
            ]
        ];
    }

    public function formAdminActiveUser(): array {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/adminActiveUser",
                "submit"=>"Activer",
                "submit-class"=>"btn btn--primary d-block w-100"
            ],
            "inputs" => [
                "userId" => [
                    "type" => "hidden",
                    "id" => "userId",
                    "value" => $this->getId()
                ],
            ]
        ];
    }

    public function formAdminBanUser(): array {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/adminBanUser",
                "submit"=>"Bannir",
                "submit-class"=>"btn btn--primary d-block w-100"
            ],
            "inputs" => [
                "userId" => [
                    "type" => "hidden",
                    "id" => "userId",
                    "value" => $this->getId()
                ],
            ]
        ];
    }

    public function formAdminDeleteUser(): array {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/adminBanUser",
                "submit"=>"Supprimer",
                "submit-class"=>"btn btn--primary d-block w-100"
            ],
            "inputs" => [
                "userId" => [
                    "type" => "hidden",
                    "id" => "userId",
                    "value" => $this->getId()
                ],
            ]
        ];
    }

    public function formAdminResetPasswordUser(): array {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/adminResetPasswordUser",
                "submit"=>"Changer mot de passe",
                "submit-class"=>"btn btn--primary d-block w-100"
            ],
            "inputs" => [
                "userId" => [
                    "type" => "hidden",
                    "id" => "userId",
                    "value" => $this->getId()
                ],
                "password"=>[
                    "type"=>"password",
                    "placeholder"=>"Changer le mot de passe",
                    "id"=>"password",
                    "class"=>"form-input-back",
                    "error"=>"Votre mot de passe doit faire entre 8 et 16 et contenir des chiffres et des lettres",
                ],
            ]
        ];
    }
}
