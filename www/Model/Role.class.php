<?php
namespace App\Model;

use App\Core\BaseSQL;

class Role extends BaseSQL {
    protected $id = null;
    protected $colour;
    protected $create_page;
    protected $modify_page;
    protected $delete_page;
    protected $add_comment;
    protected $admin_rights;
    protected $is_super_user;
    /**
     * constructor
     */
    public function __construct() {
        parent::__construct();
    }

    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getColour()
    {
        return $this->colour;
    }

    /**
     * @param mixed $colour
     */
    public function setColour($colour): void
    {
        $this->colour = $colour;
    }

    /**
     * @return mixed
     */
    public function getCreatePage()
    {
        return $this->create_page;
    }

    /**
     * @param mixed $create_page
     */
    public function setCreatePage($create_page): void
    {
        $this->create_page = $create_page;
    }

    /**
     * @return mixed
     */
    public function getModifyPage()
    {
        return $this->modify_page;
    }

    /**
     * @param mixed $modify_page
     */
    public function setModifyPage($modify_page): void
    {
        $this->modify_page = $modify_page;
    }


    /**
     * @return mixed
     */
    public function getDeletePage()
    {
        return $this->delete_page;
    }

    /**
     * @param mixed $delete_page
     */
    public function setDeletePage($delete_page): void
    {
        $this->delete_page = $delete_page;
    }

    /**
     * @return mixed
     */
    public function getAddComment()
    {
        return $this->add_comment;
    }

    /**
     * @param mixed $add_comment
     */
    public function setAddComment($add_comment): void
    {
        $this->add_comment = $add_comment;
    }

    /**
     * @return mixed
     */
    public function getAdminRights()
    {
        return $this->admin_rights;
    }

    /**
     * @param mixed $admin_rights
     */
    public function setAdminRights($admin_rights): void
    {
        $this->admin_rights = $admin_rights;
    }

    /**
     * @return mixed
     */
    public function getIsSuperUser()
    {
        return $this->is_super_user;
    }

    /**
     * @param mixed $is_super_user
     */
    public function setIsSuperUser($is_super_user): void
    {
        $this->is_super_user = $is_super_user;
    }

    public function save() {
        parent::save();
    }

    public function getFormCreateRole(): array
    {
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "submit"=>"Ajouter le rôle",
                "submit-class"=>"btn btn--primary"
            ],
            "inputs"=>[
                "colour"=>[
                    "type"=>"text",
                    "id"=>"colourInput",
                    "class"=>"form-input",
                    "label"=>"Couleur du rôle",
                    "labelCLass"=>"form-label",
                    "required"=>true,
                    "error"=>"Hexadecimal invalide"
                 ],
                "createPage"=>[
                    "type"=>"checkbox",
                    "id"=>"createPageCheckbox",
                    "class"=>"form-input",
                    "label"=>"Droit de creation de page",
                    "labelClass"=>"form-label",
                    "required"=>true,
                    "error"=>"Valeur invalide"
                ],
                "modifyPage"=>[
                    "type"=>"checkbox",
                    "id"=>"modifyPageCheckbox",
                    "class"=>"form-input",
                    "label"=>"Droit de modification de page",
                    "labelClass"=>"form-label",
                    "required"=>true,
                    "error"=>"Valeur invalide"
                ],
                "deletePage"=>[
                    "type"=>"checkbox",
                    "id"=>"deletePageCheckbox",
                    "class"=>"form-input",
                    "label"=>"Droit de suppression de page",
                    "labelClass"=>"form-label",
                    "required"=>true,
                    "error"=>"Valeur invalide"
                ],
                "addComment"=>[
                    "type"=>"checkbox",
                    "id"=>"addCommentCheckbox",
                    "class"=>"form-input",
                    "label"=>"Droit d'ajout de commentaires",
                    "labelClass"=>"form-label",
                    "required"=>true,
                    "error"=>"Valeur invalide"
                ],
                "adminRights"=>[
                    "type"=>"checkbox",
                    "id"=>"adminRightsCheckbox",
                    "class"=>"form-input",
                    "label"=>"Droits d'administration",
                    "labelClass"=>"form-label",
                    "required"=>true,
                    "error"=>"Valeur invalide"
                ],
            ]
        ];
    }

    public function getFormUpdateRole(): array{
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "submit"=>"Modifier le rôle",
                "submit-class"=>"btn btn--primary"
            ],
            "inputs"=>[
                "id"=>[
                    "type"=>"hidden",
                    "id"=>"idRole",
                    "required"=>true,
                    "value"=>$this->getId()
                ],
                "colour"=>[
                    "type"=>"text",
                    "id"=>"colourInput",
                    "class"=>"form-input",
                    "label"=>"Couleur du rôle",
                    "labelCLass"=>"form-label",
                    "required"=>true,
                    "error"=>"Hexadecimal invalide"
                ],
                "createPage"=>[
                    "type"=>"checkbox",
                    "id"=>"createPageCheckbox",
                    "class"=>"form-input",
                    "label"=>"Droit de creation de page",
                    "labelClass"=>"form-label",
                    "required"=>true,
                    "error"=>"Valeur invalide"
                ],
                "modifyPage"=>[
                    "type"=>"checkbox",
                    "id"=>"modifyPageCheckbox",
                    "class"=>"form-input",
                    "label"=>"Droit de modification de page",
                    "labelClass"=>"form-label",
                    "required"=>true,
                    "error"=>"Valeur invalide"
                ],
                "deletePage"=>[
                    "type"=>"checkbox",
                    "id"=>"deletePageCheckbox",
                    "class"=>"form-input",
                    "label"=>"Droit de suppression de page",
                    "labelClass"=>"form-label",
                    "required"=>true,
                    "error"=>"Valeur invalide"
                ],
                "addComment"=>[
                    "type"=>"checkbox",
                    "id"=>"addCommentCheckbox",
                    "class"=>"form-input",
                    "label"=>"Droit d'ajout de commentaires",
                    "labelClass"=>"form-label",
                    "required"=>true,
                    "error"=>"Valeur invalide"
                ],
                "adminRights"=>[
                    "type"=>"checkbox",
                    "id"=>"adminRightsCheckbox",
                    "class"=>"form-input",
                    "label"=>"Droits d'administration",
                    "labelClass"=>"form-label",
                    "required"=>true,
                    "error"=>"Valeur invalide"
                ],
            ]
        ];
    }

    public function deleteRole(): array{
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "submit"=>"Supprimer le rôle",
                "submit-class"=>"btn btn--primary"
            ],
        ];
    }
}
?>
