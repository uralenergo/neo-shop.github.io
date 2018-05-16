<div id="block-category">
<p class="header-title">Категории товаров</p>
<ul>
<li><a id="index1"><img src="images/music.png" id="music-image"/>Музыка</a>
<ul class="category-section">
<li><a href="view_cat.php?type=music"><strong>Вся музыка</strong></a></li>
<?php
	$result = mysql_query("SELECT * FROM category WHERE kategory='music'",$link);
    if (mysql_num_rows($result)>0)
    {
        $row = mysql_fetch_array($result);
        do
        {
            echo '
            <li><a href="view_cat.php?cat='.strtolower($row['vid']).'&type='.$row["kategory"].'">'.$row["vid"].'</a></li>
            ';
            }
            while ($row = mysql_fetch_array($result));
    }
?>
</ul>
</li>
<li><a id="index2"><img src="images/films.png" id="films-image"/>Фильмы</a>
<ul class="category-section">
<li><a href="view_cat.php?type=films"><strong>Все фильмы</strong></a></li>
<?php
	$result = mysql_query("SELECT * FROM category WHERE kategory='films'",$link);
    if (mysql_num_rows($result)>0)
    {
        $row = mysql_fetch_array($result);
        do
        {
            echo '
            <li><a href="view_cat.php?cat='.strtolower($row['vid']).'&type='.$row["kategory"].'">'.$row["vid"].'</a></li>
            ';
            }
            while ($row = mysql_fetch_array($result));
    }
?>
</ul>
</li>
<li><a id="index3"><img src="images/game.png" id="game-image"/>Игры</a>
<ul class="category-section">
<li><a href="view_cat.php?type=game"><strong>Все игры</strong></a></li>
<?php
	$result = mysql_query("SELECT * FROM category WHERE kategory='game'",$link);
    if (mysql_num_rows($result)>0)
    {
        $row = mysql_fetch_array($result);
        do
        {
            echo '
            <li><a href="view_cat.php?cat='.strtolower($row['vid']).'&type='.$row["kategory"].'">'.$row["vid"].'</a></li>
            ';
            }
            while ($row = mysql_fetch_array($result));
    }
?>
</ul>
</li>
<li><a id="index4"><img src="images/toy.png" id="toy-image"/>Игрушки</a>
<ul class="category-section">
<li><a href="view_cat.php?type=toy"><strong>Все игрушки</strong></a></li>
<?php
	$result = mysql_query("SELECT * FROM category WHERE kategory='toy'",$link);
    if (mysql_num_rows($result)>0)
    {
        $row = mysql_fetch_array($result);
        do
        {
            echo '
            <li><a href="view_cat.php?cat='.strtolower($row['vid']).'&type='.$row["kategory"].'">'.$row["vid"].'</a></li>
            ';
            }
            while ($row = mysql_fetch_array($result));
    }
?>
</ul>
</li>
<li><a id="index5"><img src="images/acessuar.png" id="acessuar-image"/>Аксессуары</a>
<ul class="category-section">
<li><a href="view_cat.php?type=acessuar"><strong>Все аксессуары</strong></a></li>
<?php
	$result = mysql_query("SELECT * FROM category WHERE kategory='acessuar'",$link);
    if (mysql_num_rows($result)>0)
    {
        $row = mysql_fetch_array($result);
        do
        {
            echo '
            <li><a href="view_cat.php?cat='.strtolower($row['vid']).'&type='.$row["kategory"].'">'.$row["vid"].'</a></li>
            ';
            }
            while ($row = mysql_fetch_array($result));
    }
?>
</li>
</ul>
</ul>
</div>