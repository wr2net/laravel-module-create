<?php

namespace Wagner\LaravelModuleCreate\Helpers;

/**
 * Class HandleHelpers
 * @package Wagner\LaravelModuleCreate\Helpers
 */
class HandleHelpers
{
    const PROJECT = "P";
    const MODULE = "M";
    const SCAFFOLD = "S";
    const YELLOW = "\033[33m";
    const CYAN = "\033[36m";
    const GREEN = "\033[32m";
    const PURPLE = "\033[35m";
    const RED = "\033[31m";
    const NC = "\033[0m";

    /**
     * @var CreateTraitSoftDelete
     */
    private CreateTraitSoftDelete $forCreateTraitSoftDelete;

    /**
     * @var CreateController
     */
    private CreateController $forCreateController;

    /**
     * @var CreateModel
     */
    private CreateModel $forCreateModel;

    public function __construct()
    {
        $this->forCreateController = new CreateController();
        $this->forCreateTraitSoftDelete = new CreateTraitSoftDelete();
        $this->forCreateModel = new CreateModel();
    }

    /**
     * @param string $name
     * @return string
     */
    public function handleName(string $name): string
    {
        $name = strtolower($name);
        $aux = str_replace(' ', '', $name);
        if ($name !== $aux) {
            $name = ucwords($name);
            return str_replace(' ', '', $name);
        }

        return ucfirst($name);
    }

    /**
     * @param $name
     * @return string
     */
    public function handleS($name): string
    {
        if (str_ends_with($name, "s")) {
            return substr($name, 0, -1);
        }
        return $name;
    }

    /**
     * @param string $projectName
     * @return string
     */
    public function createSoftDelete(string $projectName): string
    {
        return $this->forCreateTraitSoftDelete->toTraitSoftDelete($projectName);
    }

    /**
     * @param string $projectName
     * @param string $moduleName
     * @param string $className
     * @return string
     */
    public function createController(string $projectName, string $moduleName, string $className): string
    {
        return $this->forCreateController->toController($projectName, $moduleName, $className);
    }

    /**
     * @param string $projectName
     * @param string $moduleName
     * @param string $className
     * @return string
     */
    public function createModel(string $projectName, string $moduleName, string $className): string
    {
        return $this->forCreateModel->toModel($projectName, $moduleName, $className);
    }

    /**
     * @param string $projectName
     * @param string $moduleName
     * @param string $className
     * @return string
     */
    public function createModelRepository(string $projectName, string $moduleName, string $className): string
    {
        return $this->forCreateModel->toModelRepository($projectName, $moduleName, $className);
    }

    /**
     * @param string $projectName
     * @param string $moduleName
     * @param string $className
     * @return string
     */
    public function createModelRepositoryInterface(string $projectName, string $moduleName, string $className): string
    {
        return $this->forCreateModel->toModelRepositoryInterface($projectName, $moduleName, $className);
    }

    /**
     * @param string $type
     * @param int $stage
     * @param string|null $toShow
     * @return void
     */
    public function beginOrEnd(string $type, int $stage, string $toShow = null):void
    {
        $inStage = [
            "Starting",
            "Finished"
        ];

        switch ($type) {
            case self::PROJECT:
                echo self::CYAN .
                    "{$inStage[$stage]} Configuration your Project: {$this->handleName($toShow)}\n" .
                    self::NC;
                break;
            case self::MODULE:
                echo self::PURPLE .
                    "{$inStage[$stage]} Configuration your Module: {$this->handleName($toShow)}\n" .
                    self::NC;
                break;
            case self::SCAFFOLD:
                echo self::YELLOW .
                    "{$inStage[$stage]} Configuration your Module Resource: {$this->handleName($toShow)}\n" .
                    self::NC;
                break;
            default:
                break;
        }
    }

    /**
     * @param string $fullPath
     * @param string $moduleName
     * @param string $type
     * @return string
     */
    public function showMessage(string $fullPath, string $moduleName, string $type = ""): string
    {
        if (file_exists($fullPath)) {
            return self::GREEN . "{$moduleName}{$type} created Successfully!\n" . self::NC;
        }

        return self::RED . "\033[30mCreate {$moduleName}{$type} Failed!\n" . self::NC;
    }
}