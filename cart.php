﻿<?php
    include("include/db_connect.php");
    include("functions/functions.php");
    
    $id = clear_string ($_GET["id"]);
    $action = clear_string ($_GET["action"]);
    switch ($action){
        case 'clear':
        $clear = mysql_query ("DELETE FROM cart WHERE cart_ip = '{$_SERVER['REMOTE_ADDR']}'",$link);
        break;
        
        case 'delete':
        $delete = mysql_query ("DELETE FROM cart WHERE cart_id = '$id' AND cart_ip = '{$_SERVER['REMOTE_ADDR']}'",$link);
        break;
    }
    if (isset($_POST["submitdata"])){
    $_SESSION["order_delivery"] = $_POST["order_delivery"];
    $_SESSION["order_fio"] = $_POST["order_fio"];
    $_SESSION["order_email"] = $_POST["order_email"];
    $_SESSION["order_phone"] = $_POST["order_phone"];
    $_SESSION["order_adress"] = $_POST["order_adress"];
    $_SESSION["order_note"] = $_POST["order_note"];
    
header ("Location: cart.php?action=completion");
 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/reset.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="js/shop-script.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.min.js"></script>
	<title>Корзина заказов</title>
</head>

<body>
<div id="block-body">
<?php
	include ("include/block-header.php");  
?>
<div id="block-right">
<?php
	include ("include/block-category.php");  
?>
</div>
<div id="block-content">
<?php
	$action = clear_string ($_GET["action"]);
    switch ($action){
        case 'oneclick':
        echo'
        <div id="block-step">
        <div id="name-step">
        <ul>
        <li><a class="active">1. Корзина товаров</a></li>
        <li><span>&rarr;</span></li>
        <li><a>2. Контактная информация</a></li>
        <li><span>&rarr;</span></li>
        <li><a>3. Завершение</a></li>
        </ul>
        </div>
        <p>шаг 1 из 3</p>
        <a href="cart.php?action=clear">Очистить</a>
        </div>
        ';
      
$result = mysql_query ("SELECT * FROM cart, table_products WHERE cart.cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND table_products.products_id = cart.cart_id_products",$link);
if (mysql_num_rows($result) > 0){
    $row = mysql_fetch_array($result);
      echo '
        <div id="header-list-cart">
        <div id="head1">Изображение</div>
        <div id="head2">Наименование товара</div>
        <div id="head3">Кол-во</div>
        <div id="head4">Цена</div>
        </div>
        ';
    do{
        $int = $row["cart_price"] * $row["cart_count"];
        $all_price = $all_price + $int;
        if (strlen($row["image"]) > 0 && file_exists ("./uploads_images/".$row["image"])){
            $img_path = './uploads_images/'.$row["image"];
            $max_width = 100;
            $max_height = 100;
            list ($width,$height) = getimagesize($img_path);
            $ratioh = $max_height/$height;
            $ratiow = $max_width/$max_width;
            $ratio = min ($ratioh,$ratiow);
            $width = intval($ratio*$width);
            $height = intval($ratio*$height);
            }
            else{
                $img_path = "images/no-image.png";
                $width = 120;
                $height = 105;
                }
                        echo'
<div class="block-list-cart">
<div class="img-cart">
<p align="center"><img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" /></p>
</div>

<div class="title-cart">
<p><a href="">'.$row["title"].'</a></p>
<p class="cart-mini_features">'.$row["mini_features"].'</p>
</div>

<div class="count-cart">
<ul class="input-count-style">
<li><p align="center" class="count-minus">-</p></li>
<li><p align="center"><input class="count-input" maxlength="3" type="text" value="'.$row["cart_count"].'" /></p></li>
<li><p align="center" class="count-plus">+</p></li>
</ul>
</div>

<div class="price-product"><h5><span class="span-count">1</span> x <span>'.$row["cart_price"].'</span></h5><p>'.$int.'</p></div>
<div class="delete-cart"><a href="cart.php?id='.$row["cart_id"].'&action=delete"><img src="images/bsk_item_del.png" /></a></div>
<div id="bottom-cart-line"></div>
</div>
        ';
      }
    while ($row = mysql_fetch_array ($result));
    echo'
    <h2 class="itog-price" align="right">Итого: <strong>'.$all_price.'</strong> руб</h2>
    <p align="right" class="button-next"><a href="cart.php?action=confirm">Далее</a></p>
    ';
            }
            else{
                echo '<h3 id="clear-cart" align="center">Корзина пуста</h3>';
            }

        break;
        
        case 'confirm':
        echo'
        <div id="block-step">
        <div id="name-step">
        <ul>
        <li><a href="cart.php?action=oneclick">1. Корзина товаров</a></li>
        <li><span>&rarr;</span></li>
        <li><a class="active">2. Контактная информация</a></li>
        <li><span>&rarr;</span></li>
        <li><a>3. Завершение</a></li>
        </ul>
        </div>
        <p>шаг 2 из 3</p>
        </div>        
        ';

        if ($_SESSION['order_delivery']=="По почте") $chck1 = "checked";
        if ($_SESSION['order_delivery']=="Курьером") $chck2 = "checked";
        if ($_SESSION['order_delivery']=="Самовывоз") $chck3 = "checked";
        echo '
        <h3 class="title-h3">Способы доставки:</h3>
        <form method="post">
        <ul id="info-radio">
        <li>
        <input type="radio" name="order_delivery" class="order_delivery" id="order_delivery1" value="По почте"'.$chck1.' />
        <label class="label_delivery" for="order_delivery1">По почте</label>
        </li>
        <li>
        <input type="radio" name="order_delivery" class="order_delivery" id="order_delivery2" value="Курьером"'.$chck2.' />
        <label class="label_delivery" for="order_delivery1">Курьером</label>
        </li>
        <li>
        <input type="radio" name="order_delivery" class="order_delivery" id="order_delivery3" value="Самовывоз"'.$chck3.' />
        <label class="label_delivery" for="order_delivery1">Самовывоз</label>
        </li>
        </ul>
        <h3 class="title-h3">Информация для доставки:</h3>
        <ul id="info-order">
        ';
            echo '
            <li><label for="order_fio"><span>*</span>ФИО</label><input type="text" name="order_fio" value="'.$_SESSION["order_fio"].'" /><span class="order_span_style">Пример: Иванов Иван Иванович</span></li>
            <li><label for="order_fio"><span>*</span>E-mail</label><input type="text" name="order_email" value="'.$_SESSION["order_email"].'" /><span class="order_span_style">Пример: ivanov@mail.ru</span></li>
            <li><label for="order_fio"><span>*</span>Телефон</label><input type="text" name="order_phone" value="'.$_SESSION["order_phone"].'" /><span class="order_span_style">Пример: 8 950 202 20 22</span></li>
            <li><label class="order-label-style" for="order_fio"><span>*</span>Адресс</label><input type="text" name="order_adress" value="'.$_SESSION["order_adress"].'" /><span>Пример: г. Уфа,<br /> ул. Ленина 3, кв. 5</span></li>
            <li><label class="order_label_style" for="order_note">Примечание</label><textarea name="order_note">'.$_SESSION["order_note"].'</textarea><span>Уточните информацию о заказе.<br /> Например, удобное время для звонка<br /> нашего менеджера</span></li>
            </ul>
            <p align="right"><input type="submit" name="submitdata" id="confirm-button-next" value="Далее" /></p>
            </form>
            ';
        break;
                
        case 'completion':
        echo'
        <div id="block-step">
        <div id="name-step">
        <ul>
        <li><a href="cart.php?action=oneclick">1. Корзина товаров</a></li>
        <li><span>&rarr;</span></li>
        <li><a href="cart.php?action=confirm">2. Контактная информация</a></li>
        <li><span>&rarr;</span></li>
        <li><a class="active">3. Завершение</a></li>
        </ul>
        </div>
        <p>шаг 3 из 3</p>
        </div>        
        ';
        echo '
        <ul id="list-info">
        <li><strong>Способ доставки:</strong></li>'.$_SESSION['order_delivery'].'</li>
        <li><strong>Email:</strong></li>'.$_SESSION['order_email'].'</li>
        <li><strong>ФИО:</strong></li>'.$_SESSION['order_fio'].'</li>
        <li><strong>Адресс:</strong></li>'.$_SESSION['order_adress'].'</li>
        <li><strong>Телефон:</strong></li>'.$_SESSION['order_phone'].'</li>
        <li><strong>Примечание:</strong></li>'.$_SESSION['order_note'].'</li>
        </ul>
        ';
        break;
        
        default:
        echo'
        <div id="block-step">
        <div id="name-step">
        <ul>
        <li><a class="active">1. Корзина товаров</a></li>
        <li><span>&rarr;</span></li>
        <li><a>2. Контактная информация</a></li>
        <li><span>&rarr;</span></li>
        <li><a>3. Завершение</a></li>
        </ul>
        </div>
        <p>шаг 1 из 3</p>
        <a href="cart.php?action=clear">Очистить</a>
        </div>
        ';
      
$result = mysql_query ("SELECT * FROM cart, table_products WHERE cart.cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND table_products.products_id = cart.cart_id_products",$link);
if (mysql_num_rows($result) > 0){
    $row = mysql_fetch_array($result);
      echo '
        <div id="header-list-cart">
        <div id="head1">Изображение</div>
        <div id="head2">Наименование товара</div>
        <div id="head3">Кол-во</div>
        <div id="head4">Цена</div>
        </div>
        ';
    do{
        $int = $row["cart_price"] * $row["cart_count"];
        $all_price = $all_price + $int;
        if (strlen($row["image"]) > 0 && file_exists ("./uploads_images/".$row["image"])){
            $img_path = './uploads_images/'.$row["image"];
            $max_width = 100;
            $max_height = 100;
            list ($width,$height) = getimagesize($img_path);
            $ratioh = $max_height/$height;
            $ratiow = $max_width/$max_width;
            $ratio = min ($ratioh,$ratiow);
            $width = intval($ratio*$width);
            $height = intval($ratio*$height);
            }
            else{
                $img_path = "images/no-image.png";
                $width = 120;
                $height = 105;
                }
                        echo'
<div class="block-list-cart">
<div class="img-cart">
<p align="center"><img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" /></p>
</div>

<div class="title-cart">
<p><a href="">'.$row["title"].'</a></p>
<p class="cart-mini_features">'.$row["mini_features"].'</p>
</div>

<div class="count-cart">
<ul class="input-count-style">
<li><p align="center" class="count-minus">-</p></li>
<li><p align="center"><input class="count-input" maxlength="3" type="text" value="'.$row["cart_count"].'" /></p></li>
<li><p align="center" class="count-plus">+</p></li>
</ul>
</div>

<div class="price-product"><h5><span class="span-count">1</span> x <span>'.$row["cart_price"].'</span></h5><p>'.$int.'</p></div>
<div class="delete-cart"><a href="cart.php?id='.$row["cart_id"].'&action=delete"><img src="images/bsk_item_del.png" /></a></div>
<div id="bottom-cart-line"></div>
</div>
        ';
      }
    while ($row = mysql_fetch_array ($result));
    echo'
    <h2 class="itog-price" align="right">Итого: <strong>'.$all_price.'</strong> руб</h2>
    <p align="right" class="button-next"><a href="cart.php?action=confirm">Далее</a></p>
    ';
            }
            else{
                echo '<h3 id="clear-cart" align="center">Корзина пуста</h3>';
            }

        break;
    }
?>
</div>
<div id="clear">

</div>
<div id="block-footer">
<?php
	include ("include/block-footer.php");  
?>
</div>
</div>	
</body>
</html>