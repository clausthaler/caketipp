<?php
/**
 * Copyright 2010 - 2013, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2013, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
echo __d('users', 'Hi %s', $username);
echo "\n";
echo "\n";
echo __d('users', 'You have not tipped the following games within the next two days yet:');
echo "\n";
echo "\n";

foreach ($matches as $matchid => $match) {
    echo date("d.m.y H:i", $match['kickoff']) . ' ' . $match['name'] . "\n";
}

echo "\n";
echo __d('users', 'You can enter tipps here:');
echo "\n";
echo "\n";
echo Router::url(array('admin' => false, 'controller' => 'tipps', 'action' => 'entertipps'), true);
echo "\n";
echo "\n";
echo __d('users', 'If you do not wish to recieve these emails, please uncheck the option in your profile or drop me a line.');
