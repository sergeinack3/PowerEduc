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

$string['admindirname'] = 'Directorio Admin';
$string['availablelangs'] = 'Packs d\'idiomas disponibles';
$string['chooselanguagehead'] = 'Triar idioma';
$string['chooselanguagesub'] = 'Per favor, tríe un idioma pa lo proceso d\'instalación. Este idioma s\'usará tamién como idioma per defecto d\'o puesto, si bien puede cambiar-se mas abance.';
$string['clialreadyconfigured'] = 'Lo fichero de configuración config.php ya existe. Per favor, faga servir admin/cli/install_database.php pa instalar Moodle en este puesto.';
$string['clialreadyinstalled'] = 'Lo fichero de configuración config.php ya existe. Per favor, faga servir admin/cli/install_database.php pa actualizar Moodle en este puesto.';
$string['cliinstallheader'] = 'Programa d\'instalación Moodle de linia de comando {$a}';
$string['clitablesexist'] = 'Tablas de base de datos ya existents, la instalación CLI no puede continar.';
$string['databasehost'] = 'Servidor d\'a base de datos';
$string['databasename'] = 'Nombre d\'a base de datos';
$string['databasetypehead'] = 'Tríe lo controlador d\'a base de datos';
$string['dataroot'] = 'Directorio de Datos';
$string['datarootpermission'] = 'Permiso directorios de datos';
$string['dbprefix'] = 'Prefixo de tablas';
$string['dirroot'] = 'Directorio de Moodle';
$string['environmenthead'] = 'Comprebando lo suyo entorno';
$string['environmentsub2'] = 'Cada versión de Moodle tiene bell requisito minimo d\'a versión de PHP y un numero obligatorio d\'extensions de PHP.
Una comprebación de l\'entorno completo se realiza antes de cada instalación y actualización. Per favor, se meta en contacto con l\'administrador d\'o servidor si no sabes cómo instalar la nueva versión u habilitar las extensions PHP.';
$string['errorsinenvironment'] = 'La comprebación de l\'entorno fallo!';
$string['installation'] = 'Instalación';
$string['langdownloaderror'] = 'L\'idioma "{$a}" no podió estar descargau. Lo proceso d\'instalación continará en Anglés.';
$string['memorylimithelp'] = '<p>Lo limite de memoria PHP en o suyo servidor ye actualment {$a}.</p>

<p>Esto puede ocasionar que Moodle tienga problemas de memoria mas abance, especialment si vusté tiene activaus muitos modulos y/u muitos usuarios.</p>

