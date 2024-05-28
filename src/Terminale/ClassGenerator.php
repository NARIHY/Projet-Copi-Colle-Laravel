<?php 
namespace Src\Terminale;

/**
 * Firegenereena class ity
 * class reniny
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 NARIHY
 */
class ClassGenerator 
{
    /** @var string $nomClass Nom de la class */
    private string $nomClass;
    /** @var string $parentClassName Nom de la class parent */
    private string $parentClassName;
    /** @var string $namespace le namespace */
    private string $namespace;
    /** @var string $outputDirectory Chemin de retour  */
    private string $outputDirectory;

    public function __construct(string $nomClass, string $parentClassName = 'BaseForm', string $namespace = 'App\\Form', string $outputDirectory = 'app/Form')
    {
        $this->nomClass = $nomClass;
        $this->parentClassName = $parentClassName;
        $this->namespace = $namespace;
        $this->outputDirectory = $outputDirectory;
    }

 /**
     * Ahafahana miregenerer class iray hafa isika eto izay atao ao aminy terminale
     */
    public function generate()
    {
        $classTemplate = "<?php\n\n";
        if(!empty($this->namespace)) {
            $classTemplate .= "namespace ". $this->namespace. ";\n\n";
        }
        $classTemplate .= "class ". $this->nomClass ."\n";
        $classTemplate .= "{\n";
        $classTemplate .= "\n"; //Atao eto ny propriete na ny methode
        $classTemplate .= "}\n";
        //tadiavina ny toerana asiana anilay class
        if(!file_exists($this->outputDirectory)) {
            // mkdir($this->outputDirectory,0777,true);
        }
        $fileName = $this->outputDirectory. DIRECTORY_SEPARATOR. $this->nomClass .'.php';
        //Ampidirina na soratana ilay contenu ireo atao ao anatiny ilay fichier ho creena
        file_put_contents($fileName,$classTemplate);
    }


    /**
     * Regenerer un class pour un formulaire
     */
    public function generate_formulaire(array $props)
    {
        // Template pour la classe PHP
        $classTemplate = "<?php\n\n";
        // Namespace
        if (!empty($this->namespace)) {
            $classTemplate .= "namespace " . $this->namespace . ";\n\n";
        }
        $classTemplate .= "use Src\\Form\\BaseForm;\n\n";
        // Définition de la classe
        $classTemplate .= "class " . $this->nomClass . "Form extends " . $this->parentClassName . "\n";
        $classTemplate .= "{\n";
        // Méthode test
        $classTemplate .= "    public function element()\n";
        $classTemplate .= "    {\n";
        $classTemplate .= "        return [\n";
        foreach($props as $key => $value) {
            $classTemplate .= "            '$key' => [\n";
            foreach($value as $subKey => $subValue) {
                $classTemplate .= "                '$subKey' => '$subValue',\n";
            }
            $classTemplate .= "            ],\n";
        }
        $classTemplate .= "        ];\n";
        $classTemplate .= "    }\n\n";
        $classTemplate .= "}\n";

        // Chemin où la classe sera créée
        if (!file_exists($this->outputDirectory)) {
            mkdir($this->outputDirectory, 0777, true);
        }
        $fileName = $this->outputDirectory . DIRECTORY_SEPARATOR . $this->nomClass . 'Form.php';
        // Écriture du contenu dans le fichier
        file_put_contents($fileName, $classTemplate);
    }
}
