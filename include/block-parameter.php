<div id="block-parameter">
<p class="header-title">Поиск по параметрам</p>
<p class="title-filter">Стоимость</p>
<form method="GET" action="search-filter.php">

<div id="block-input-price">
<ul>
<li><p>от</p></li>
<li><input type="text" id="start-price" name="start_price" value="100" /></li>
<li><p>до</p></li>
<li><input type="text" id="end-price" name="end_price" value="1000" /></li>
<li></li>
</ul>
</div>

<div id="blocktrackbar"></div>
<p class="title-filter">Игры по платформе</p>
<ul class="checkboxbrand">
<li><input type="checkbox" id="checkbrend1" /><label for="checkbrend1">Бренд 1</label></li>
<li><input type="checkbox" id="checkbrend2" /><label for="checkbrend2">Бренд 2</label></li>
<li><input type="checkbox" id="checkbrend3" /><label for="checkbrend3">Бренд 3</label></li>
</ul>

<input type="submit" name="submit" id="button-param-search" value=" " />

</form>
</div>