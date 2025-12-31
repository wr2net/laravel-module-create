<?php

namespace Src\LaravelModuleCreate\Commons;

use Src\LaravelModuleCreate\Helpers\HandleHelpers;

class Complements extends BaseNames
{
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
     * @return void
     */
    public function handleComplements(string $projectName, string $moduleName): void
    {
        /**
         * Create Unit Tests
         */
        print_r($this->handleHelper->show("Do create Unit Tests? (Y/n)\n"));
        $confirmationUnit = trim(fgets(STDIN));

        print_r($this->handleHelper->show("What will the initial fields be? (separated by commas)\n"));
        $fields = trim(fgets(STDIN));

        if (strtolower($confirmationUnit) === 'y' || empty($confirmationUnit)) {
            $fields = explode(',', $fields) ?? null;
            $this->handleCreateUnitTests($projectName, $moduleName, $fields);
        }

        /**
         * Create Feature Tests
         */
        print_r($this->handleHelper->show("Do create Feature Tests? (Y/n)\n"));
        $confirmationFeature = trim(fgets(STDIN));

        if (strtolower($confirmationFeature) === 'y' || empty($confirmationFeature)) {
            $this->handleCreateFeatureTests($projectName, $moduleName);
        }

        /**
         * Create Migrations
         */
        $migrationName = $this->handleMigrationName($moduleName);
        print_r($this->handleHelper->show("Do create Module Migration ({$migrationName})? (Y/n)\n"));
        $confirmationMigration = trim(fgets(STDIN));

        if (strtolower($confirmationMigration) === 'y' || empty($confirmationMigration)) {
            $this->createMigration($migrationName, $moduleName);
        }
    }

    /**
     * @param string $projectName
     * @param string $moduleName
     * @param array $fields
     * @return void
     */
    private function handleCreateUnitTests(
        string $projectName, string $moduleName, array $fields = []
    ): void {
        $className = $this->handleHelper->handleName($moduleName);
        $moduleName = $this->handleHelper->handleS(
            $this->handleHelper->handleName($moduleName)
        );
        $fileName = "{$className}UnitTest.php";

        file_put_contents(
            self::UNIT_FOLDER . '/' . $fileName,
            $this->handleHelper->createUnitTests($projectName, $moduleName, $className, $fields)
        );
        $fullPath = self::UNIT_FOLDER . '/' . $fileName;
        print_r($this->handleHelper->showMessage($fullPath, $className, self::UNIT));
    }

    /**
     * @param string $projectName
     * @param string $moduleName
     * @return void
     */
    private function handleCreateFeatureTests(
        string $projectName, string $moduleName
    ): void {
        $className = $this->handleHelper->handleName($moduleName);
        $moduleName = $this->handleHelper->handleS(
            $this->handleHelper->handleName($moduleName)
        );
        $fileName = "{$className}FeatureTest.php";

        file_put_contents(
            self::FEATURE_FOLDER . '/' . $fileName,
            $this->handleHelper->createFeatureTests($projectName, $moduleName, $className)
        );
        $fullPath = self::FEATURE_FOLDER . '/' . $fileName;
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
     * @return void
     */
    private function createMigration(string $migrationName, string $className): void
    {
        shell_exec("php artisan make:migration {$migrationName}");
        $files = glob(self::MIGRATION_FOLDER . "*_{$migrationName}.php");
        $fullPath = !empty($files) ? end($files) :  self::MIGRATION_FOLDER . "{$migrationName}.php";
        print_r($this->handleHelper->showMessage($fullPath, $className, self::MIGRATION));
    }
}