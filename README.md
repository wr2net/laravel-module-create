# Laravel Module Create
![LM-CREATE](https://img.shields.io/badge/Laravel%20Module%20Create-grey?style=for-the-badge&logo=laravel)

[![Packagist Downloads](https://img.shields.io/packagist/dt/wr2net/lm-create)](https://packagist.org/packages/wr2net/lm-create)
[![GitHub Release](https://img.shields.io/github/v/release/wr2net/laravel-module-create)](https://packagist.org/packages/wr2net/lm-create)
[![GitHub License](https://img.shields.io/github/license/wr2net/laravel-module-create)](https://github.com/wr2net/laravel-module-create/blob/master/LICENSE)
[![PHP Version](https://img.shields.io/packagist/php-v/grazulex/laravel-draftable.svg?style=flat-square)](https://php.net/)
[![Laravel Version](https://img.shields.io/badge/laravel-10.x-ff2d20?style=flat-square&logo=laravel)](https://laravel.com/docs/10.x)
[![Laravel Version](https://img.shields.io/badge/laravel-11.x-ff2d20?style=flat-square&logo=laravel)](https://laravel.com/docs/11.x)
[![Laravel Version](https://img.shields.io/badge/laravel-12.x-ff2d20?style=flat-square&logo=laravel)](https://laravel.com/docs/12.x)


🚀 Laravel Module Create is a complete module create for Laravel.
-----

## [Read Details](DETAILS.md)

To create the suggested structures, the execution options are shown below. To create a "Project", it will be created within the default "app" directory with the name of your project where all the modules will be located.

To create the modules or the complete skeleton of the module, you must also inform your project, as shown in each command.

After executing the skeleton creation, the Providers for registration will be displayed.

Remember that Laravel 10 and 11 have different places for declaring Providers.

## This library create structure below

```text
└── MyProject 
    ├── Commons
        └── Traits
            ├── RouteServiceProviderTrait.php
            └── SoftDeletes.php
    └── MyModules
        ├── Controllers
            └── Api
                └── MyModuleController.php
        ├── Models
            ├── MyModule.php
            └── Repositories
                ├── MyModuleRepositoryInterface.php
                └── MyModuleRepository.php
        ├── Providers
            ├── AppServiceProvider.php
            └── RouteServiceProvider.php
        ├── Requests
            └── MyModuleRequest.php
        ├── Resources
            ├── MyModuleCollection.php
            └── MyModuleResource.php
        ├── Routes
            ├── api.php
            └── web.php
        └── Services
            └── MyModuleService.php
```

-----

## � Installation

Install the package via Composer:

```bash
composer require --dev wr2net/lm-create
```

## 📚 Commands

### To create a project:
```bash
php artisan lm-create:project MyProject
```

### To create a module:
```bash
php artisan lm-create:module MyProject MyModule
```

### To create a scaffold:
```bash
php artisan lm-create:skeleton MyProject MyModule
```

### To create a basic scaffold:
```bash
php artisan lm-create:basic MyProject MyModule
```

#### This command creates the basic structure below
```text
└── MyProject 
    ├── Commons
        └── Traits
            └── SoftDeletes.php
    └── MyModules
        ├── Models
            ├── MyModule.php
            └── Repositories
                ├── MyModuleRepositoryInterface.php
                └── MyModuleRepository.php
        ├── Providers
            └── AppServiceProvider.php
        └── Services
            └── MyModuleService.php
```

---

### If you need compound names, use quotes
This is valid for Projects, Modules and Skeleton

Eg. Project:
```bash
php artisan lm-create:project 'My Project'
```
Eg. Module or Skeleton:
```bash
php artisan lm-create:module 'My Project' 'My Module'
php artisan lm-create:skeleton 'My Project' 'My Module'
```

## 📄 License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

## 📝 TO DO List

| Resource                       | Description                                                                                    | Category |
|--------------------------------|------------------------------------------------------------------------------------------------|----------|
| [v] Run in production          | Not is running by artisan                                                                      | FEAT     |
| [v] Basic Skeleton             | Create basic skeleton to usage model                                                           | FEAT     |
| [v] Generate Unit Tests        | Generate a basic structure for unit testing the module.                                                           | FEAT     |
| [v] Generate Integration Tests | Generate a basic structure for integration testing the module.                                                           | FEAT     |


### FIX BUGS

| Resource              | Description                                                                                    | Category |
|-----------------------|------------------------------------------------------------------------------------------------|----------|
| [v] No replace        | If module was created but, not is complete, in new generate cannot replace if exists resources | BUG      |
| [v] Namespace         | Modules with compound names are not generating namespaces correctly                            | BUG      |


## 🔧 For Developers

```shell
composer install
```

### Commands:
```shell
php src/Config/lm-create-dev.php -f project:MyProject
```
```shell
php src/Config/lm-create-dev.php -f module:MyProject:MyModule
```
```shell
php src/Config/lm-create-dev.php -f skeleton:MyProject:MyModule
```
```shell
php src/Config/lm-create-dev.php -f basic:MyProject:MyModule
```