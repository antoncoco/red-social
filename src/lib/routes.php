<?php

use Cocol\Redsocial\controllers\Actions;
use Cocol\Redsocial\controllers\Home;
use Cocol\Redsocial\controllers\Login;
use Cocol\Redsocial\controllers\Profile;
use Cocol\Redsocial\controllers\Singup;

    $router = new \Bramus\Router\Router();
    session_start();
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../config');
    $dotenv->load();

    function notAuth() {
        if (!isset($_SESSION['user'])) {
            header('location: /login');
            exit();
        }
    }

    function auth() {
        if (isset($_SESSION['user'])) {
            header('location: /home');
            exit();
        }
    }

    $router->get('/', function() {
        echo "Inicio";
    });

    $router->get('/login', function() {
        auth();
        $controller = new Login;
        $controller->render('login/index');
    });

    $router->post('/auth', function() {
        auth();
        $controller = new Login;
        $controller->auth();
    });

    $router->get('/singup', function() {
        auth();
        $controller = new Singup;
        $controller->render('singup/index');
    });

    $router->post('/register', function() {
        auth();
        $controller = new Singup;
        $controller->register();
    });

    $router->get('/home', function() {
        notAuth();
        $user = unserialize($_SESSION['user']);
        $controller = new Home($user);
        $controller->index();
    });

    $router->post('/publish', function() {
        notAuth();
        $user = unserialize($_SESSION['user']);
        $controller = new Home($user);
        $controller->store();
    });

    $router->post('/addLike', function() {
        //TODO: Revisar si ya le dió like, si es así "quitar" like
        notAuth();
        $user = unserialize($_SESSION['user']);
        $controller = new Actions($user);
        $controller->like();
    });

    $router->get('/singout', function() {
        notAuth();
        unset($_SESSION['user']);
        header('location: /login');
    });

    $router->get('/profile', function() {
        notAuth();
        $user = unserialize($_SESSION['user']);
        $controller = new Profile();
        $controller->getUserProfile($user);
    });

    $router->get('/profile/(\w+)', function($username) {
        notAuth();
        $controller = new Profile();
        $controller->getUsernameProfile($username);
    });

    $router->run();