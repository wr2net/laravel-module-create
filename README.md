# Laravel Module Create
Create complete module on Laravel for new resource.


<div style="text-align: center;">
    <img alt="HTML" src="https://img.shields.io/static/v1?label=PHP 8.2&message=PHP&color=blue&labelColor=gray" />
    <a href="https://packagist.org/packages/wr2net/laravel-module-create">
        <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/wr2net/laravel-module-create">
        <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/wr2net/laravel-module-create">
        <img alt="License MIT" src="https://img.shields.io/static/v1?label=License&message=MIT&color=49AA26&labelColor=000000"/>
    </a>
</div>


## # Using Artisan
### To create a project:
```bash
php artisan create:project ProjectName
```

### To create a module:
```bash
php artisan create:module MyProject MyModule
```

### To create a scaffold:
```bash
php artisan create:skeleton MyProject MyModule
```

---

### If you need compound names, use " ' " with space
eg:
```bash
php artisan create:project 'My Project'
```
This is valid for Projects, Modules and Skeleton

----
## # Using PHP

### To create a project:
```bash
php index.php -f project:Project
```

### To create a module:
```bash
php index.php -f module:MyProject:MyModule
```

### To create a scaffold:
```bash
php index.php -f skeleton:MyProject:MyModule
```

---
### If you need compound names, use " ' " with space
eg:
```bash
php index.php -f project:'My Project'
```
This is valid for Projects, Modules and Skeleton