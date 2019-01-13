<?php
$valuta=3; //EUR->GEl
$classes = array(
    array('class' => 'эконом', 'name' => 'Прокат автомобиля Эконом класс - от 60 GEL'),
    array('class' => 'cедан', 'name' => 'Прокат автомобиля Седан класс - от 90 GEL',
        'items' => array(
            array('subclass_id' => 1, 'sub_name' => 'Средний'),
            array('subclass_id' => 2, 'sub_name' => 'Седан Бизнес'),
            array('subclass_id' => 3, 'sub_name' => 'Седан/минивен')
        )),
    array('class' => 'SUV', 'name' => 'Прокат Джипов - от 90 GEL'),
    array('class' => 'премиум', 'name' => 'Прокат Премиум класса - от 240 GEL'),
);
include "libs/db.php";
$link = mysqli_connect($dblocation, $dbuser, $dbpasswd, $dbname);
mysqli_query($link, "SET NAMES 'utf8'");
mysqli_query($link, "SET CHARACTER SET 'utf8'");
mysqli_query($link, "SET SESSION collation_connection = 'utf8_general_ci'");
?>

<!DOCTYPE html> 
<html lang="ru">
<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Автопарк компании, цены на аренду авто в Грузии</title>
	<META NAME="description" CONTENT="На данной странице представлены все автомобили компании Lion в Грузии, которые доступны в аренду. Узнайте актуальные цены на прокат авто. Или лучше позвоните (+995) 514-64-64-44."/>
	<META NAME="keywords" CONTENT="автопарк"/>
	<link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
    <link href="css/index.css" rel="stylesheet" type="text/css" />
	<META name="robots" content="index,nofollow"/>
	<link rel="icon" href="/favicon.ico" type="image/x-icon"/>
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" charset="utf-8"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>   
	<meta name="yandex-verification" content="e41d780c44e7ee68" />
</head>

