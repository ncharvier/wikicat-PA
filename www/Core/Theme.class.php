<?php
namespace App\Core;

class Theme {
    protected $name = "";
    protected $content = "";

    public function __construct() {
        // temporaire le temps de faire l'installeur
        if (!file_exists(PATHTMP))
            mkdir(PATHTMP);
    }

    /**
     * get theme with name
     * @param string name
     * @return void
     */
    public function getByName(string $name): void {
        $fullPath = PATH.'/'.$name.'.json';
        $content = "";
        if (file_exists($fullPath)) {
            $content = file_get_contents($fullPath);
            $this->setName($name);
            $this->setContent($content);
        }
    }

    /**
     * return list of existing theme name
     * @return string[] | bool
     */
    public static function getThemeList() {
        $dirName = [];
        $name = "";
        $nameId = 0;
        $dir = scandir(PATH);
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
     * create a zip archive
     * @param string archiveName
     * @return int error code (0 == good, 1 == file doesn't exist, 2 == can't open file)
     */
    public function compressToZip(string $archiveName): int {
        $fullPath = PATH.'/'.$this->name;
        if (!file_exists($fullPath.'.css') || !file_exists($fullPath.'.json'))
            return 1;

        $zip = new \ZipArchive;
        if($zip->open(PATHTMP."/$archiveName", \ZipArchive::CREATE) !== TRUE)
            return 2;

        $zip->addFile($fullPath.'.css', $this->name.'.css');
        $zip->addFile($fullPath.'.json', $this->name.'.json');
        $zip->close();

        return 0;
    }

    /**
     * return true if name exist 
     * @param string name
     * @return bool
     */
    public static function exist(string $name): bool {
        $fullPath = PATH.'/'.$name.'.json';
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
     * @param string content
     */
    public function setContent(string $content): void {
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
    public function save(): void {
        $fullPathCss = PATH.'/'.$this->name.'.css';
        $fullPathJson = PATH.'/'.$this->name.'.json';
        $content = $this->formatToCss($this->content);

        file_put_contents($fullPathCss, $content);
        file_put_contents($fullPathJson, $this->content);
    }

    /**
     * delete a theme
     * @param string name
     * @return void
     */
    public static function delete(string $name): void {
        $fullPathCss = PATH."/$name.css";
        $fullPathJson = PATH."/$name.json";
        if (file_exists($fullPathCss) && file_exists($fullPathJson)) {
            unlink($fullPathCss);
            unlink($fullPathJson);
        }
    }
}
