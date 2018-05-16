<?php
	include("include/db_connect.php");
    include("functions/functions.php");
    $go = clear_string ($_GET["go"]);
    switch ($go){
        case 'news';
        $query_anystopper = "WHERE visible = '1' AND new = '1'";
        $name_anystopper = "Новинки товаров";
        break;
        
        case 'leaders';
        $query_anystopper = "WHERE visible = '1' AND leader = '1'";
        $name_anystopper = "Лидеры продаж";
        break;
        
        case 'sale';
        $query_anystopper = "WHERE visible = '1' AND sale = '1'";
        $name_anystopper = "Распродажа";
        break;
        
        default:
        $query_anystopper = "";
        break;
        }
    $sorting = $_GET ["sort"];
    switch ($sorting){
        case 'price-asc';
        $sorting = 'price ASC';
        $sort_name = 'От дешёвых к дорогим';
        break;
        
        case 'price-desc';
        $sorting = 'price DESC';
        $sort_name = 'От дорогих к дешёвым';
        break;
        
        case 'popular';
        $sorting = 'count DESC';
        $sort_name = 'Популярное';
        break;
        
        case 'news';
        $sorting = 'datetime';
        $sort_name = 'Новинки';
        break;
        
        case 'title';
        $sorting = 'title';
        $sort_name = 'По алфавиту';
        break;
        
        default:
        $sorting = 'products_id DESC';
        $sort_name = 'Нет сортировки';
        break;
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
	<title>NEO Shop</title>
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
	if ($query_anystopper !=""){
	   
?>
<div id="block-sorting">
<p id="nav-breadcrumbs"><a href="index.php">Главная страница</a> \ <span><?php echo $name_anystopper;?></span></p>
<ul id="options-list">
<li>Вид:</li>
<li><img id="style-grid" src="images/table.png" /></li>
<li><img id="style-list" src="images/list.png" /></li>
<li>Сортировка:</li>
<li><a id="select-sort"><?php echo $sort_name;?></a>
<ul id="sorting-list">
<li><a href="view_aystopper.php?go=<?php echo $go;?>&sort=price-asc">От дешёвых к дорогим</a></li>
<li><a href="view_aystopper.php?go=<?php echo $go;?>&sort=price-desc">От дорогих к дешёвым</a></li>
<li><a href="view_aystopper.php?go=<?php echo $go;?>&sort=popular">Популярное</a></li>
<li><a href="view_aystopper.php?go=<?php echo $go;?>&sort=news">Новинки</a></li>
<li><a href="view_aystopper.php?go=<?php echo $go;?>&sort=title">По алфавиту</a></li>
</ul>
</li>
</ul>
</div>
<ul id="block-tovar-grid">
<?php
	$result = mysql_query("SELECT * FROM table_products $query_anystopper ORDER BY $sorting",$link);
    if (mysql_num_rows($result) > 0)
{
  $row = mysql_fetch_array($result);
   
   do{
    
    if ($row["image"] != "" && file_exists ("uploads_images/".$row["image"]))
    {
        $img_path = 'uploads_images/'.$row["image"];
        $max_width = 200;
        $max_height = 200;
        list($width,$height) = getimagesize ($img_path);
        $ratioh = $max_height/$height;
        $ratiow = $max_width/$width;
        $ratio = min($ratioh,$ratiow);
        $width = intval($ratio*$width);
        $height = intval($ratio*$height);
    }else
    {
        $img_path = "images/no-image.png";
        $width = 110;
        $height = 200;
    }
    
    echo '
        <li>
        <div class="block-images-grid">
        <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" />
        </div>
        <p class="style-title-grid"><a href="">'.$row["title"].'</a></p>
        <ul class="reviews-and-counts-grid">
        <li><img src="images/eye.png" /><p>0</p></li>
        <li><img src="images/comment.png" /><p>0</p></li>
        </ul>
        <a class="add-cart-style-grid"></a>
        <p class="style-price-grid"><strong id="price">'.$row["price"].'</strong> руб.</p>
        <div class="mini-features">
        '.$row["mini_features"].'
        </div>
        </li>
        ';
   }
        while($row = mysql_fetch_array ($result));
    }
?>
</ul>
<ul id="block-tovar-list">
<?php
	$result = mysql_query("SELECT * FROM table_products $query_anystopper ORDER BY $sorting",$link);
    if (mysql_num_rows($result) > 0)
{
  $row = mysql_fetch_array($result);
   
   do{
    
    if ($row["image"] != "" && file_exists ("uploads_images/".$row["image"]))
    {
        $img_path = 'uploads_images/'.$row["image"];
        $max_width = 150;
        $max_height = 150;
        list($width,$height) = getimagesize ($img_path);
        $ratioh = $max_height/$height;
        $ratiow = $max_width/$width;
        $ratio = min($ratioh,$ratiow);
        $width = intval($ratio*$width);
        $height = intval($ratio*$height);
    }else
    {
        $img_path = "images/no-image.png";
        $width = 110;
        $height = 200;
    }
    
    echo '
        <li>
        <div class="block-images-list">
        <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" />
        </div>
        <ul class="reviews-and-counts-list">
        <li><img src="images/eye.png" /><p>0</p></li>
        <li><img src="images/comment.png" /><p>0</p></li>
        </ul>
        <p class="style-title-list"><a href="">'.$row["title"].'</a></p>
        <a class="add-cart-style-list"></a>
        <p class="style-price-list"><strong id="price-list">'.$row["price"].'</strong> руб.</p>
        <div class="style-text-list">
        '.$row["mini_description"].'
        </div>
        </li>
        ';
   }
        while($row = mysql_fetch_array ($result));
    }
    	}
    else{
        echo 'Данная категория не найдена';
    }
?>
</ul>
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