<?php
// replace with file to your own project bootstrap
$entityManager = \core\DBConnect::getConnection();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);