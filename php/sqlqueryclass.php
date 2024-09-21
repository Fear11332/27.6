<?php
    class Query{
        private static $queryArray=[
            'coockie'=>'select coockie from users where coockie = :coockie',
            'updateCoockie'=>'update users set coockie = :coockie where email = :email',
            'roles'=>"SELECT r.role_name FROM users u JOIN user_roles ur ON u.id = ur.user_id JOIN roles r ON ur.role_id = r.id WHERE u.email = :email",
            'oauth'=>"SELECT id, email, password, auth_type FROM users WHERE email = :email",
            'insertOauth'=>"INSERT INTO users (email, password, auth_type) VALUES (:email, '', 'oauth') RETURNING id",
            'insertOauth2'=>"INSERT INTO oauth_users (user_id, provider_id, oauth_id) VALUES (:user_id, :provider_id, :oauth_id)",
            'email,password'=>"select email,password from users where email = :email",
            'selectIdFromUsers'=>"select id from users where email = :email",
            'insertIntoUsersRoles'=>"insert into user_roles (user_id, role_id) values(:user_id ,1)",
            'selectAllInfoFromUsers'=>"SELECT * FROM users WHERE email = :email",
            'insertUser'=>"INSERT INTO users (email, password) VALUES (:email, :password)",
            'insertSimpleUser'=>"INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, 2)"
        ];
        public static function getCoockieSQL(){return self::$queryArray['coockie'];}
        public static function updateCoockieSQL(){return self::$queryArray['updateCoockie'];}
        public static function getRoles(){return self::$queryArray['roles'];}
        public static function getOAuthUserType(){return self::$queryArray['oauth'];}
        public static function insertUserWithAuthType(){return self::$queryArray['insertOauth'];}
        public static function insertOAuthUser(){return self::$queryArray['insertOauth2'];}
        public static function getEmailPassword(){return self::$queryArray['email,password'];}
        public static function selectIdFromUsers(){return self::$queryArray['selectIdFromUsers'];}
        public static function insertIntoUserRoles(){return self::$queryArray['insertIntoUsersRoles'];}
        public static function selectAllInfoFromUsers(){return self::$queryArray['selectAllInfoFromUsers'];}
        public static function insertUser(){return self::$queryArray['insertUser'];}
        public static function insertSimpleUser(){return self::$queryArray['insertSimpleUser'];}
    }
?>