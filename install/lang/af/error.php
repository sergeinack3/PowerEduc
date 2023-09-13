<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Automatically generated strings for Moodle installer
 *
 * Do not edit this file manually! It contains just a subset of strings
 * needed during the very first steps of installation. This file was
 * generated automatically by export-installer.php (which is part of AMOS
 * {@link http://docs.moodle.org/dev/Languages/AMOS}) using the
 * list of strings defined in /install/stringnames.txt.
 *
 * @package   installer
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('POWEREDUC_INTERNAL') || die();

$string['cannotcreatedboninstall'] = '<p>Kon nie die databasis skep nie.</p>
<p>Die gespesifiseerde databasis bestaan nie en die aangetoonde gebruiker het nie toestemming om die databasis te skep nie.</p>
<p>Die werf se administrateur moet die konfigurasie van databasisse verifieer.</p>';
$string['cannotcreatelangdir'] = 'Kan nie taalgids skep nie';
$string['cannotcreatetempdir'] = 'Kan nie tydelike gids skep nie';
$string['cannotdownloadcomponents'] = 'Kan nie komponente aflaai nie';
$string['cannotdownloadzipfile'] = 'Kan nie ZIP-lêer aflaai nie';
$string['cannotfindcomponent'] = 'Kan nie komponent vind nie';
$string['cannotsavemd5file'] = 'Kan nie md5-lêer stoor nie';
$string['cannotsavezipfile'] = 'Kan nie ZIP-lêer stoor nie';
$string['cannotunzipfile'] = 'Kan nie lêer uitpak nie';
$string['componentisuptodate'] = 'Komponent is bygewerk';
$string['dmlexceptiononinstall'] = '<p>\'n Databasisfout het opgeduik [{$a->errorcode}].<br />{$a->debuginfo}</p>';
$string['downloadedfilecheckfailed'] = 'Kontrolering van afgelaaide lêer het misluk';
$string['invalidmd5'] = 'Die kontroleveranderlike was verkeerd - probeer weer';
$string['missingrequiredfield'] = 'Een of ander verlangde veld ontbreek';
$string['remotedownloaderror'] = '<p>Die aflaai van die komponent na jou bediener het misluk. Verifieer asseblief instaanbediener se instellings; die uitbreiding PHP cURL word hoogs aanbeveel.</p>
<p>Jy moet die <a href="{$a->url}">{$a->url}</a>-lêer handmatig aflaai, dit na "{$a->dest}" in jou bediener kopieer en dit daar uitpak.</p>';
$string['wrongdestpath'] = 'Verkeerde bestemmingsroete';
$string['wrongsourcebase'] = 'Verkeerde bron vir URL-basis';
$string['wrongzipfilename'] = 'Verkeerde ZIP-lêernaam';
