<?php

require_once("../include/users.php");
require_once("../include/pictures.php");
require_once("../include/html_functions.php");
require_once("../include/functions.php");

session_start();

require_login();

if (!(isset($_GET['key']) && isset($_GET['picid'])))
{
   error_404();
}

$user = Users::current_user();
$user_pics = Pictures::get_purchased_pictures($user['id']);
$pic = Pictures::get_picture($_GET['picid']);
if (!user_pics) {
   http_redirect(Users::$HOME_URL);
}
$pic_owned = False;
foreach ($user_pics as $user_pic) {
   if ($user_pic['id'] == $_GET['picid'])
   {
      $pic_owned = True;
   }
}
if (!$pic_owned)
{
   http_redirect(Users::$HOME_URL);
}
if ($_GET['key'] != 'highquality')
{
   error_404();
}

$filepath = "../upload/" . $pic['filename'];

header("Content-type: " . mime_content_type($filepath));
passthru("cat $filepath");

?>
