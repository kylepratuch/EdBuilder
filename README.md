# EdBuilder

##### Streamlined curriculum design App, December 3, 2015

#### By _**Kyle Pratuch**_

## Description

EdBuilder is a tool designed to streamline the curriculum creation process for educators. Once logged in, users can add courses to their account. They can then add units of study to their courses and lessons to their units. All of the information is stored in a database and can be referenced from anywhere.

EdBuilder was built in PHP with the Silex framework and Twig templating. On the backend, it uses a fairly simple MySQL database organized as a "tree" of one-to-many relationships. This keeps curriculum organization strict, but straightforward and simple.

This is definitely my pet project. It's something I thought about making before I really knew how to code at all, and it's nice to see that idea coming together. I have plans to build out the front and back over time as my skills improve!

## Planned Improvements
Not necessarily in this order:
* Support for aligning lessons to standards

* "Account at a glance" view from dashboard

* Text editing with markdown in lesson narratives

## Setup

If you're looking to test this app yourself:

1. Clone repository from GitHub.

2. Run ```composer install``` in top level of project folder.

3. In a new terminal tab, enter ```mysql.server start```.

4. Then enter ```mysql -uroot -proot``` (you now have MySql running)

5. Start an apache server (another new tab in terminal) with ```apachectl start```

6. Open your browser to ```localhost:8080/phpmyadmin``` This may differ depending on your setup.

7. Import the database files from the top level of your project folder using phpMyadmin. Do this by clicking the import tab in phpMyadmin and choosing one of the files and clicking "GO".

8. Start another terminal tab. Open a php server ```php -S localhost:8000``` in the /web directory.

9. Direct your browser to ```localhost:8000``` .

10. Start planning!


## Technologies Used

* HTML
* CSS
* PHP
* PHPUnit
* MySQL
* Silex
* Twig
* ircmaxell/password_compat

### Legal

Copyright (c) 2015 **_Kyle Pratuch_**

This software is licensed under the MIT license.

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
