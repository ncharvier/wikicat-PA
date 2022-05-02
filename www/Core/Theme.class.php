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
     * get theme with name
     * @param string name
     * @return void
     */
    public function getByName(string $name): void {
        $fullPath = $this->path.'/'.$name.'.json';
        $content = "";
        if (file_exists($fullPath)) {
            $content = json_encode(file_get_contents($fullPath));
            $this->setName($name);
            $this->setContent($content);
        }
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
        $tmp = [];
        unset($dir[0]);
        unset($dir[1]);

        foreach ($dir as $k => $v) {
            $name = explode('/', $v);
            $nameId = count($name) - 1;
            $tmp = explode('.', $name[$nameId]);

            if ($tmp[1] == "json")
                $dirName[] = $tmp[0];
        }

        return $dirName;
    }

    /**
     * return true if name exist 
     * @param string name
     * @return bool
     */
    public function exist(string $name): bool {
        $fullPath = $this->path.'/'.$name.'.json';
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
        $fullPathCss = $this->path.'/'.$this->name.'.css';
        $fullPathJson = $this->path.'/'.$this->name.'.json';
        $content = $this->formatToCss($this->content);

        file_put_contents($fullPathCss, $content);
        file_put_contents($fullPathJson, $this->content);
    }
}
