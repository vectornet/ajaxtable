<?php
/**
 * Example view to see AjaxTable in action!
 *
 * @author Joubert <eu@redrat.com.br>
 * @copyright Copyright (c) 2016 Vector Internet Business and AjaxTable contributors
 * @license: MIT
 * @see https://github.com/vectornet/ajaxtable/
 * @see http://www.vectornet.com.br
 */

require(__DIR__.'/../src/autoload.php');

/*
 * AjaxTable is separated in two steps, create config and response request
 *
 * On this step we is creating config for requests
 */

/*
 * For new AjaxTable, you instantiate and set params
 */
$Conf = new VectorDev\AjaxTable\Conf('numbers.php');
$Conf->addParam('action', 'list');

/*
 * You can add columns in many ways, even with nicknames for Column
 */
$ColumnId = new VectorDev\AjaxTable\Column('id', '');

$En = new VectorDev\AjaxTable\Column('en-us', 'English');
$En->setOrder('en-us');

$Br = new VectorDev\AjaxTable\Col('pt-br', 'Brazilian');
$Br->setOrder('pt-br');

$Conf->addColumn($ColumnId);
$Conf->addColumn($En, $Br);
$Conf->addColumn(new VectorDev\AjaxTable\Column('es-es', 'Spanish'));
$Conf->addCol(
    new VectorDev\AjaxTable\Col('fr-fr', 'French'),
    new VectorDev\AjaxTable\Column('de-de', 'Germany')
);
$Conf->addColumn(
    new VectorDev\AjaxTable\Col('ja-jp', 'Japanese'),
    new VectorDev\AjaxTable\Column('ru-ru', 'Russian')
);
$Conf->addCol(new VectorDev\AjaxTable\Column('ko-kp', 'Korean'));
$Conf->addCol(new VectorDev\AjaxTable\Col('he-il', 'Hebrew'));


/**
 * You can set default sort for first request
 */
$Conf->setSortDesc('pt-br');

/**
 * You can instantiate your language class and change strings before add to config
 */
$Lang = new VectorDev\AjaxTable\Lang\PtBr();
//$Lang->useArrows();

$Lang->first = 'go to first NOW!';
$Lang->previous = 'much previous';
$Lang->next = 'wow next';
$Lang->last = 'endif;';

$Conf->setLang($Lang);

/*
 * You can change classes too, then I will use Classes to I build with my custom attr class
 *
 * $Class = new VectorDev\AjaxTable\Format\Classes();
 * $Class->prefix = 'myawesomeprefix';
 * $Conf->setClasses($Class);
 */

/*
 * And AjaxTable can be responsive
 */
$Conf->enableResponsive();

/*
 * If you have external js function, you can add to call before or after ajax requests
 */
$Conf->setJsFunctionAfter('report');

?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajaxgrid</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="../css/ajaxtable.min.css" media="screen" type="text/css" />
    <link rel="stylesheet" href="../css/ajaxtable-responsive.min.css" media="screen" type="text/css" />
    <script src="https://code.jquery.com/jquery-1.10.2.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../js/ajaxtable.js"></script>
    <script>
        jQuery().ready(function(){
            /*
             * And here you build your json config for AjaxTable js lib
             */
            $('#my-awesome-table').ajaxTable(<?php echo $Conf->getJson(); ?>);

            /*
             * You can add external params for request
             */
            $('#go').bind('click', function() {
                $('#my-awesome-table').setRequestParam('search', $('#search').val());
                $('#my-awesome-table').refresh();
            });

            /*
             * You can clear params
             */
            $('#clear').bind('click', function() {
                $('#my-awesome-table').clearRequestParams();
                $('#my-awesome-table').refresh();
                $('#search').val('');
            });
        });

        /**
         * And you can call functions before and after requests
         * @returns {void}
         */
        function report() {
            $('#my-response').append('<p> Ajax response on '+new Date().toString()+'</p>');
            $('.javascript-action').bind('click', function(){
                alert($(this).data('number')+' in spanish is '+$(this).data('spanish'));
            });
        }
    </script>
    <style>
        .wrapper {
            margin: 0 auto;
            padding: 10px;
            max-width: 1100px;
        }

        .javascript-link {
            color: #0000ee;
            text-decoration: underline;
        }

        .javascript-link span, .javascript-action {
            cursor: pointer;
        }

        .javascript-action:hover {
            background-color: #778899 !important;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <input type="text" name="search" id="search" placeholder="Search in English or Brazilian"/>
        <button name="go" id="go">Search</button>
        <button name="clear" id="clear">Clear</button>
        Or click in Brazilian portuguese to see translation
        <br /><br />
        <table id="my-awesome-table"></table>
        <div id="my-response"></div>
    </div>
</body>
</html>
