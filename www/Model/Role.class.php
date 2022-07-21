<?php
namespace App\Model;

use App\Core\BaseSQL;

class Role extends BaseSQL {
    protected $id = null;
    protected $name;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
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

    public function delete() {
        parent::delete();
    }

    public function getFormCreateRole(): array
    {
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"/admin/roleCreate",
                "submit"=>"Ajouter le rôle",
                "submit-class"=>"btn btn--primary"
            ],
            "inputs"=>[
                "name"=>[
                    "type"=>"text",
                    "id"=>"nameInput",
                    "class"=>"form-input",
                    "label"=>"Nom du rôle",
                    "labelCLass"=>"form-label",
                    "required"=>true,
                    "error"=>"Nom Invalide",
                ],
                "colour"=>[
                    "type"=>"color",
                    "class"=>"color-picker",
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
                    "labelClass"=>"checkbox-label",
                    "required"=>true,
                    "error"=>"Valeur invalide",
                    "checked"=>false
                ],
                "modifyPage"=>[
                    "type"=>"checkbox",
                    "id"=>"modifyPageCheckbox",
                    "class"=>"form-input",
                    "label"=>"Droit de modification de page",
                    "labelClass"=>"checkbox-label",
                    "required"=>true,
                    "error"=>"Valeur invalide",
                    "checked"=>false

                ],
                "deletePage"=>[
                    "type"=>"checkbox",
                    "id"=>"deletePageCheckbox",
                    "class"=>"form-input",
                    "label"=>"Droit de suppression de page",
                    "labelClass"=>"checkbox-label",
                    "required"=>true,
                    "error"=>"Valeur invalide",
                    "checked"=>false

                ],
                "addComment"=>[
                    "type"=>"checkbox",
                    "id"=>"addCommentCheckbox",
                    "class"=>"form-input",
                    "label"=>"Droit d'ajout de commentaires",
                    "labelClass"=>"checkbox-label",
                    "required"=>true,
                    "error"=>"Valeur invalide",
                    "checked"=>false

                ],
                "adminRights"=>[
                    "type"=>"checkbox",
                    "id"=>"adminRightsCheckbox",
                    "class"=>"form-input",
                    "label"=>"Droits d'administration",
                    "labelClass"=>"checkbox-label",
                    "required"=>true,
                    "error"=>"Valeur invalide",
                    "checked"=>false

                ],
            ]
        ];
    }

    public function getFormUpdateRole(): array{
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"/admin/roleUpdate",
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
                "name"=>[
                    "type"=>"text",
                    "id"=>"nameInput",
                    "class"=>"form-input",
                    "label"=>"Nom du rôle",
                    "labelCLass"=>"form-label",
                    "required"=>true,
                    "error"=>"Nom Invalide",
                    "value"=>$this->getName()
                ],
                "colour"=>[
                    "type"=>"color",
                    "class"=>"color-picker",
                    "label"=>"Couleur du rôle",
                    "labelCLass"=>"form-label",
                    "required"=>true,
                    "error"=>"Hexadecimal invalide",
                    "value"=>"#" . $this->getColour()
                ],
                "createPage"=>[
                    "type"=>"checkbox",
                    "id"=>"createPageCheckbox",
                    "class"=>"form-checkbox",
                    "label"=>"Droit de creation de page",
                    "labelClass"=>"checkbox-label",
                    "required"=>true,
                    "error"=>"Valeur invalide",
                    "checked"=>$this->getCreatePage()
                ],
                "modifyPage"=>[
                    "type"=>"checkbox",
                    "id"=>"modifyPageCheckbox",
                    "class"=>"form-input",
                    "label"=>"Droit de modification de page",
                    "labelClass"=>"checkbox-label",
                    "required"=>true,
                    "error"=>"Valeur invalide",
                    "checked"=>$this->getModifyPage()
                ],
                "deletePage"=>[
                    "type"=>"checkbox",
                    "id"=>"deletePageCheckbox",
                    "class"=>"form-input",
                    "label"=>"Droit de suppression de page",
                    "labelClass"=>"checkbox-label",
                    "required"=>true,
                    "error"=>"Valeur invalide",
                    "checked"=>$this->getDeletePage()
                ],
                "addComment"=>[
                    "type"=>"checkbox",
                    "id"=>"addCommentCheckbox",
                    "class"=>"form-input",
                    "label"=>"Droit d'ajout de commentaires",
                    "labelClass"=>"checkbox-label",
                    "required"=>true,
                    "error"=>"Valeur invalide",
                    "checked"=>$this->getAddComment()
                ],
                "adminRights"=>[
                    "type"=>"checkbox",
                    "id"=>"adminRightsCheckbox",
                    "class"=>"form-input",
                    "label"=>"Droits d'administration",
                    "labelClass"=>"checkbox-label",
                    "required"=>true,
                    "error"=>"Valeur invalide",
                    "checked"=>$this->getAdminRights()
                ],
            ]
        ];
    }

    public function getDeleteRole(): array{
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"/admin/roleDelete",
                "submit"=>"Supprimer le rôle",
                "submit-class"=>"btn btn--primary"
            ],
            "inputs"=>[
                "id"=>[
                    "type"=>"hidden",
                    "id"=>"idDeleteRole",
                    "required"=>true,
                    "value"=>$this->getId()
                ],
            ]
        ];
    }
}
?>
