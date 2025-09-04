<?php

namespace Src\LaravelModuleCreate\Templates;

use Src\LaravelModuleCreate\Commons\BaseNames;
use Src\LaravelModuleCreate\Helpers\HandleHelpers;

/**
 * Class CreateBasicScaffold
 * @package Src\LaravelModuleCreate\Templates
 * @extends BaseNames
 */
class CreateBasicScaffold extends BaseNames
{
    const TRAIT = "Trait";
    const MODELS = "Models";
    const PROVIDERS = "Providers";
    const SERVICES = "Services";
    const COMMON = "Commons";
    const TRAITS = "Traits";

    /**
     * @var HandleHelpers
     */
    private HandleHelpers $handleHelper;

    public function __construct()
    {
        $this->handleHelper = new HandleHelpers();
    }

    /**
     * @param string $projectName
     * @param string $moduleName
     * @param string|null $type
     * @return void
     */
    public function createBasicScaffold(string $projectName, string $moduleName, string $type = null): void
    {
        $projectName = $this->handleHelper->handleName($projectName);
        $moduleNameModule = $this->handleHelper->handleS(
            $this->handleHelper->handleName($moduleName)
        );
        $path = parent::BASE_FOLDER . '/' . $projectName . '/' . $moduleNameModule;

        if (file_exists($path)) {
            if (!file_exists(parent::BASE_FOLDER . '/' . $projectName . '/' . self::COMMON)) {
                $this->handleCommon(parent::BASE_FOLDER . '/' . $projectName);
            }

            $this->handleCreateSoftDelete(
                parent::BASE_FOLDER . '/' . $projectName,
                $projectName
            );

            $this->handleCreateModel($path, $projectName, $moduleName);
            $this->handleCreateProvider($path, $projectName, $moduleName);
            $this->handleCreateService($path, $projectName, $moduleName);
        }

        if (!file_exists(parent::BASE_FOLDER . '/' . $projectName)) {
            CreateProject::createProject($projectName);
            self::createBasicScaffold($projectName, $moduleName);
        }

        if (!file_exists($path)) {
            (new CreateModule())->createFullModule($projectName, $moduleName);
            self::createBasicScaffold($projectName, $moduleName);
        }
    }

    /**
     * @param string $path
     * @param string $projectName
     * @return void
     */
    private function handleCreateSoftDelete(string $path, string $projectName): void
    {
        $fileName = "SoftDeletes.php";
        file_put_contents(
            $path . '/' . self::COMMON . '/' . self::TRAITS . '/' . $fileName,
            $this->handleHelper->createSoftDelete($projectName)
        );

        $fullPath = $path . '/' . self::COMMON . '/' . self::TRAITS . '/' . $fileName;
        print_r($this->handleHelper->showMessage($fullPath, "SoftDelete", self::TRAIT));
    }

    /**
     * @param string $path
     * @param string $projectName
     * @param string $moduleName
     * @return void
     */
    private function handleCreateModel(string $path, string $projectName, string $moduleName): void
    {
        $folderName = 'Models';
        $subFolderName = 'Repositories';
        $className = $this->handleHelper->handleName($moduleName);
        $moduleName = $this->handleHelper->handleS($moduleName);
        $fileName = "{$className}.php";
        $fileNameRepository = "{$className}Repository.php";
        $fileNameRepositoryInterface = "{$className}RepositoryInterface.php";

        $this->createFolder($path, $folderName, $subFolderName);
        file_put_contents(
            $path . '/' . $folderName . '/' . $fileName,
            $this->handleHelper->createModel($projectName, $moduleName, $className)
        );
        file_put_contents(
            $path . '/' . $folderName . '/' . $subFolderName . '/' . $fileNameRepository,
            $this->handleHelper->createModelRepository($projectName, $moduleName, $className)
        );
        file_put_contents(
            $path . '/' . $folderName . '/' . $subFolderName . '/' . $fileNameRepositoryInterface,
            $this->handleHelper->createModelRepositoryInterface($projectName, $moduleName, $className)
        );

        $fullPath = $path . '/' . $folderName . '/' . $fileName;
        print_r($this->handleHelper->showMessage($fullPath, $className, self::MODELS));
    }

    /**
     * @param string $path
     * @param string $projectName
     * @param string $moduleName
     * @return void
     */
    private function handleCreateProvider(string $path, string $projectName, string $moduleName): void
    {
        $folderName = 'Providers';
        $fileNameApp = "AppServiceProvider.php";

        $this->createFolder($path, $folderName);
        file_put_contents(
            $path . '/' . $folderName . '/' . $fileNameApp,
            $this->handleHelper->createAppServiceProvider($projectName, $moduleName)
        );
        $fullPath = $path . '/' . $folderName . '/' . $fileNameApp;
        print_r($this->handleHelper->showMessage($fullPath, $fileNameApp, self::PROVIDERS));
    }

    /**
     * @param string $path
     * @param string $projectName
     * @param string $moduleName
     * @return void
     */
    private function handleCreateService(string $path, string $projectName, string $moduleName): void
    {
        $folderName = 'Services';
        $className = $this->handleHelper->handleName($moduleName);
        $moduleName = $this->handleHelper->handleS($moduleName);
        $fileName = "{$className}Service.php";

        $this->createFolder($path, $folderName);
        file_put_contents(
            $path . '/' . $folderName . '/' . $fileName,
            $this->handleHelper->createService($projectName, $moduleName, $className)
        );
        $fullPath = $path . '/' . $folderName . '/' . $fileName;
        print_r($this->handleHelper->showMessage($fullPath, $className, self::SERVICES));
    }

    /**
     * @param string $path
     * @return void
     */
    private function handleCommon(string $path): void
    {
        $this->handleHelper->createDirectory($path . '/' . self::COMMON);
        $this->handleHelper->createDirectory($path . '/' . self::COMMON . '/' . self::TRAITS);
    }

    /**
     * @param string $path
     * @param string $folderName
     * @param string|null $subFolderName
     * @return void
     */
    private function createFolder(string $path, string $folderName, string $subFolderName = null): void
    {
        if (!is_dir($path . '/' . $folderName)) {
            $this->handleHelper->createDirectory($path . '/' . $folderName);
        }

        if (!is_null($subFolderName)) {
            if (!is_dir($path . '/' . $folderName . '/' . $subFolderName)) {
                $this->handleHelper->createDirectory($path . '/' . $folderName . '/' . $subFolderName);
            }
        }
    }
}