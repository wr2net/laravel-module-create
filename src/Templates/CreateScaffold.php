<?php

namespace Wagner\LaravelModuleCreate\Templates;

use Wagner\LaravelModuleCreate\Commons\BaseNames;
use Wagner\LaravelModuleCreate\Helpers\HandleHelpers;

/**
 * Class CreateScaffold
 * @package Wagner\LaravelModuleCreate\Templates
 * @extends BaseNames
 */
class CreateScaffold extends BaseNames
{
    const TRAIT = "Trait";
    const CONTROLLER = "Controller";
    const MODELS = "Models";
    const PROVIDERS = "Providers";
    const REQUESTS = "Requests";
    const RESOURCES = "Resources";
    const ROUTES = "Routes";
    const SERVICES = "Services";

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
     * @return void
     */
    public function createScaffold(string $projectName, string $moduleName): void
    {
        $projectName = $this->handleHelper->handleName($projectName);
        $moduleName = $this->handleHelper->handleName($moduleName);
        $path = parent::BASE_FOLDER . '/' . $projectName . '/' . $moduleName;

        if (file_exists($path)) {
            $this->handleCreateSoftDelete(
                parent::BASE_FOLDER . '/' . $projectName,
                $projectName
            );
            $this->handleCreateController($path, $projectName, $moduleName);
            $this->handleCreateModel($path, $projectName, $moduleName);
//            $this->handleCreateProvider($path);
//            $this->handleCreateRequest($path, $projectName, $moduleName);
//            $this->handleCreateResource($path, $projectName, $moduleName);
//            $this->handleCreateRoute($path);
//            $this->handleCreateService($path, $projectName, $moduleName);
        }

        if (!file_exists(parent::BASE_FOLDER . '/' . $projectName)) {
            CreateProject::createProject($projectName);
            self::createScaffold($projectName, $moduleName);
        }

        if (!file_exists($path)) {
            $module = new CreateModule();
            $module->createFullModule($projectName, $moduleName);
            self::createScaffold($projectName, $moduleName);
        }
    }

    /**
     * @param string $path
     * @param string $projectName
     * @return void
     */
    private function handleCreateSoftDelete(string $path, string $projectName): void
    {
        $folderName = 'Common';
        $subFolderName = 'Traits';
        $fileName = "SoftDeletes.php";

        mkdir($path . '/' . $folderName);
        mkdir($path . '/' . $folderName . '/' . $subFolderName);
        file_put_contents(
            $path . '/' . $folderName . '/' . $subFolderName . '/' . $fileName,
            $this->handleHelper->createSoftDelete($projectName)
        );

        $fullPath = $path . '/' . $folderName . '/' . $subFolderName . '/' . $fileName;
        print_r($this->handleHelper->showMessage($fullPath, "SoftDelete", self::TRAIT));
    }

    /**
     * @param string $path
     * @param string $projectName
     * @param string $moduleName
     * @return void
     */
    private function handleCreateController(string $path, string $projectName, string $moduleName): void
    {
        $folderName = 'Controllers';
        $subFolderName = 'Api';
        $className = "{$this->handleHelper->handleS($moduleName)}";
        $fileName = "{$className}Controller.php";

        mkdir($path . '/' . $folderName);
        mkdir($path . '/' . $folderName . '/' . $subFolderName);
        file_put_contents(
            $path . '/' . $folderName . '/' . $subFolderName . '/' . $fileName,
            $this->handleHelper->createController($projectName, $moduleName, $className)
        );

        $fullPath = $path . '/' . $folderName . '/' . $subFolderName . '/' . $fileName;
        print_r($this->handleHelper->showMessage($fullPath, $className, self::CONTROLLER));
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
        $className = $this->handleHelper->handleS($moduleName);
        $fileName = "{$className}.php";
        $fileNameRepository = "{$className}Repository.php";
        $fileNameRepositoryInterface = "{$className}RepositoryInterface.php";

        mkdir($path . '/' . $folderName);
        mkdir($path . '/' . $folderName . '/' . $subFolderName);
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
     * @return void
     */
    private function handleCreateProvider(string $path): void
    {
        mkdir($path . '/Providers');
    }

    /**
     * @param string $path
     * @param string $projectName
     * @param string $moduleName
     * @return void
     */
    private function handleCreateRequest(string $path, string $projectName, string $moduleName): void
    {
        mkdir($path . '/Requests');
    }

    /**
     * @param string $path
     * @param string $projectName
     * @param string $moduleName
     * @return void
     */
    private function handleCreateResource(string $path, string $projectName, string $moduleName): void
    {
        mkdir($path . '/Resources');
    }

    /**
     * @param string $path
     * @return void
     */
    private function handleCreateRoute(string $path): void
    {
        mkdir($path . '/Routes');
    }

    /**
     * @param string $path
     * @param string $projectName
     * @param string $moduleName
     * @return void
     */
    private function handleCreateService(string $path, string $projectName, string $moduleName): void
    {
        mkdir($path . '/Services');
    }
}