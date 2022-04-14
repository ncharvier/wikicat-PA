<?php
namespace App\Core;


class Theme {
    protected $name = "";
    protected $content = "";
    private $path = "";

    public function __construct() {
        $this->path = dirname(__FILE__).'/../Assets/themes/';
    }

    /**
     * return theme with name
     * @param string name
     * @return ?object
     */
    public function getByName(string $name): ?object {
        // TODO : faire fonction getByName
    }

    /**
     * return true if name exist 
     * @param string name
     * @return bool
     */
    public function exist(string $name): bool {
        // TODO : faire fonction exist
    }

    /**
     * get the name of the theme
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }
    
    /**
     * set the name of the theme
     * @param string name
     * @return void
     */
    public function setName(string $name): void {
        $this->name = trim($name);
    }

    /**
     * set the content
     * @param string cotent
     */
    public function setContent(string $content) {
        $this->content = $content;
    }

    /**
     * return the content
     * @return string
     */
    public function getContent(): string {
        return $this->content;
    }

    /**
     * get path of directory of themes
     * @return string
     */
    public function getPath(): string {
        return $this->path;
    }

    /**
     * format to css
     * @return string
     */
    private function formatToCss(): string {
        $contentJson = json_decode($this->getContent());
        $contentCss = "";

        foreach ($contentJson as $k => $v) {
            $contentCss .= ".$k {\n";
            $contentCss .= "    css-attr: $v;\n";
            $contentCss .= "}\n";
        }

        return $contentCss;
    }

    /**
     * format and save content in css file
     * @return void
     */
    public function save()
    {
        echo '<code>'.$this->formatToCss().'</code>';
    }
}
