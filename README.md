![Laravel Module Create](.github/cover.png)

# Laravel Module Create

Laravel Module Create is a complete module create for Laravel.
-----

To create the suggested structures, the execution options are shown below. To create a "Project", it will be created within the default "app" directory with the name of your project where all the modules will be located.

To create the modules or the complete skeleton of the module, you must also inform your project, as shown in each command.

After executing the skeleton creation, the Providers for registration will be displayed.

Remember that Laravel 10 and 11 have different places for declaring Providers.

## This library create structure below

```text
└── MyProject 
    ├── Common
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

## Commands

### To create a project:
- Using Artisan
```bash
php artisan lm-create project:MyProject
```
- Using Composer
```bash
composer lm-create project:MyProject
```

### To create a module:
- Using Artisan
```bash
php artisan lm-create module:MyProject:MyModule
```
- Using Composer
```bash
composer lm-create module:MyProject:MyModule
```

### To create a scaffold:
- Using Artisan
```bash
php artisan lm-create skeleton:MyProject:MyModule
```
- Using Composer
```bash
composer lm-create skeleton:MyProject:MyModule
```

---

### If you need compound names, use " ' " with space
This is valid for Projects, Modules and Skeleton

Eg. Project:
- Using Artisan
```bash
php artisan lm-create project:'My Project'
```
Eg. Module or Skeleton:
```bash
php artisan lm-create skeleton:'My Project':'My Module'
```

- Using Composer
```bash
composer lm-create project:'My Project'
```
Eg. Module or Skeleton:
```bash
composer lm-create skeleton:'My Project':'My Module'
```
