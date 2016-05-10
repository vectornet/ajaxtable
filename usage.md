# Usage

AjaxTable is separated in two steps, configuration for build table and response after ajax request.

#### Configuration

For configuration, is required to instanciate Conf to put all configuration, as below:

```php
$Conf = new VectorDev\AjaxTable\Conf(base_url(['user', 'ajax-list']));
```
Conf will store all the information to generate a json for js lib

To create columns for your table, you will need to instanciate Column with information that you need to display.
```php
$ColumnName = new VectorDev\AjaxTable\Column('username', 'Username');
$ColumnEmail = new VectorDev\AjaxTable\Column('email', 'E-mail');
$ColumnAge = new VectorDev\AjaxTable\Column('age', 'Age');
```
Column will store all the information about your table column.

After this, you need to add Column to your configuration.
```php
$Conf->addColumn($ColumnName);
$Conf->addColumn($ColumnEmail);
$Conf->addColumn($ColumnAge);
```
To finish, you will build json configuration for AjaxTable js lib.
```html
<script>
    jQuery().ready(function(){
        $('#table').ajaxTable(<?php echo $Conf->getJson(); ?>);
    });
</script>
```
And done, your table is now configurated to work as ajaxtable to request and print data.

#### Response

For response, is required to work with Response, Row and Cell classes to get request, work with data and response to view.

```php
$Response = new VectorDev\AjaxTable\Response();
$Response->setRowsTotal($total_rows);

$limit = $Response->getLimitForSql(); // AjaxTable automatic build array for your use directly in your query
$order = $Response->getOrderByForSql(); // AjaxTable automatic build array with order by too

foreach($all_data as $data) {
	$CellUsername = new VectorDev\AjaxTable\Cell($data['user_username']);
	$CellEmail = new VectorDev\AjaxTable\Cell($data['user_mail']);
	$CellAge = new VectorDev\AjaxTable\Cell($data['user_age']);
	$Row = new VectorDev\AjaxTable\Row($CellUsername, $CellEmail, $CellAge);

	$Response->addRow($Row);
}

$Response->returnRequest();
```
