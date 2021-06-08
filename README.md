# Availability Release Code Plugin
This plugin was contributed by the Open LMS Product Development team. Open LMS is an education technology company
dedicated to bringing excellent online teaching to institutions across the globe.  We serve colleges and universities,
schools and organizations by supporting the software that educators use to manage and deliver instructional content to
learners in virtual classrooms.

## How to Install
The plugin can be installed onto a Moodle instance as follows:

1. Place all files in `/availability/condition/releasecode/` directory.
2. Visit `admin/upgrade.php` or use the CLI script to upgrade your site.

Note: In case you need to uninstall it, you can visit Plugins Overview: Admin>Plugins>Plugins Overview and search for availability_releasecode.

## How it works
The Availability Release Code Plugin allows adding access restrictions through a unique "Code" to users for each assigned course.

Once the activity was set as restricted with a release code, this course item will not be available to students until the student acquires the specific release code.

## How to Use it
After installing the plugin, it is ready to use without any configuration.

Teachers (and other users with editing rights) can add the "Release Code Access Restriction" availability condition to activities / resources in their courses. While adding the condition, they have to define the release code which will allow only the users with this code to have access to the published activity or resource.

![availability_releasecode](https://i.imgur.com/lai2die.png)

If you want to learn more about using availability plugins in Moodle, please see https://docs.moodle.org/en/Restrict_access.

## License
Copyright (c) 2021 Open LMS (https://www.openlms.net)

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see <http://www.gnu.org/licenses/>.