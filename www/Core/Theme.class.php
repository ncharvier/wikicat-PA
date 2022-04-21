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
     * TODO : finir getByName
     * get theme with name
     * @param string name
     * @return void
     */
    public function getByName(string $name): void {
        /* $fullPath = $this->path.'/'.$name.'.css'; */
        /* if (file_exists($fullPath)) { */
        /*     $this->setName($name); */
        /*     $this->setContent(); */
        /* } */
    }

    /**
     * return list of existing theme name
     * @return string[] | bool
     */
    public function getThemeList() {
        $dirName = [];
        $name = "";
        $nameId = 0;
        $dir = scandir($this->path);
        unset($dir[0]);
        unset($dir[1]);

        foreach ($dir as $k => $v) {
            $name = explode('/', $v);
            $nameId = count($name) - 1;
            $dirName[] = explode('.', $name[$nameId])[0];
        }

        return $dirName;
    }

    /**
     * return true if name exist 
     * @param string name
     * @return bool
     */
    public function exist(string $name): bool {
        $fullPath = $this->path.'/'.$name.'.css';
        return file_exists($fullPath);
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
    public function save() {
        $fullPath = $this->path.'/'.$this->name.'.css';
        $content = $this->formatToCss($this->content);
        file_put_contents($fullPath, $content);
    }
}
