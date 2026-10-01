<?php

namespace Src\LaravelModuleCreate\Commons;

class BaseNames
{
    const TRAIT = "Trait";
    const CONTROLLER = "Controller";
    const MODELS = "Models";
    const PROVIDERS = "Providers";
    const REQUESTS = "Requests";
    const RESOURCES = "Resources";
    const ROUTES = "Routes";
    const SERVICES = "Services";
    const COMMON = "Commons";
    const TRAITS = "Traits";
    const UNIT = "UnitTest";
    const FEATURE = "FeatureTest";
    const MIGRATION = "Migration";
    const BASE_FOLDER = "app/";
    const TEST_FOLDER = "tests/";
    const UNIT_FOLDER = self::TEST_FOLDER . "Unit/";
    const FEATURE_FOLDER = self::TEST_FOLDER . "Feature/";
    const MIGRATION_FOLDER = "database/migrations/";
    const VERSION = "1.2.03";
}