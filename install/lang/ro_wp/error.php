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

$string['cannotcreatedboninstall'] = '<p>Nu se poate crea baza de date.</p>
<p>Baza de date specificată nu există și utilizatorul dat nu are permisiunea de a crea baza de date.</p>
<p>Administratorul site-ului trebuie să verifice configurația bazei de date.</p>';
$string['cannotcreatelangdir'] = 'Nu se poate crea directorul lang';
$string['cannotcreatetempdir'] = 'Nu se poate crea directorul temporar';
$string['cannotdownloadcomponents'] = 'Nu se pot descărca componente';
$string['cannotdownloadzipfile'] = 'Nu se poate descărca fișierul ZIP';
$string['cannotfindcomponent'] = 'Componenta nu poate fi găsită';
$string['cannotsavemd5file'] = 'Nu se poate salva fișierul md5';
$string['cannotsavezipfile'] = 'Nu se poate salva fișierul ZIP';
$string['cannotunzipfile'] = 'Nu se poate dezarhiva fișierul';
$string['componentisuptodate'] = 'Componenta este actualizată';
$string['dmlexceptiononinstall'] = '<p>A apărut o eroare în baza de date [{$a->errorcode}].<br />{$a->debuginfo}</p>';
$string['downloadedfilecheckfailed'] = 'Verificarea fișierului descărcat a eșuat';
$string['invalidmd5'] = 'Variabila de verificare a fost greșită - încercați din nou';
$string['missingrequiredfield'] = 'Un câmp obligatoriu lipsește';
$string['remotedownloaderror'] = '<p>Descărcarea componentei pe serverul dvs. nu a reușit. Vă rugăm să verificați setările proxy; extensia PHP cURL este foarte recomandată.</p>
<p>Trebuie să descărcați manual fișierul <a href="{$a->url}">{$a->url}</a>, copiați-l în „{$a->dest}" de pe server și dezarhivați-l Acolo.</p>';
$string['wrongdestpath'] = 'Cale de destinație greșită';
$string['wrongsourcebase'] = 'Baza de adrese URL sursă este greșită';
$string['wrongzipfilename'] = 'Numele fișierului ZIP greșit';
