<?php

// Register application client
require __DIR__ . '/ApplicationClient.php';

\Kareem3d\Freak\ClientRepository::register(new ApplicationClient());

// Start the freak manager
$freakManager = App::make('FreakManager');

$freakManager->start();