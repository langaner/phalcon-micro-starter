## Phalcon micro starter

A Skeleton project what include jwt token authentication.

## How to install

Run `composer create-project langaner/phalcon-micro-starter project-directory --prefer-source` or download zip.

## Folders

Controllers - all your app controllers
Middleware - collection of middleware
Models - models folder
Presenters - presenters. You can use it by call it from model $this->userRepository->getModel()->getPresenter()->test
Providers - all app providers
Repositories - all repositoreis. You can use it by call $this->userRepository->test()
Services - all app services. You can use it by call $this->userService->test()
routes - all routes. You can separate it to files or write all in routes.php

## Routes

http://servarname.server/auth/login - login route. This route provide user auth return his token. All routes protected with AuthMiddleware. Auth settings located in auth config file.