<p>Recomendamos que configure PHP con o limite mas alto posible, y.g. 40M.
I hai quantas formas de fer esto:</p>
<ol>
<li>Si puede fer-lo, recompile PHP con <i>--enable-memory-limit</i>.
Esto fa que Moodle fixe per ell mesmo lo limite de memoria.</li>
<li>Si tiene acceso a lo fichero php.ini, puede cambiar l\'achuste <b>memory_limit</b>
a, digamos, 40M. Si no lo tiene, pida a lo suyo administrador que lo faiga per vusté.</li>
<li>En qualques servidors PHP vusté puede creyar en o directorio Moodle un fichero .htaccess que contienga esta linia:
<p><blockquote>php_value memory_limit 40M</blockquote></p>
<p>Manimenos, en qualques servidors esto fa que <b>totas</b> las pachinas PHP deixen de funcionar (podrá veyer las errors quan mire las pachinas) de traza que habrá d\'eliminar lo fichero .htaccess.</p></li>
</ol>';
$string['paths'] = 'Rotas';
$string['pathserrcreatedataroot'] = 'Lo directorio d\'os datos ({$a->dataroot}) no puede estar creyau per l\'instalador.';
$string['pathshead'] = 'Confirme las rotas';
$string['pathsrodataroot'] = 'Lo directorio dataroot no tiene permisos d\'escritura.';
$string['pathsroparentdataroot'] = 'Lo directorio pai ({$a->parent}) no tiene permisos d\'escritura. Lo directorio d\'os datos ({$a->dataroot}) no puede estar creyau per l\'instalador.';
$string['pathssubadmindir'] = 'Muit pocos servidors web usan /admin como un URL especial pa acceder a un panel de control u bella cosa semellant. Lamentablement, esto dentra en conflicto con a ubicación estandard pa las pachinas d\'administración de Moodle. Vusté puede solucionar este problema, renombrando lo directorio admin en a suya instalación Moodle, metendo un nuevo nombre aquí. Per eixemplo: <em> moodleadmin </em>. Esto solucionará los vinclos d\'administración en instalación Moodle.';
$string['pathssubdataroot'] = 'Necesita bell espacio an que Moodle puede alzar los fichers puyaus. En este directorio ha de poder LEYER y ESCRIBIR l\'usuario d\'o servidor web (per lo cheneral \'nobody\',  \'apache\' u \'www-data\'), pero no ha de poder-se acceder a esta carpeta dreitament a traviés d\'a web. L\'instalador tractará de creyar-la si no existe.';
$string['pathssubdirroot'] = '<p>Rota completa d\'o directorio que contiene lo codigo de  Moodle.</p>';
$string['pathssubwwwroot'] = 'Adreza web completa pa acceder a Moodle. No ye posible acceder a Moodle utilizando multiples adrezas. Si lo suyo puesto tiene quantas adrezas publicas ha de configurar redireccions permanents en totas ellas, fueras d\'en2 esta. Si lo suyo puesto web ye accesible tanto dende una intranet como dende Internet, escriba aquí l\'adreza publica y configure la suya DNS pa que los usuarios d\'o suyo intranet puedan tamién utilizar l\'adreza publica.';
$string['pathsunsecuredataroot'] = 'La ubicación de dataroot no ye segura';
$string['pathswrongadmindir'] = 'Lo directorio admin no existe';
$string['phpextension'] = 'Extensión PHP {$a}';
$string['phpversion'] = 'Versión PHP';
$string['phpversionhelp'] = '<p>Moodle requiere a lo menos una versión de PHP 4.3.0 u 5.1.0 ((5.0.x tiene una serie de problemas conoixius).</p>
<p>En este momento ye executando la versión {$a}</p>
<p>Ha d\'actualizar PHP u tresladar-se a unatro servidor con una versión mas recient de PHP!<br />
(En caso de 5.0.x podría tamién revertir a la versión 4.4.x)</p>';
$string['welcomep10'] = '{$a->installername} ({$a->installerversion})';
$string['welcomep20'] = 'Si ye veyendo esta pachina ye perque ha puesto executar lo paquet <strong>{$a->packname} {$a->packversion}</strong> en o suyo ordinador. Parabiens!';
$string['welcomep30'] = 'Esta versión de <strong>{$a->installername}</strong> incluye las
    aplicacions necesarias pa que <strong>Moodle</strong> funcione en o suyo ordinador,
    principalment:';
$string['welcomep40'] = 'Lo paquet tamién incluye <strong>Moodle {$a->moodlerelease} ({$a->moodleversion})</strong>.';
$string['welcomep50'] = 'L\'uso de totas las aplicacions d\'o paquet ye gubernau per las suyas respectivas
    licencias. Lo programa <strong>{$a->installername}</strong> ye
    <a href="http://www.opensource.org/docs/definition_plain.html">codigo ubierto</a> y se distribuye
    baixo licencia <a href="http://www.gnu.org/copyleft/gpl.html">GPL</a>.';
$string['welcomep60'] = 'Las siguients pachinas le guiarán a traviés de qualques sencillos pasos pa configurar
    y achustar <strong>Moodle</strong> en o suyo ordinador. Puede utilizar las valors per defecto sucherius u,
    de forma opcional, modificar-los pa que s\'achusten a las suyas necesidatz.';
$string['welcomep70'] = 'Prete en o botón "Siguient" pa continar con a configuración de <strong>Moodle</strong>.';
$string['wwwroot'] = 'Adreza Web';
