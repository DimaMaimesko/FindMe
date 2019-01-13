<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;
$valuta=3; //EUR->GEl
?>
<?php
/*ïîäêëþ÷åíèÿ ÁÄ autoproko*/
$db_sql_host_main = "localhost";
$db_user_main = "u_autoprokH";
$db_pass_main = "CaETY1pr";
$db_db_name_main = "autoproko";
$db_base = mysqli_connect($db_sql_host_main, $db_user_main, $db_pass_main, $db_db_name_main);
mysqli_set_charset($db_main, 'utf8');

/*ïîäêëþ÷åíèÿ ÁÄ*/
$db_sql_host_base = "localhost";
$db_user_base = "root";
$db_pass_base = "";
$db_db_name_base = "lion-rentcar";
$db_base = mysqli_connect($db_sql_host_base, $db_user_base, $db_pass_base, $db_db_name_base);
mysqli_set_charset($db_base, 'utf8');
/*ïîëó÷àåì òîêåí äëÿ íàøåãî äîìåíà*/
$sql = "SELECT token FROM `prices_api_keys` WHERE `domain`=1";

$result = mysqli_query($db_base, $sql);
$arr = mysqli_fetch_assoc($result);
$token = $arr[ 'token' ];
/*ïðàéñ íà ñåãîäíÿøíþþ äàòó*/
$date_now = new \DateTime('now');
$date_now_formatted = $date_now -> format('Y-m-d');

/*ñîñòàâëÿåì ìàññèâ GET-ïàðàìåòðîâ*/
$get_data = [
    'token' => $token,
    'domain' => 1,
    'sorting' => 'asc',
    'type' => 'prices',
    'curr' => 7,
    'filters' => [
        'class_id' => [
            1,2,4,5,7,12
        ],
    ],
    'group_by' => 'true',
    'date' => $date_now_formatted,
    'country' => 3
];
/*äåëàåì CURL - çàïðîñ. åñëè ïðîâàëèëñÿ, ïîâòîðÿåì ïîïûòêó*/
try
{
    $data = makeRequest($get_data);
//    var_dump($filters);
//die;
} catch (\Exception $e)
{
    $data = makeRequest($get_data);
}



/*ïîëó÷àåì êàòàëîã è ñïèñîê óíèêàëüíûõ õàðàêòåðèñòèê, êîòîðûå ñîäåðæàòñÿ â êàòàëîãå*/
$catalog = $data -> catalog;
$filters = $data -> filters;

//$classes = [];
//foreach ($filters->classes as $class_id => $class_name){
//    $classes[$class_name] = 'Ïðîêàò àâòîìîáèëÿ êëàññà "'.$class_name.'" - îò  '
//}
//var_dump($filters);
//die;
// var_dump($catalog,$filters);
/*ïîëó÷àåì ñïèñîê çíà÷åíèé âðåìåííûõ èíòåðâàëîâ äëÿ ïðàéñà*/
$sql_intervals = "SELECT * FROM `intervals` WHERE `domain_groups_id`='1'";
$result_intervals = mysqli_query($db_base, $sql_intervals);
$intervals = mysqli_fetch_assoc($result_intervals);

