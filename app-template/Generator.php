<?php

$replacements = array(
	'entityName' => $argv[1],
	'tableName' => $argv[2],
	'migrationName' => strtolower(str_replace('_', '', $argv[2]))
);

/*
	GENERATING CONTROLLER
*/
$controllerTmp = 'app-template/Controller.php';
$controllerContent = file_get_contents($controllerTmp);
foreach ($replacements as $placeholder => $value)
{
	$controllerContent = str_replace($placeholder, $value, $controllerContent);
}
file_put_contents("application/controllers/{$replacements['entityName']}.php", $controllerContent);

/*
	GENERATING MODEL
*/
$modelTmp = 'app-template/Model.php';
$modelContent = file_get_contents($modelTmp);
foreach ($replacements as $placeholder => $value)
{
	$modelContent = str_replace($placeholder, $value, $modelContent);
}
file_put_contents("application/models/{$replacements['entityName']}s.php", $modelContent);

/*
	GENERATING MIGRATION
*/
$existingMigrations = scandir('application/migrations');
$latestMigration = $existingMigrations[count($existingMigrations)-2];
$latestMigrationNumber = explode('_', $latestMigration);
$latestMigrationNumber = (int) $latestMigrationNumber[0];
$newMigration = $latestMigrationNumber + 1;

$migrationTmp = 'app-template/Migration.php';
$migrationContent = file_get_contents($migrationTmp);
foreach ($replacements as $placeholder => $value)
{
	$migrationContent = str_replace($placeholder, $value, $migrationContent);
}
file_put_contents("application/migrations/{$newMigration}_{$replacements['migrationName']}.php", $migrationContent);