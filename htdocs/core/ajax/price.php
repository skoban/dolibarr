<?php
/* Copyright (C) 2012 Regis Houssin  <regis@dolibarr.fr>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 *       \file       htdocs/core/ajax/price.php
 *       \brief      File to get ht and ttc
 */

if (! defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL','1'); // Disables token renewal
if (! defined('NOREQUIREMENU'))  define('NOREQUIREMENU','1');
//if (! defined('NOREQUIREHTML'))  define('NOREQUIREHTML','1');
if (! defined('NOREQUIREAJAX'))  define('NOREQUIREAJAX','1');
if (! defined('NOREQUIRESOC'))   define('NOREQUIRESOC','1');
//if (! defined('NOREQUIRETRAN'))  define('NOREQUIRETRAN','1');

require('../../main.inc.php');

$action		= GETPOST('action','alpha');
$pu_ht		= price2num(GETPOST('pu_ht','alpha'));
$pu_ttc		= price2num(GETPOST('pu_ttc','alpha'));
$tva_tx		= str_replace('*','',GETPOST('tva_tx','alpha'));

/*
 * View
 */

top_httphead();

//print '<!-- Ajax page called with url '.$_SERVER["PHP_SELF"].'?'.$_SERVER["QUERY_STRING"].' -->'."\n";

// Load original field value
if (! empty($action) && (isset($pu_ht) || isset($pu_ttc)) && isset($tva_tx))
{
	$return=array();

	if ($action == 'get_ttc') {

		$price = price2num($pu_ht * (1 + ($tva_tx/100)), 'MU');

	}
	else if ($action == 'get_ht') {

		$price = price2num($pu_ttc / (1 + ($tva_tx/100)), 'MU');

	}

	$return['price'] = price($price);

	echo json_encode($return);
}

?>