<body>

    <div style="background: url(/images/logo3.png);">
                <div style="background:#fff;max-width:500px;border-radius: 50px;margin:0 auto;text-align: center;">
                    <div style="font-size:20px;">
                        <span style="font-size:14px;">Мы работаем круглосуточно</span>
                        <br />
                        <span style="white-space: nowrap;">&#9742; <a href="tel:+995514646444">(+995) 514-64-64-44</a>*</span>
    <!--                    <span style="white-space: nowrap;">&#9742; <a href="tel:+995514646444">(+995) 514-64-64-44</a>*</span>-->
                        <br />
                        <span style="font-size:14px;">*Вы можете писать на этот номер в </span>
                        <span style="font-size:14px;white-space: nowrap;"><img src="/images/viber.png" alt="viber"/>Viber или <img src="/images/whatsapp.png" alt="whatsapp"/>WhatsApp</span>
                        <br />
                    </div>
                    <img src="images/lion_2.png" alt="Логотип компании Lion" />
                </div>
        </div>
        <div id="menu" class="default">
            <nav class="navbar navbar-default">
                <!-- Логотип и мобильное меню -->
                <div class="navbar-header">
                    <div class="mobile-phone">
                        <a href="tel:+995514646444"><i class="fa fa-phone-square" aria-hidden="true"></i>(+995) 514-64-64-44</a>
                    </div>
                    <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle menu-btn">
                        меню
                    </button>
                </div>
                
                <!-- Навигационное меню -->
                <div id="navbarCollapse" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="/">Главная</a></li>
                        <li><a href="/ConditionsOfUse.html">Условия аренды</a></li>
                        <li class="active">Автопарк и цены</li>
                        <li><a href="/Reviews.php">Отзывы</a></li>
                        <li><a href="/news.html">Блог</a></li>
                        <li><a href="/about.html">О компании</a></li>
                        <li><a href="/contact.php">Контакты</a></li>
                        <li><a class="order__nav" href="/order_Georgia.html">Забронировать авто</a></li>
											
                    </ul>
                </div>
            </nav>
        </div>
    
            <div style="text-align:center">
               <h1>Наш автопарк</h1>
                <?php foreach ($classes as $value) : ?>
                    
                <h2 class="nme"><?= $value['name'] ?><sup>*</sup>/сутки</h2>
                <?php
                
                if ($value['items'] != 0) {
                    foreach ($value['items'] as $sub) :
                    
                        echo '<h3 class="subn">' . $sub['sub_name'] . '</h3>';
                        $query = "SELECT * FROM autopark_georgia LEFT JOIN labels ON autopark_georgia.labels_id=labels.id WHERE autopark_georgia.subclass_id='{$sub['subclass_id']}' ";
                        $result = mysqli_query($link, $query);
                        while ($autoparks = mysqli_fetch_assoc($result)): ?>
                            <?php
														if ($autoparks['src']) {
															echo "<div class='rent-auto ".$autoparks['src']."'>";
															echo "<img class='label-img-new' src='images/labels/{$autoparks['src']}.png'>";
														} else {
																echo "<div class='rent-auto'>";
															
														}
														//перевод € в GEL
														$deposit=$autoparks['deposit']*$valuta;
														$price1=$autoparks['price_1']*$valuta;
														$price2=$autoparks['price_2']*$valuta;
														$price3=$autoparks['price_3']*$valuta;
														
														
														?>
                       <!--     <div class="rent-auto">-->
                               
                           <!-- <div class="text_wrap bord">
                                
                            </div>
-->
                            
                                
                            <div class="char_wrap bord">
														
															<h3><?= $autoparks['name'] ?></h3>
                              <img  alt="<?= $autoparks['name'] ?> прокат" title="<?= $autoparks['name'] ?> прокат" src="<?=$autoparks['img'] ?>">
                              <div class="char_txt"><span>Кузов:</span><?= $autoparks['body_type'] ?>,<br/>
                                    <span>Двигатель:</span><?= round($autoparks['engine'], 2) ?> л, <?= $autoparks['power'] ?>л.с., <br/> 
                                    <span>Топливо:</span><?= $autoparks['fuel_type'] ?>, <br/> 
                                    <span>Трансмиссия:</span><?= $autoparks['number_gears'] ?>-ст. <?= $autoparks['gearbox'] ?>,<br/>
                                    <span>Тип привода:</span><?= $autoparks['drive_type'] ?>,<br/>
                                    <span>Кол-во мест:</span><?= $autoparks['seat'] ?>
                                    <h5>Доп.комплектация:</h5>
                                    <?= $autoparks['equipment'] ?>
                                </div>

                                <a class="btn_order" target="_blank" href="short_order_Georgia.php?auto=<?= $autoparks['name'] ?>" title="Заказать это авто в прокат">Заказать</a>
                                <div class="rent-auto-car bord">
                                    Залог - <?= $deposit ?> GEL<sup>*</sup><br>
                                    от&nbsp;&nbsp;&nbsp;7 дней - <?= $price1 ?> GEL<sup>*</sup>/сут<br>
                                    от 17 дней - <?= $price2 ?> GEL<sup>*</sup>/сут<br>
                                    от 27 дней - <?= $price3 ?> GEL<sup>*</sup>/сут
                                </div>
                            </div>
                                  
                            
                    
                            
                
                </div>
                        
                        <?php
                endwhile;
                    
                endforeach;
                } else {
                    
                $query = "SELECT * FROM autopark_georgia LEFT JOIN labels ON autopark_georgia.labels_id=labels.id WHERE autopark_georgia.class='{$value['class']}' ";
                $result = mysqli_query($link, $query);
                while ($autoparks = mysqli_fetch_assoc($result)):  ?>

											<?php
											if ($autoparks['src']) {
						 						echo "<div class='rent-auto ".$autoparks['src']."'>";
												echo "<img class='label-img-new' src='images/labels/{$autoparks['src']}.png'>";
											} else {
												echo "<div class='rent-auto'>";
												
											}
											
											//перевод € в GEL
											$deposit=$autoparks['deposit']*$valuta;
											$price1=$autoparks['price_1']*$valuta;
											$price2=$autoparks['price_2']*$valuta;
											$price3=$autoparks['price_3']*$valuta;
											?>
                                
                            <div class="char_wrap bord">
															
                                <h3><?= $autoparks['name'] ?></h3>
                                <img alt="<?= $autoparks['name'] ?> прокат" title="<?= $autoparks['name'] ?> прокат" src="<?= $autoparks['img'] ?>" > 
                                <div class="char_txt"><span>Кузов:</span><?= $autoparks['body_type'] ?>,<br/>
                                    <span>Двигатель:</span><?= round($autoparks['engine'], 2) ?> л, <?= $autoparks['power'] ?>л.с., <br/> 
                                    <span>Топливо:</span>&nbsp;<?= $autoparks['fuel_type'] ?>, <br/> 
                                    <span>Трансмиссия:</span><?= $autoparks['number_gears'] ?>-ст. <?= $autoparks['gearbox'] ?>,<br/>
                                    <span>Тип привода:</span><?= $autoparks['drive_type'] ?>,<br/>
                                    <span>Кол-во мест:</span><?= $autoparks['seat'] ?>
                                    <h5>Доп.комплектация:</h5>
                                    <?= $autoparks['equipment'] ?>
                                </div>
                                <a class="btn_order" target="_blank" href="short_order_Georgia.php?auto=<?= $autoparks['name'] ?>" title="Заказать это авто в прокат">Заказать</a>
                                <div class="rent-auto-car bord">
                                    Залог - <?= $deposit ?> GEL<sup>*</sup><br>
                                    от&nbsp;&nbsp;&nbsp;7 дней - <?= $price1 ?> GEL<sup>*</sup>/сут<br>
                                    от 17 дней - <?= $price2 ?> GEL<sup>*</sup>/сут<br>
                                    от 27 дней - <?= $price3 ?> GEL<sup>*</sup>/сут
                                </div>
                            </div>
                        </div>
                   
                        <?php
                endwhile;        
                           }
                endforeach; 
                        ?></div>
    
    

