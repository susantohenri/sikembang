<?php

$json = $argv[1];
$toGenerate = $argv[2] ?: 'all';
$structure = json_decode(file_get_contents($json));

if (in_array($toGenerate, array('all', 'migration')))
{
	// COLLECT MIGRATION INDEX
	$existingMigrations = scandir('../migrations');
	$seeds = $latestMigration = end($existingMigrations);
	$latestMigrationNumber = explode('_', $latestMigration);
	$newMigration = (int) $latestMigrationNumber[0];

	// MOVE SEEDS TO THE END OF LIST
	$newSeedsNumber = sprintf('%03d', $newMigration + count($structure));
	$oldSeeds = "../migrations/{$seeds}";
	$newSeeds = "../migrations/{$newSeedsNumber}_seeds.php";
	rename($oldSeeds, $newSeeds);
}

foreach ($structure as $entity)
{

	/*
		GENERATING CONTROLLER
	*/
	if (in_array($toGenerate, array('all', 'controller')))
	{
		$controllerTmp = 'Controller.php';
		$controllerContent = file_get_contents($controllerTmp);
		$controllerContent = str_replace('{{controllerName}}', $entity->controller, $controllerContent);
		$controllerContent = str_replace('{{modelName}}', $entity->model, $controllerContent);
		file_put_contents("../controllers/{$entity->controller}.php", $controllerContent);		
	}

	/*
		GENERATING MODEL
	*/
	if (in_array($toGenerate, array('all', 'model')))
	{
		$modelTmp = 'Model.php';
		$modelContent = file_get_contents($modelTmp);
		$modelContent = str_replace('{{modelName}}', $entity->model, $modelContent);
		$modelContent = str_replace('{{tableName}}', $entity->table, $modelContent);

		$fields = '';
		foreach ($entity->fields as $field) {
			switch ($field->type) {
				case 'relation':
					$fields .= "\n        array (
		      'name' => '{$field->name}',
		      'label'=> '{$field->label}',
		      'options' => array(),
		      'attributes' => array(
		        array('data-autocomplete' => 'true'),
		        array('data-model' => '{$field->model}'),
		        array('data-field' => '{$field->field}')
			    ),";
					break;
				case 'int': 
			    $fields .= "\n        array (
		      'name' => '{$field->name}',
		      'label'=> '{$field->label}',
		      'attributes' => array(
		        array('data-number' => 'true')
			    ),";
					break;
				case 'string': 
				default:
			    $fields .= "\n        array (
		      'name' => '{$field->name}',
		      'label'=> '{$field->label}',
			  ),";
					break;
			}
		}
		$modelContent = str_replace('{{fields}}', $fields, $modelContent);
		file_put_contents("../models/{$entity->model}.php", $modelContent);
	}

	/*
		GENERATING MIGRATION
	*/
	if (in_array($toGenerate, array('all', 'migration')))
	{
		$entity->migration = str_replace("_", '}}', $entity->table);
		$migrationTmp = 'Migration.php';
		$migrationContent = file_get_contents($migrationTmp);
		$migrationContent = str_replace('{{migrationName}}', $entity->migration, $migrationContent);
		$migrationContent = str_replace('{{tableName}}', $entity->table, $migrationContent);

		$fields = '';
		foreach ($entity->fields as $field) {
			switch ($field->type) {
				case 'int': 
					$fields .= "\n        `{$field->name}` INT(11) NOT NULL,";
					break;
				case 'string': 
				default: $fields .= "\n        `{$field->name}` varchar(255) NOT NULL,";
					break;
			}
		}
		$migrationContent = str_replace('{{fields}}', $fields, $migrationContent);
		$filePrefix = sprintf('%03d', $newMigration);
		file_put_contents("../migrations/{$filePrefix}_{$entity->migration}.php", $migrationContent);
		$newMigration++;
	}
}