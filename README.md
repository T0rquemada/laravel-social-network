# Social network

This project developed on Laravel.

## Prerequisites
- [Composer](https://getcomposer.org/)

## Functionality
1. You can sign in / up
2. You can create / edit / delete own posts
3. See posts from another users on main page
4. Subscribe on another users
5. See posts from users on which you subscribed
6. Add user to black list, so you can't see their posts on main page 
7. See list users on which you subscribed
8. View profile other users, where displayed their nickname, data registration and posts

## To start
### Install dependencies
- ```composer install```
### Fill .env
1. Rename '.env.example' to '.env'
2. Fill DB_* part, depending on database you want use (by default sqlite)
### Setting up DB
- Run all migrations from 'database/migrtaions': ```php artisan migrate```
This will create tables
### Generate application key
- ```php artisan key:generate```
### Run development server
- ```php artisan serve```