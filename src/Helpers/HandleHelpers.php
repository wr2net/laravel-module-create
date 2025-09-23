<?php

namespace Src\LaravelModuleCreate\Helpers;

use Src\LaravelModuleCreate\Commons\BaseNames;

/**
 * Class HandleHelpers
 * @package Src\LaravelModuleCreate\Helpers
 */
class HandleHelpers extends BaseNames
{
    const PROJECT = "P";
    const MODULE = "M";
    const SCAFFOLD = "S";
    const BASIC = "B";
    const YELLOW = "\033[33m";
    const CYAN = "\033[36m";
    const GREEN = "\033[32m";
    const PURPLE = "\033[35m";
    const RED = "\033[31m";
    const NC = "\033[0m";

    /**
     * @var array
     */
    private array $addES = [
        'ch',
        's',
        'ss',
        'sh',
        'x',
        'z'
    ];

    /**
     * @var array
     */
    private array $addVES = [
        'f',
        'fe'
    ];

    /**
     * @var array
     */
    private array $vowels = [
        'a',
        'e',
        'i',
        'o',
        'u',
    ];

    /**
     * @var CreateTraits
     */
    private CreateTraits $forCreateTraitSoftDelete;

    /**
     * @var CreateController
     */
    private CreateController $forCreateController;

    /**
     * @var CreateModel
     */
    private CreateModel $forCreateModel;

    /**
     * @var CreateProvider
     */
    private CreateProvider $forCreateProvider;

    /**
     * @var CreateRequest
     */
    private CreateRequest $forCreateRequest;

    /**
     * @var CreateResource
     */
    private CreateResource $forCreateResource;

    /**
     * @var CreateRoute
     */
    private CreateRoute $forCreateRoute;

    /**
     * @var CreateService
     */
    private CreateService $forCreateService;

    public function __construct()
    {
        $this->forCreateController = new CreateController();
        $this->forCreateTraitSoftDelete = new CreateTraits();
        $this->forCreateModel = new CreateModel();
        $this->forCreateProvider = new CreateProvider();
        $this->forCreateRequest = new CreateRequest();
        $this->forCreateResource = new CreateResource();
        $this->forCreateRoute = new CreateRoute();
        $this->forCreateService = new CreateService();
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
        $origin = $name;
        $char3 = substr($name, -3);
        $char2 = substr($name, -2);
        $char1 = substr($name, -1);

        if (in_array($char2, $this->addES) || in_array($char1, $this->addES)) {
            $name = $name . 'es';
        }

        if (in_array($char2, $this->addVES) || in_array($char1, $this->addVES)) {
            $len = strlen($name);
            $check = substr($char2, 1);
            $count = $len - 2;
            $prefix = substr($name, 0, $count);
            if ($check != 'e') {
                $count = $len - 1;
                $prefix = substr($name, 0, $count);
            }
            $name = $prefix . 'ves';
        }

        if ($char1 == "y") {
            $len = strlen($name);
            $count = $len - 1;
            $prefix = substr($name, 0, $count);
            $name = $prefix . 'ies';
            $char0 = substr($char2, 0, -1);
            if (in_array($char0, $this->vowels)) {
                $name = $origin . 's';
            }
        }

        if ($char3 == "man") {
            $len = strlen($name);
            $count = $len - 3;
            $prefix = substr($name, 0, $count);
            $name = $prefix . 'men';
        }

        if ($name === $origin) {
            $name = $name . 's';
        }

        return $name;
    }

