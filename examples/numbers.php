<?php
/**
 * Example controller to see AjaxTable in action!
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
 * On this step we will create response for ajax request
 */

if (isset($_REQUEST['action'])) {
    switch ($_REQUEST['action']) {
        case 'list':
            /*
             * With this example have numbers.sql for you to play
             */
            $conn = mysqli_connect('localhost', 'the-amazing-root', 'with-his-awesome-password', 'and-awesome-database');
            $conn->query('SET CHARACTER_SET utf8');
            $conn->query('SET NAMES utf8');

            /*
             * Ok, you will need to create new response for AjaxTable
             */
            $Response = new VectorDev\AjaxTable\Response();

            /*
             * If you send custom params, probably you will need for use in your model
             */
            $params = $Response->getCustomParams();

            /*
             * With AjaxTable you can get limit and order array ready for use in your query
             */
            $limit = $Response->getLimitForSql();
            $order = $Response->getOrderByForSql();

            /*
             * You can try cause error to see that AjaxTable will understand the error and display a message in view
             */
            //$whyguy = 4 / 0;

            /*
             * AjaxTable need how many lines in total to build pagination, then you set this
             */
            $qtotal = 'SELECT COUNT(*) AS total from numbers';
            if (isset($params['search'])) {
                $qtotal .= ' WHERE `en-us` LIKE "%'.$params['search'].'%" OR `pt-br` LIKE "%'.$params['search'].'%"';
            }

            $data = $conn->query($qtotal);
            $total = $data->fetch_array(MYSQLI_ASSOC)['total'];

            $Response->setRowsTotal($total);


            $query = [];

            $query[] = 'SELECT * from numbers';
            if (isset($params['search'])) {
                $query[] = 'WHERE `en-us` LIKE "%'.$params['search'].'%" OR `pt-br` LIKE "%'.$params['search'].'%"';
            }
            if ($order) {
                $query[] = 'ORDER BY '.implode(' ', $order);
            }
            $query[] = 'LIMIT '.implode(', ', $limit);

            $data = $conn->query(implode(' ', $query));

            while ($rows = $data->fetch_array(MYSQLI_ASSOC)) {

                /*
                 * You create new Cells for for Columns on view
                 */
                $CellId = new VectorDev\AjaxTable\Cell($rows['id']);

                /*
                 * Look here, Cell support html
                 */
                $CellEnUs = new VectorDev\AjaxTable\Cell('<b>'.$rows['en-us'].'</b>');
                $CellEnUs->addClass('html-ruan');


                $alert_msg = $rows['en-us'].' in brazilian is '.$rows['pt-br'];
                /*
                 * Also javascript too!
                 */
                $CellPtBr = new VectorDev\AjaxTable\Cell(
                    '<span onclick="javascript:alert(\''.$alert_msg.'\');">'.$rows['pt-br'].'</span>'
                );
                $CellPtBr->addClass('javascript-link', 'javascript-href');

                $CellEsEs = new VectorDev\AjaxTable\Cell('Click to see');
                $CellEsEs->addClass('javascript-action');
                $CellEsEs->addData('number', $rows['id']);
                $CellEsEs->addData('spanish', $rows['es-es']);

                $CellFrFr = new VectorDev\AjaxTable\Cell($rows['fr-fr']);
                $CellDeDe = new VectorDev\AjaxTable\Cell($rows['de-de']);
                $CellJaJp = new VectorDev\AjaxTable\Cell($rows['ja-jp']);
                $CellRuRu = new VectorDev\AjaxTable\Cell($rows['ru-ru']);

                /*
                 * After create Cells, you need a Row to store your Cells
                 */
                $Row = new VectorDev\AjaxTable\Row($CellId, $CellEnUs, $CellPtBr, $CellEsEs, $CellFrFr, $CellDeDe);
                $Row->addCell($CellJaJp);
                $Row->addCell($CellRuRu);
                $Row->addCell(new VectorDev\AjaxTable\Cell($rows['ko-kp']));
                $Row->addCell(new VectorDev\AjaxTable\Cell($rows['he-il']));

                /*
                 * And add Row to response
                 */
                $Response->addRow($Row);

                /*
                 * A simple way to add too if you want to be fast and furious :)
                 *
                $Response->addRow(
                    new VectorDev\AjaxTable\Row(
                        new VectorDev\AjaxTable\Cell($rows['id']),
                        new VectorDev\AjaxTable\Cell($rows['en-us']),
                        new VectorDev\AjaxTable\Cell($rows['pt-br']),
                        new VectorDev\AjaxTable\Cell($rows['es-es']),
                        new VectorDev\AjaxTable\Cell($rows['fr-fr']),
                        new VectorDev\AjaxTable\Cell($rows['de-de']),
                        new VectorDev\AjaxTable\Cell($rows['ja-jp']),
                        new VectorDev\AjaxTable\Cell($rows['ru-ru']),
                        new VectorDev\AjaxTable\Cell($rows['ko-kp']),
                        new VectorDev\AjaxTable\Cell($rows['he-il'])
                    )
                );
                 *
                 */
            }

            /*
             * Finally, build response to view
             */
            $Response->returnRequest();
            break;
    }
}
