<?php

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Example
| 
| 1) Without Variable
| 
| $routes['home'] = 'user/profile';
| 
| 2) With Variable
| 
| $routes['user/[@any]'] = 'user/profile';
|
| 
| 
|
*/
$routes['profile/[@any]'] = 'user/profile';