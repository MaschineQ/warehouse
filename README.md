# Warehouse
Symfony 6.1.4, PHP 8.1

## Installation
1. Clone this repo with GIT.
2. Install docker in you don't have it (https://www.docker.com/products/docker-desktop)
4. Run `docker-compose up`. First run can take about 10 mins depending on your machine performance (the program will make libraries installation for the first time).
6. Visit `http://localhost:8080`

## First-run
1. Get inside be container `docker exec -it warehouse_php bash`
2. Run `composer install`
3. Run `composer create-database`
3. Run `bin/console doctrine:fixtures:load`

## Testing
PHPStan - `composer phpstan`  
ECS(symplify / easy-coding-standard) - `composer ecs` - dry run  
ECS(symplify / easy-coding-standard) - `composer ecs-fix` - fix  
PHPUnit - `composer phpunit` 
Functional - `composer functional`  
Integration - `composer integration`   
  
Run test `composer test`

## Adminer
Visit `http://localhost:9009`  
Server: `warehouse_db`  
User / pasword: `root`  

## MailCatcher
Visit `http://localhost:1080`