    /**
     * @param string $type
     * @param int $stage
     * @param string|null $toShow
     * @param string|null $projectName
     * @param string|null $moduleName
     * @return void
     */
    public function beginOrEnd(
        string $type,
        int $stage,
        string $toShow = null,
        string $projectName = null,
        string $moduleName = null,
    ):void {
        $inStage = [
            "Starting",
            "Finished"
        ];
        $forCreate = [
            "Project",
            "Module",
            "Resource",
        ];

        switch ($type) {
            case self::PROJECT:
                echo self::CYAN .
                    "{$inStage[$stage]} Configuration your Project: {$this->handleName($toShow)}\n" .
                    self::NC;
                break;
            case self::MODULE:
                echo self::PURPLE .
                    "{$inStage[$stage]} Configuration your Module: {$this->handleS($this->handleName($toShow))}\n" .
                    self::NC;
                break;
            case self::SCAFFOLD:
                if ($stage == 1) {
                    echo "\n # For Laravel versions below 11";
                    echo self::CYAN .
                        "\n # Register your new Module Resource in config/app.php on key 'providers'\n" .
                        self::NC;

                    echo "\n # For Laravel versions above 11";
                    echo self::CYAN .
                        "\n # Register your new Module Resource in bootstrap/providers.php '\n" .
                        self::NC;

                    $project = $this->handleName($projectName);
                    $module = $this->handleS($this->handleName($moduleName));

                    echo self::GREEN .
                        "\n/* $module Resource */\nApp\\$project\\$module\\Providers\\RouteServiceProvider::class,\nApp\\$project\\$module\\Providers\\AppServiceProvider::class,\n\n" .
                        self::NC;
                }

                echo self::YELLOW .
                    "{$inStage[$stage]} Configuration your Module Resource: {$this->handleName($toShow)}\n" .
                    self::NC;
                break;
            case self::BASIC:
                if ($stage == 1) {
                    echo "\n # For Laravel versions below 11";
                    echo self::CYAN .
                        "\n # Register your new Module Resource in config/app.php on key 'providers'\n" .
                        self::NC;

                    echo "\n # For Laravel versions above 11";
                    echo self::CYAN .
                        "\n # Register your new Module Resource in bootstrap/providers.php '\n" .
                        self::NC;
                }
                echo self::YELLOW .
                    "{$inStage[$stage]} Configuration your Module Resource: {$this->handleName($toShow)}\n" .
                    self::NC;
                break;
            default:
                echo self::CYAN .
                    "[ X ] {$forCreate[$stage]} {$this->handleName($toShow)} already exists.\n" .
                    self::NC;
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
            return self::GREEN . " [ x ] {$moduleName}{$type} created Successfully!\n" . self::NC;
        }

        return self::RED . "\033[30mCreate {$moduleName}{$type} Failed!\n" . self::NC;
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
     * @return string
     */
    public function createRouteProviderTrait(string $projectName): string
    {
        return $this->forCreateTraitSoftDelete->toTraitRouteServiceProvider($projectName);
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
     * @param string $projectName
     * @param string $moduleName
     * @return string
     */
    public function createAppServiceProvider(string $projectName, string $moduleName): string
    {
        return $this->forCreateProvider->createAppServiceProvider($projectName, $moduleName);
    }

    /**
     * @param string $projectName
     * @param string $moduleName
     * @return string
     */
    public function createRouteServiceProvider(string $projectName, string $moduleName): string
    {
        return $this->forCreateProvider->createRouteServiceProvider($projectName, $moduleName);
    }

    /**
     * @param string $projectName
     * @param string $moduleName
     * @param string $className
     * @return string
     */
    public function createRequest(string $projectName, string $moduleName, string $className): string
    {
        return $this->forCreateRequest->toRequest($projectName, $moduleName, $className);
    }

    /**
     * @param string $projectName
     * @param string $moduleName
     * @param string $className
     * @return string
     */
    public function createCollection(string $projectName, string $moduleName, string $className): string
    {
        return $this->forCreateResource->toCollection($projectName, $moduleName, $className);
    }

    /**
     * @param string $projectName
     * @param string $moduleName
     * @param string $className
     * @return string
     */
    public function createResource(string $projectName, string $moduleName, string $className): string
    {
        return $this->forCreateResource->toResource($projectName, $moduleName, $className);
    }

    /**
     * @param string $moduleName
     * @param string $className
     * @return string
     */
    public function createRouteApi(string $moduleName, string $className): string
    {
        return $this->forCreateRoute->toApi($moduleName, $className);
    }

    /**
     * @param string $moduleName
     * @param string $className
     * @return string
     */
    public function createRouteWeb(string $moduleName, string $className): string
    {
        return $this->forCreateRoute->toWeb($moduleName, $className);
    }

    /**
     * @param string $projectName
     * @param string $moduleName
     * @param string $className
     * @return string
     */
    public function createService(string $projectName, string $moduleName, string $className): string
    {
        return $this->forCreateService->toService($projectName, $moduleName, $className);
    }

    /**
     * @param string $projectName
     * @param string|null $moduleName
     * @return bool
     */
    public function checking(string $projectName, string $moduleName = null): bool
    {
        $projectName = $this->handleName($projectName);
        if (is_dir(parent::BASE_FOLDER . $projectName) && is_null($moduleName)) {
            return false;
        }

        if (!is_null($moduleName)) {
            $moduleName = $this->handleName($moduleName);
            if (is_dir(parent::BASE_FOLDER . $projectName . '/' . $moduleName)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $path
     * @return void
     */
    public function createDirectory(string $path): void
    {
        mkdir($path);
        chown($path, exec('whoami'));
    }

    /**
     * @param string $name
     * @return string
     */
    public function handleRouteName(string $name): string
    {
        $name = strtolower($name);
        $aux = str_replace(' ', '-', $name);
        if ($name !== $aux) {
            return str_replace(' ', '-', $name);
        }
        return $name;
    }
}