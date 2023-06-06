<?php 
declare(strict_types=1);
session_start();
require_once('include/define.php');
require_once('include/functions.php');
require_once('include/config.php');


if ($_GET) {
    $page = $_GET['page'];
    switch ($page) {
        case 'home':
            $page = 'home.php';
            break;
        case 'dashboard':
            $page = 'dashboard.php';
            break;
        case 'profil':
            $page = 'profil.php';
            break;
        case 'all-users':
            $page = 'all-users.php';
            break;
        case 'add-product':
            $page = 'add-product.php';
            break;
        case 'products':
            $page = 'products.php';
            break;
}
} else {
    $page = 'home.php';
}
?>
<?php get_header(); ?>
<?php include_once('pages/' . $page); ?>

<?php get_footer(); ?>
        