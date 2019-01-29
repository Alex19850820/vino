<?php
define('WP_CACHE', false); // Added by WP Rocket
 // Added by WP Rocket
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */
// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'seoelement_vino');
/** Имя пользователя MySQL */
define('DB_USER', 'seoelement_vino');
/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '123edsaqw');
/** Имя сервера MySQL */
define('DB_HOST', 'localhost');
/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');
/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');
/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'a%Hd`8;9.,byjTzZI;<AJLzj_CVa57X[#1}YhKs=1M;;P^a3yJ#[Car<-Jv{GdE!');
define('SECURE_AUTH_KEY',  'hQ/yC,aQwDnCVNeZ?9&Z2<XK11MQuiyen3|d8KGh06Tlq`/DgRLR*yxqh2wcs/o2');
define('LOGGED_IN_KEY',    '|w$FXReDMKfluz.$x!Jq$e4,NIZJz?M4nfJ9K?fi.:K[P0Th!Ywd<Uq{g@5&.3t!');
define('NONCE_KEY',        'r Biq UhL,^U}ce3%=HX37>i$v+Q!IH weWv{7@/qs/5Fb.F:_! v1,pGI7z|.A4');
define('AUTH_SALT',        '`n6=L7d6*X}P`pK-rtlyiWbV+(^jBYwIjd oJ|uj~H&o=(-BlOeukur=~,UCYB$m');
define('SECURE_AUTH_SALT', '3._^_M)?}S0EfP(Xcc7}WPb^[!#U~HsYkPxHT2V9@(V/r=$ pXLDP99uK!Y`vBo0');
define('LOGGED_IN_SALT',   'O2p(rA2R/s`^FLsec]K4loK(#Hyi8&U;gF6@3xUJ3q,eF^8%{KF:4CIm^xt([#pF');
define('NONCE_SALT',       'r45_/uAHSTn2P0 P%ERk_4kfiJT38aUui)H=xOKG=E(&-JKww$9wFg6@9861VvjP');
/**#@-*/
/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
define('WP_MEMORY_LIMIT', '256M');
$table_prefix  = 'wp_';
/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);
/* Это всё, дальше не редактируем. Успехов! */
/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
