<?php

namespace Src\Console\Commands;

use RuntimeException;

class MakeCommand extends Command
{

    private string $stubPrefix="Src/Console/Files/Stubs/";

    private string $stub;
    private array $stubs=[
        "model" => "model.stub",
        "controller" => "controller.stub",
        "middleware" => "middleware.stub",
        "migration" => "migration.stub",
    ];

    private array $targetDirs=[
        "model" => "app/models",
        "controller" => "app/http/controllers",
        "middleware" => "app/http/middlewares",
        "migration" => "database/migrations",
    ];
    public function handle(string $type, string $name)
    {
        $this->initStubPaths();
        $this->setStub($type);

        $targetDir=$this->targetDirs[$type];
        $createdFile=$this->createStringFile($name, $type) ;
        $this->createFile($name, $createdFile, $targetDir);

        echo $type . " added successfully.\n";
    }

    private function initStubPaths():void
    {
        foreach($this->stubs as $stub=>$path)
        {
            $this->stubs[$stub]=$this->stubPrefix . $path;
        }
    }

    private function setStub(string $type):void
    {

        $stubPath=$this->stubs[$type];
        //die($stubPath);
        if (!file_exists($stubPath)) {
            throw new RuntimeException("Stub file not found: {$stubPath}");
        }

        $content = file_get_contents($stubPath);

        if ($content === false) {
            throw new RuntimeException("Unable to read stub file: {$path}");
        }
        $this->stub=$content;
    }

    private function createStringFile(string $name, string $type):string
    {
        if($type == "migration")
            return $this->stub;
        return str_replace("{Name}", $name, $this->stub);
    }

    private function createFile(string $name,  string $fileContent, string $targetDir): void
    {
        // Ensure directory exists
        //die($targetDir);
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $filePath = $targetDir .  "/" . $name . '.php';

        // Prevent overwriting existing files
        if (file_exists($filePath)) {
            throw new RuntimeException("File already exists: {$filePath}");
        }

        if (file_put_contents($filePath, $fileContent) === false) {
            throw new RuntimeException("Failed to create file: {$filePath}");
        }
    }

}