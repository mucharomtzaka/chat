1. Clone project  ini  support  php 7.4 
2. create database dengan nama chat di phpmyadmin dan atur config databasenya 
  contoh: 
   $db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'chat',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

3. sesuaikan config pusher dengan akun anda  di lokasi folder config/config.php 
untuk test default sudah ada confignya 
contoh:  
$config['pusher'] = [
    'app_id'  => 'xxxxx',
    'key'     => 'xxx',
    'secret'  => 'xxxx',
    'cluster' => 'xxxx',
    'useTLS'  => true
];

4. atur base_url sesuai  nama folder  => 'http://localhost/chat/'
5. jalan kan  composer update  
6.  akun default chat 
    #user
	email : mucharomtzaka@gmail.com
	password: 12345678

	#admin 
	email: admin@test.com
	password: 12345678

