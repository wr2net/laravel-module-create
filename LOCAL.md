## # Using PHP


### To create a project:

```bash

php src/Config/lm-create.php -f project:Project

```


### To create a module:

```bash

php src/Config/lm-create.php -f module:MyProject:MyModule

```


### To create a scaffold:

```bash

php src/Config/lm-create.php -f skeleton:MyProject:MyModule

```


---

### If you need compound names, use " ' " with space

eg:

```bash

php src/Config/lm-create.php -f project:'My Project'

```

This is valid for Projects, Modules and Skeleton