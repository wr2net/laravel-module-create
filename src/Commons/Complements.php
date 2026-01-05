<?php

namespace Src\LaravelModuleCreate\Commons;

use Src\LaravelModuleCreate\Helpers\HandleHelpers;

class Complements extends BaseNames
{
    /**
     * @var string
     */
    public string $migrationName;

    /**
     * @var string
     */
    public string $unitTestName;

    /**
     * @var string
     */
    public string $featureTestName;

    /**
     * @var HandleHelpers
     */
    private HandleHelpers $handleHelper;

    public function __construct(HandleHelpers $handleHelper)
    {
        $this->handleHelper = $handleHelper;
    }

    /**
     * @param string $projectName
     * @param string $moduleName
     * @param string $controller
     * @return void
     */
    public function handleComplements(string $projectName, string $moduleName, string $controller): void
    {
        $fields = null;

        /**
         * Create Unit Tests
         */
        print_r($this->handleHelper->show("Do create Unit Tests? (Y/n)\n"));
        $confirmationUnit = trim(fgets(STDIN));

        if (strtolower($confirmationUnit) === 'y' || empty($confirmationUnit)) {
            $fields = $this->handleReadFields();
            $this->handleCreateUnitTests($projectName, $moduleName, $fields['fields'], $fields['size']);
        }

        /**
         * Create Feature Tests
         */
        print_r($this->handleHelper->show("Do create Feature Tests? (Y/n)\n"));
        $confirmationFeature = trim(fgets(STDIN));

        if (strtolower($confirmationFeature) === 'y' || empty($confirmationFeature)) {
            if (is_null($fields)) {
                $fields = $this->handleReadFields();
            }
            $this->handleCreateFeatureTests($projectName, $moduleName, $fields['fields'], $fields['size']);
        }

        /**
         * Create Migrations
         */
        $migrationName = $this->handleMigrationName($moduleName);
        print_r($this->handleHelper->show("Do create Module Migration ({$migrationName})? (Y/n)\n"));
        $confirmationMigration = trim(fgets(STDIN));

        if (strtolower($confirmationMigration) === 'y' || empty($confirmationMigration)) {
            if (is_null($fields)) {
                $fields = $this->handleReadFields();
            }
            $this->createMigration($migrationName, $moduleName, $fields['fields']);
        }

        /**
         * Create Readme
         */
        $toReadme = $this->handleHelper->createReadme(
            $projectName,
            $moduleName,
            $controller,
            $fields['fields'],
            $this->handleHelper->getRoutes($moduleName, $controller),
            $this->unitTestName,
            $this->featureTestName,
            $this->migrationName,
        );

        $moduleName = $this->handleHelper->handleS(
            $this->handleHelper->handleName($moduleName)
        );

        $fullPath = self::BASE_FOLDER . "{$projectName}/{$moduleName}/README.md";
        file_put_contents(
            $fullPath,
            $toReadme,
        );
    }

    /**
     * @param string $projectName
     * @param string $moduleName
     * @param array $fields
     * @param int $size
     * @return void
     */
    private function handleCreateUnitTests(
        string $projectName, string $moduleName, array $fields, int $size = 3
    ): void {
        $className = $this->handleHelper->handleName($moduleName);
        $moduleName = $this->handleHelper->handleS(
            $this->handleHelper->handleName($moduleName)
        );
        $fileName = "{$className}UnitTest.php";
        $fullPath = self::UNIT_FOLDER . $fileName;
        file_put_contents(
            $fullPath,
            $this->handleHelper->createUnitTests($projectName, $moduleName, $className, $fields, $size)
        );
        if (file_exists($fullPath)) {
            $this->unitTestName = $fileName;
        }
        print_r($this->handleHelper->showMessage($fullPath, $className, self::UNIT));
    }

    /**
     * @param string $projectName
     * @param string $moduleName
     * @param array $fields
     * @param int $size
     * @return void
     */
    private function handleCreateFeatureTests(
        string $projectName, string $moduleName, array $fields, int $size
    ): void {
        $className = $this->handleHelper->handleName($moduleName);
        $moduleName = $this->handleHelper->handleS(
            $this->handleHelper->handleName($moduleName)
        );
        $fileName = "{$className}FeatureTest.php";
        $fullPath = self::FEATURE_FOLDER . $fileName;
        file_put_contents(
            $fullPath,
            $this->handleHelper->createFeatureTests($projectName, $moduleName, $className, $fields, $size)
        );

        if (file_exists($fullPath)) {
            $this->featureTestName = $fileName;
        }
        print_r($this->handleHelper->showMessage($fullPath, $className, self::FEATURE));
    }

    /**
     * @param string $moduleName
     * @return string
     */
    private function handleMigrationName(string $moduleName): string
    {
        $moduleName = $this->handleHelper->handleS(
            $this->handleHelper->handleName($moduleName)
        );
        $migrationName = strtolower($moduleName);
        return "create_{$migrationName}_table";
    }

    /**
     * @param string $migrationName
     * @param string $className
     * @param array $fields
     * @return void
     */
    private function createMigration(string $migrationName, string $className, array $fields): void
    {
        $date = date('Y_m_d_His');
        $migrationFileName = "{$date}_{$migrationName}.php";
        $fullPath = self::MIGRATION_FOLDER . "{$migrationFileName}";
        file_put_contents(
            $fullPath,
            $this->handleHelper->createMigration($className, $fields),
        );
        if (file_exists($fullPath)) {
            $this->migrationName = $migrationFileName;
        }
        print_r($this->handleHelper->showMessage($fullPath, $className, self::MIGRATION));
    }

    /**
     * @return array|null
     */
    private function handleReadFields(): ?array
    {
        print_r($this->handleHelper->show("What will the initial fields be? (separated by commas)\n"));
        $fields = trim(fgets(STDIN));
        print_r($this->handleHelper->show("Collection Size: (default: 3)\n"));
        $size = trim(fgets(STDIN));
        $size = empty($size) ? 3 : $size;
        return [
            'fields' => explode(',', $fields) ?? null,
            'size' => (int)$size,
        ];
    }
}