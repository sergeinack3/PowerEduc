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

$string['cannotcreatedboninstall'] = '<p> Tidak dapat membuat basis data. </p> <p> Basis data yang ditentukan tidak ada dan pengguna yang diberikan tidak memiliki izin untuk membuat basis data. </p> <p> Administrator situs harus memverifikasi konfigurasi basis data. < / p>';
$string['cannotcreatelangdir'] = 'Tidak dapat membuat direktori lang';
$string['cannotcreatetempdir'] = 'Tidak dapat membuat direktori temp';
$string['cannotdownloadcomponents'] = 'Tidak dapat mengunduh komponen';
$string['cannotdownloadzipfile'] = 'Tidak dapat mengunduh berkas ZIP';
$string['cannotfindcomponent'] = 'Tidak dapat menemukan komponen';
$string['cannotsavemd5file'] = 'Tidak dapat menyimpan berkas md5';
$string['cannotsavezipfile'] = 'Tidak dapat menyimpan berkas ZIP';
$string['cannotunzipfile'] = 'Tidak dapat mengekstrak berkas';
$string['componentisuptodate'] = 'Komponen sudah mutakhir';
$string['dmlexceptiononinstall'] = '<p>Terjadi kesalahan basis data [{$a->errorcode}].<br />{$a->debuginfo}</p>';
$string['downloadedfilecheckfailed'] = 'Pemeriksaan berkas yang diunduh gagal';
$string['invalidmd5'] = 'Variabel periksa salah - coba lagi';
$string['missingrequiredfield'] = 'Beberapa ruas wajib tidak ada';
$string['remotedownloaderror'] = '<p> Pengunduhan komponen ke server Anda gagal. Harap verifikasi setelan proksi; ekstensi PHP cURL sangat direkomendasikan. </p> <p> Anda harus mengunduh berkas <a href="{$a->url} ">{$a->url} </a> secara manual, menyalinnya ke"{$a->dest} "di server Anda dan uraikan di sana. </p>';
$string['wrongdestpath'] = 'Jalur tujuan salah';
$string['wrongsourcebase'] = 'Basis URL sumber salah';
$string['wrongzipfilename'] = 'Nama file ZIP salah';
