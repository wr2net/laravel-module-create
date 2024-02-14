<?php

namespace App\LaravelModuleCreate\Templates;

use App\LaravelModuleCreate\Commons\BaseNames;
use App\LaravelModuleCreate\Helpers\HandleHelpers;

/**
 * Class CreateScaffold
 * @package App\LaravelModuleCreate\Templates
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
    const COMMON = "Common";
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
     * @return void
     */
    public function createScaffold(string $projectName, string $moduleName): void
    {
        $projectName = $this->handleHelper->handleName($projectName);
        $moduleName = $this->handleHelper->handleName($moduleName);
        $path = parent::BASE_FOLDER . '/' . $projectName . '/' . $moduleName;

        if (file_exists($path)) {
            if (!file_exists(parent::BASE_FOLDER . '/' . $projectName . '/' . self::COMMON)) {
                $this->handleCommon(parent::BASE_FOLDER . '/' . $projectName);
            }

            $this->handleCreateSoftDelete(
                parent::BASE_FOLDER . '/' . $projectName,
                $projectName
            );
            $this->handleCreateRouteServiceProviderTrait(
                parent::BASE_FOLDER . '/' . $projectName,
                $projectName
            );

            $this->handleCreateController($path, $projectName, $moduleName);
            $this->handleCreateModel($path, $projectName, $moduleName);
            $this->handleCreateProvider($path, $projectName, $moduleName);
            $this->handleCreateRequest($path, $projectName, $moduleName);
            $this->handleCreateResource($path, $projectName, $moduleName);
            $this->handleCreateRoute($path, $moduleName);
            $this->handleCreateService($path, $projectName, $moduleName);
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
     * @return void
     */
    private function handleCreateRouteServiceProviderTrait(string $path, string $projectName): void
    {
        $fileName = "RouteServiceProviderTrait.php";
        file_put_contents(
            $path . '/' . self::COMMON . '/' . self::TRAITS . '/' . $fileName,
            $this->handleHelper->createRouteProviderTrait($projectName)
        );

        $fullPath = $path . '/' . self::COMMON . '/' . self::TRAITS . '/' . $fileName;
        print_r($this->handleHelper->showMessage(
            $fullPath,
            "RouteServiceProviderTrait",
            self::TRAIT
        ));
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

        $this->createFolder($path, $folderName, $subFolderName);
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
        $fileNameRoute = "RouteServiceProvider.php";

        $this->createFolder($path, $folderName);
        file_put_contents(
            $path . '/' . $folderName . '/' . $fileNameApp,
            $this->handleHelper->createAppServiceProvider($projectName, $moduleName)
        );
        $fullPath = $path . '/' . $folderName . '/' . $fileNameApp;
        print_r($this->handleHelper->showMessage($fullPath, $fileNameApp, self::PROVIDERS));

        file_put_contents(
            $path . '/' . $folderName . '/' . $fileNameRoute,
            $this->handleHelper->createRouteServiceProvider($projectName, $moduleName)
        );
        $fullPath = $path . '/' . $folderName . '/' . $fileNameRoute;
        print_r($this->handleHelper->showMessage($fullPath, $fileNameRoute, self::PROVIDERS));
    }

    /**
     * @param string $path
     * @param string $projectName
     * @param string $moduleName
     * @return void
     */
    private function handleCreateRequest(string $path, string $projectName, string $moduleName): void
    {
        $folderName = 'Requests';
        $className = "{$this->handleHelper->handleS($moduleName)}";
        $fileName = "{$className}Request.php";

        $this->createFolder($path, $folderName);
        file_put_contents(
            $path . '/' . $folderName . '/' . $fileName,
            $this->handleHelper->createRequest($projectName, $moduleName, $className)
        );

        $fullPath = $path . '/' . $folderName . '/' . $fileName;
        print_r($this->handleHelper->showMessage($fullPath, $className, self::REQUESTS));
    }

    /**
     * @param string $path
     * @param string $projectName
     * @param string $moduleName
     * @return void
     */
    private function handleCreateResource(string $path, string $projectName, string $moduleName): void
    {
        $folderName = 'Resources';
        $className = $this->handleHelper->handleS($moduleName);
        $fileNameCollection = "{$className}Collection.php";
        $fileNameResource = "{$className}Resource.php";

        $this->createFolder($path, $folderName);
        file_put_contents(
            $path . '/' . $folderName . '/' . $fileNameCollection,
            $this->handleHelper->createCollection($projectName, $moduleName, $className)
        );
        $fullPath = $path . '/' . $folderName . '/' . $fileNameCollection;
        print_r($this->handleHelper->showMessage($fullPath, $className . "Collection", self::RESOURCES));

        file_put_contents(
            $path . '/' . $folderName . '/' . $fileNameResource,
            $this->handleHelper->createResource($projectName, $moduleName, $className)
        );
        $fullPath = $path . '/' . $folderName . '/' . $fileNameResource;
        print_r($this->handleHelper->showMessage($fullPath, $className . "Resource", self::RESOURCES));
    }

    /**
     * @param string $path
     * @param string $moduleName
     * @return void
     */
    private function handleCreateRoute(string $path, string $moduleName): void
    {
        $folderName = 'Routes';
        $className = "{$this->handleHelper->handleS($moduleName)}";

        $this->createFolder($path, $folderName);
        file_put_contents(
            $path . '/' . $folderName . '/api.php',
            $this->handleHelper->createRouteApi($moduleName, $className)
        );
        $fullPath = $path . '/' . $folderName . '/api.php';
        print_r($this->handleHelper->showMessage($fullPath, "api.php", self::ROUTES));

        file_put_contents(
            $path . '/' . $folderName . '/web.php',
            $this->handleHelper->createRouteWeb($moduleName, $className)
        );
        $fullPath = $path . '/' . $folderName . '/web.php';
        print_r($this->handleHelper->showMessage($fullPath, "web.php", self::ROUTES));
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
        $className = $this->handleHelper->handleS($moduleName);
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
        mkdir($path . '/' . self::COMMON);
        mkdir($path . '/' . self::COMMON . '/' . self::TRAITS);
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
            mkdir($path . '/' . $folderName);
        }

        if (!is_null($subFolderName)) {
            if (!is_dir($path . '/' . $folderName . '/' . $subFolderName)) {
                mkdir($path . '/' . $folderName . '/' . $subFolderName);
            }
        }
    }
}