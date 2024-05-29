<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @copyright  Copyright (c) 2024 Open LMS (https://www.openlms.net)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Restricción por código de autorización';
$string['requiresreleasecode'] = 'Obtiene un código de autorización particular.';
$string['title'] = 'Código de autorización';
$string['description'] = 'Este elemento del curso no estará disponible para los estudiantes hasta que el estudiante adquiera un código de autorización específico.';
$string['error_setvalue'] = 'Debe introducir un código de autorización.';
$string['cachedef_releasecodes'] = 'Códigos de autorización de usuario';
$string['privacy:reason'] = 'La Restricción por código de autorización no almacena datos personales.';
$string['privacy:metadata:availability_releasecode'] = 'Tabla de códigos de autorización';
$string['privacy:metadata:availability_releasecode:code'] = 'Código';
$string['privacy:metadata:availability_releasecode:courseid'] = 'Curso';
$string['privacy:metadata:availability_releasecode:userid'] = 'Usuario';
