# README

## BUILD

### Containerization

**docker-compose.yaml** is entry point to build the every container. Inside are defined containers parameters.

e.g

```
services:
  app-1:
    env_file:
      - .env
    build:
      context: .
      dockerfile: Dockerfile.app1
      args:
        - IMAGE_TAG=${PHP_IMAGE_TAG}
    container_name: app-1
    volumes:
      - ./app1:/var/www/html:rw
```

Each service has his own **Dockerfile** named in convention Dockerfile.{service_name}

### Execution

Preferred way to build containers is to run **setup.sh** scripts. It will do all necessary operations to correctly
run containers. E.g update **.env** file, run docker-compose up etc. etc.  

## Code Quality

### php_codesniffer

Every php container uses **php_codesniffer** tool to take care of code quality.

#### Usage

`` vendor/bin/phpcs `` - validate your code

`` vendor/bin/phpcbf `` - automatically fix errors found by **phpcs**

#### Additional rules

To ensure better code quality with code_sniffer installed is **slevomat/coding-standard**.

##### Used additional rules

**Arrays**
- TrailingArrayComma
- MultiLineArrayEndBracketPlacement

**Attributes**
- DisallowMultipleAttributesPerLine
- RequireAttributeAfterDocComment

**Classes**
- ClassConstantVisibility
- ClassStructure
  
    Require concrete order of class parts.  
    - uses
    - enum cases
    - public constants
    - constants
    - public properties
    - protected properties
    - private properties
    - constructor
    - public methods
    - protected and private methods

- ConstantSpacing
- ForbiddenPublicProperty
- ModernClassNameReference
- PropertyDeclaration
- TraitUseDeclaration

**Comments**
- EmptyComment
- UselessFunctionDocComment

**Control Structures**
- RequireNullCoalesceEqualOperator
- RequireNullCoalesceOperator
- RequireNullSafeObjectOperator
- RequireYodaComparison

**Exceptions**
- DeadCatch

**TypeHints**
- DeclareStrictTypes

Example file with prepared configuration can be found in **./config/phpcs.xml.example**

### phpstan

To ensure higher code quality was used phpstan on level 9.

#### Execution

`` vendor/bin/phpstan `` - Run phpstan analysis

`` vendor/bin/phpstan --generate-baseline`` - ignore found errors and put them to baseline file.

Example file with phpstan configuration can be found in **./config/phpstan.neon.example**

### Tests

#### Tools
- PHP Unit

#### PHP Unit flow

**Test types**

- Smoke - Check if feature works and does not throw 500 status code or exception.
- Integration - Check integration between application and external service. For example check if data were correctly 
  saved in database.
- Unit - Check if domain logic is implemented correctly or single service works as expected. 

### Queueing
To queue handling is used **symfony/messenger** configured for rabbitmq.

### Server
To expose applications for external requests used was **nginx**

## Applications

### App1
[link to app1 readme](./app1/readme.md)