//foreach ($intervals as $item){
//
//}
//$int1 = $intervals[ 'main_21' ];
//var_dump($intervals);
//var_dump(array_key_exists('main_21', $intervals));
//var_dump($intervals['main_21']);
foreach ($catalog as $class)
{
    foreach ($class as $car)
    {
        $path = '/images/cars/'.str_replace(' ', '_',$car->name_en.'_'.$car->sipp_name.'_'.$car->vg.'_'.($car -> ec*1000).'_'.$car->color_en).'.jpg';
        $car->image = $path;
    }
}
/*ôóíêöèÿ, êîòîðàÿ áóäåò âûïîëíÿòü CURL - çàïðîñ ïî òðåáóåìûì ïàðàìåòðàì*/
function makeRequest($get_data)
{
    $client = new Client();
    $response = $client -> get('prices-api.pp.ua/catalog?'.http_build_query($get_data));
    $body = $response -> getBody();
    $body_string = (string)$body;
    $data = json_decode($body_string);
    return $data;
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <META http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Àâòîïàðê êîìïàíèè, öåíû íà àðåíäó àâòî â Ãðóçèè</title>
    <META NAME="description" CONTENT="Íà äàííîé ñòðàíèöå ïðåäñòàâëåíû âñå àâòîìîáèëè êîìïàíèè Lion â Ãðóçèè, êîòîðûå äîñòóïíû â àðåíäó. Óçíàéòå àêòóàëüíûå öåíû íà ïðîêàò àâòî. Èëè ëó÷øå ïîçâîíèòå (+995) 514-64-64-44."/>
    <META NAME="keywords" CONTENT="àâòîïàðê"/>
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
<?php //echo phpinfo(); ?>
<div style="background: url(/images/logo3.png);">
    <div style="background:#fff;max-width:500px;border-radius: 50px;margin:0 auto;text-align: center;">
        <div style="font-size:20px;">
            <span style="font-size:14px;">Ìû ðàáîòàåì êðóãëîñóòî÷íî</span>
            <br />
            <span style="white-space: nowrap;">&#9742; <a href="tel:+995514646444">(+995) 514-64-64-44</a>*</span>
            <!--                    <span style="white-space: nowrap;">&#9742; <a href="tel:+995514646444">(+995) 514-64-64-44</a>*</span>-->
            <br />
            <span style="font-size:14px;">*Âû ìîæåòå ïèñàòü íà ýòîò íîìåð â </span>
            <span style="font-size:14px;white-space: nowrap;"><img src="/images/viber.png" alt="viber"/>Viber èëè <img src="/images/whatsapp.png" alt="whatsapp"/>WhatsApp</span>
            <br />
        </div>
        <img src="images/lion_2.png" alt="Ëîãîòèï êîìïàíèè Lion" />
    </div>
</div>
<div id="menu" class="default">
    <nav class="navbar navbar-default">
        <!-- Ëîãîòèï è ìîáèëüíîå ìåíþ -->
        <div class="navbar-header">
            <div class="mobile-phone">
                <a href="tel:+995514646444"><i class="fa fa-phone-square" aria-hidden="true"></i>(+995) 514-64-64-44</a>
            </div>
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle menu-btn">
                ìåíþ
            </button>
        </div>

        <!-- Íàâèãàöèîííîå ìåíþ -->
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="/">Ãëàâíàÿ</a></li>
                <li><a href="/ConditionsOfUse.html">Óñëîâèÿ àðåíäû</a></li>
                <li><a href="/VehicleFleet.html">Àâòîïàðê è öåíû</a></li>
                <li class="active">Àâòîïàðê è öåíû (API)</li>
                <li><a href="/Reviews.php">Îòçûâû</a></li>
                <li><a href="/news.html">Áëîã</a></li>
                <li><a href="/about.html">Î êîìïàíèè</a></li>
                <li><a href="/contact.php">Êîíòàêòû</a></li>
                <li><a class="order__nav" href="/order_Georgia.html">Çàáðîíèðîâàòü àâòî</a></li>

            </ul>
        </div>
    </nav>
</div>

<div style="text-align:center">
    <h1>Íàø àâòîïàðê</h1>
    <?php foreach ($catalog as $class_id => $class) : ?>
        <h3 class="subn"><?=$filters->classes->$class_id?></h3>
        <h3 ><?=$classes[$filters->classes->$class_id]?></h3>
        <?php foreach ($class as $car) : ?>
            <div class="rent-auto">
                <div class="char_wrap bord">
                    <h3><?= $car->name ?></h3>
                    <img  alt="<?= $car->name ?> ïðîêàò" title="<?= $car->name ?> ïðîêàò" src="<?=$car->image ?>">
                    <div class="char_txt"><span>Êóçîâ:</span><?= $car->body_name ?>,<br/>
                        <span>Äâèãàòåëü:</span> <?= $car->pow ?>ë.ñ., <br/>
                        <span>Òîïëèâî:</span><?= $car->fuel_name ?>, <br/>
                        <span>Òðàíñìèññèÿ:</span><?= $car->number_gears ?>-ñò. <?= $car->gearbox ?>,<br/>
                        <span>Òèï ïðèâîäà:</span><?= $car->trans_name ?>,<br/>
                        <span>Êîë-âî ìåñò:</span><?= $car->qm ?>
                        <h5>Äîï.êîìïëåêòàöèÿ:</h5>
                        <?= $car->equipment ?>
                    </div>
                    <a class="btn_order" target="_blank" href="short_order_Georgia.php?auto=<?= $car->name ?>" title="Çàêàçàòü ýòî àâòî â ïðîêàò">Çàêàçàòü</a>
                    <div class="rent-auto-car bord">

                        Çàëîã -  GEL<sup>*</sup><br>

                        &nbsp;&nbsp;îò &nbsp; 7 äíåé - <?= $car->main_22 ?> GEL<sup>*</sup>/ñóò<br>
                        &nbsp;îò 17 äíåé - <?= $car->main_23 ?> GEL<sup></sup>/ñóò<br>
                        &nbsp; îò 27 äíåé - <?= $car->main_24 ?> GEL<sup>*</sup>/ñóò
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    <?php endforeach ?>




</div>

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
                <li><a href="/prokat-avto-v-batumi.html">Ïðîêàò àâòî â Áàòóìè</a></li>
                <li><a href="/prokat-avto-v-kutaisi.html">Ïðîêàò àâòî â Êóòàèñè</a></li>
                <li><a href="/prokat-avto-v-tbilisi.html">Ïðîêàò àâòî â Òáèëèñè</a></li>
            </ul>
        </div>

        <div class="footer__item vertical">
            <div class="centr">
                <ul>
                    <li><a href="/VehicleFleet.html">Àâòîïàðê è öåíû</a></li>

                    <li><a href="/contact.php">Êîíòàêòû</a></li>
                </ul>
            </div>
        </div>

        <div class="footer__item">
            <a href="order_Georgia.html" class="order">Çàáðîíèðîâàòü àâòî</a>
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
