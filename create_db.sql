-- Создаем базу данных 27.6
CREATE DATABASE "27.6";

-- Подключаемся к базе данных 27.6
\c "27.6";

-- Создание таблицы oauth_providers
CREATE TABLE public.oauth_providers (
    id SERIAL PRIMARY KEY,
    provider_name VARCHAR(50) NOT NULL UNIQUE
);

-- Создание таблицы users
CREATE TABLE public.users (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    coockie VARCHAR(255),
    auth_type VARCHAR(50) DEFAULT 'password'
);

-- Создание таблицы oauth_users
CREATE TABLE public.oauth_users (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES public.users(id) ON DELETE CASCADE,
    provider_id INTEGER REFERENCES public.oauth_providers(id),
    oauth_id VARCHAR(255) NOT NULL UNIQUE
);

-- Создание таблицы roles
CREATE TABLE public.roles (
    id SERIAL PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL UNIQUE
);

-- Создание таблицы user_roles
CREATE TABLE public.user_roles (
    user_id INTEGER NOT NULL,
    role_id INTEGER NOT NULL,
    PRIMARY KEY (user_id, role_id),
    FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES public.roles(id)
);