<div class="clrfx"></div>


  

<footer>
    <div class="footer">
        <div class="footer__item vertical">
            <a href="" class="social"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
            <a href="" class="social"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a>
            <a href="" class="social"><i class="fa fa-vk" aria-hidden="true"></i></a>
            <a href="" class="social"><i class="fa fa-odnoklassniki-square" aria-hidden="true"></i></a>
        </div>
        <div class="footer__item">
            <ul>
                <li><a href="/prokat-avto-v-batumi.html">Прокат авто в Батуми</a></li>
                <li><a href="/prokat-avto-v-kutaisi.html">Прокат авто в Кутаиси</a></li>
                <li><a href="/prokat-avto-v-tbilisi.html">Прокат авто в Тбилиси</a></li>
            </ul>
        </div>

        <div class="footer__item vertical">
            <div class="centr">
                <ul>
                    <li><a href="/VehicleFleet.html">Автопарк и цены</a></li>

                    <li><a href="/contact.php">Контакты</a></li>
                </ul>
            </div>
        </div>

        <div class="footer__item">
            <a href="order_Georgia.html" class="order">Забронировать авто</a>
        </div>
    </div>
</footer>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-20807107-7', 'auto');
  ga('send', 'pageview');

</script>
		<script>
		  
    $(document).ready(function(){
        
        var $menu = $("#menu");
            
        $(window).scroll(function(){
            if ( $(this).scrollTop() > 100 && $menu.hasClass("default") ){
                $menu.fadeOut('fast',function(){
                    $(this).removeClass("default")
                           .addClass("fixed transbg")
                           .fadeIn('fast');
                });
            } else if($(this).scrollTop() <= 100 && $menu.hasClass("fixed")) {
                $menu.fadeOut('fast',function(){
                    $(this).removeClass("fixed transbg")
                           .addClass("default")
                           .fadeIn('fast');
                });
            }
        });//scroll
        
        $menu.hover(
            function(){
                if( $(this).hasClass('fixed') ){
                    $(this).removeClass('transbg');
                }
            },
            function(){
                if( $(this).hasClass('fixed') ){
                    $(this).addClass('transbg');
                }
            });//hover
    });//jQuery
</script>

</body>
</html>

