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

$string['cannotcreatedboninstall'] = '<p>Az adatbázis nem hozható létre.</p> <p>A megadott adatbázis nem létezik, a felhasználó pedig nem jogosult létrehozni egyet.</p> <p>A portál rendszergazdájának ellenőrizni kell az adatbázis-beállításokat.</p>';
$string['cannotcreatelangdir'] = 'Nem hozható létre a lang könyvtár.';
$string['cannotcreatetempdir'] = 'Nem hozható létre a temp könyvtár.';
$string['cannotdownloadcomponents'] = 'Az összetevőket nem lehet letölteni.';
$string['cannotdownloadzipfile'] = 'A tömörített állományt nem lehet letölteni.';
$string['cannotfindcomponent'] = 'Nincs meg az összetevő.';
$string['cannotsavemd5file'] = 'Az md5 állományt nem lehet elmenteni.';
$string['cannotsavezipfile'] = 'A tömörített állományt nem lehet elmenteni.';
$string['cannotunzipfile'] = 'A tömörített állományt nem lehet kicsomagolni.';
$string['componentisuptodate'] = 'Az összetevő a legfrissebb.';
$string['dmlexceptiononinstall'] = '<p>Adatbázishiba történt [{$a->errorcode}].<br />{$a->debuginfo}</p>';
$string['downloadedfilecheckfailed'] = 'A letöltött állomány ellenőrzése nem sikerült.';
$string['invalidmd5'] = 'Az ellenőrző változó hibás volt – próbálkozzék ismét';
$string['missingrequiredfield'] = 'Egy szükséges mező hiányzik.';
$string['remotedownloaderror'] = 'Az összetevőt nem lehet szerverére letölteni, ellenőrizze a proxy beállításait. Ajánlatos a PHP cURL-bővítmény használata. A(z) <a href="{$a->url}">{$a->url}</a> állományt töltse le kézzel, másolja át szerverén a(z) "{$a->dest}" célkönyvtárba, és csomagolja ki ott.';
$string['wrongdestpath'] = 'Hibás célútvonal.';
$string['wrongsourcebase'] = 'Hibás forrás-URL.';
$string['wrongzipfilename'] = 'Hibás a tömörített állomány neve.';
