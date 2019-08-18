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

	// GIVE PERMISSION FOR ALL ENTITIES TO ADMIN
	$seedsTmp = $newSeeds;
	$seedsContent = file_get_contents($seedsTmp);
	foreach (array_map(create_function('$entity', 'return $entity->controller;'), $structure) as $entityName)
	{
		$seedsContent = str_replace('/*additionalEntity*/', ", '{$entityName}'/*additionalEntity*/", $seedsContent);
	}
	file_put_contents($newSeeds, $seedsContent);
}

/*
	BUILD MENU
*/
if (in_array($toGenerate, array('all', 'controller')))
{
	$dashboardTmp = '../views/dashboard.php';
	$dashboardContent = file_get_contents($dashboardTmp);
	foreach (array_map(create_function('$entity', 'return $entity->controller;'), $structure) as $entityName)
	{
		$dashboardContent = str_replace('/*additionalEntity*/', ", '{$entityName}'/*additionalEntity*/", $dashboardContent);
	}
	file_put_contents($dashboardTmp, $dashboardContent);
}

foreach ($structure as $entity)
{

	/*
		SET DEFAULT VALUES TO SIMPLIFY JSON
	*/
	$entity->model = $entity->model ?: "{$entity->controller}s";
	$entity->table = $entity->table ?: strtolower($entity->controller);
	foreach ($entity->fields as $index => $field)
	{
		$entity->fields[$index]->type = $field->type ?: 'string';
		$entity->fields[$index]->label = $field->label ?: ucfirst($field->name);
		$entity->fields[$index]->index= 'relation' === $field->type;
	}

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
		$theads = "(object) array('mData' => '{$entity->fields[0]->name}', 'sTitle' => '{$entity->fields[0]->label}'),\n";
		$dtField= "->select('{$entity->table}.{$entity->fields[0]->name}')";
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
			    )),";
					break;
				case 'int': 
			    $fields .= "\n        array (
		      'name' => '{$field->name}',
		      'label'=> '{$field->label}',
		      'attributes' => array(
		        array('data-number' => 'true')
			    )),";
					break;
				case 'date':
			    $fields .= "\n        array (
		      'name' => '{$field->name}',
		      'label'=> '{$field->label}',
		      'attributes' => array(
		        array('data-date' => 'datepicker')
			    )),";
					break;
				case 'datetime':
			    $fields .= "\n        array (
		      'name' => '{$field->name}',
		      'label'=> '{$field->label}',
		      'attributes' => array(
		        array('data-date' => 'datetimepicker')
			    )),";
					break;
				case 'string': 
				default:
					if (isset($field->options))
					{
						$options = '';
						foreach ($field->options as $option) {
							$options .= "\n                array('text' => '{$option}', 'value' => '{$option}'),";
						}
					  $fields .= "\n        array (
				      'name' => '{$field->name}',
				      'label'=> '{$field->label}',
				      'options' => array({$options}
				      )
					  ),";
					}
					else
					{
					  $fields .= "\n        array (
				      'name' => '{$field->name}',
				      'label'=> '{$field->label}',
					  ),";
					}
					break;
			}
		}
		$modelContent = str_replace('{{fields}}', $fields, $modelContent);
		$modelContent = str_replace('{{theads}}', $theads, $modelContent);
		$modelContent = str_replace('{{dtField}}', $dtField, $modelContent);
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
		$indexes = '';
		foreach ($entity->fields as $field) {
			if (true === $field->index)
			{
				$indexes .= ",\n        KEY `{$field->name}` (`{$field->name}`)";
			}
			switch ($field->type) {
				case 'date': 
					$fields .= "\n        `{$field->name}` DATE NOT NULL,";
					break;
				case 'datetime': 
					$fields .= "\n        `{$field->name}` DATETIME NOT NULL,";
					break;
				case 'int': 
					$fields .= "\n        `{$field->name}` INT(11) NOT NULL,";
					break;
				case 'string': 
				default: $fields .= "\n        `{$field->name}` varchar(255) NOT NULL,";
					break;
			}
		}
		$migrationContent = str_replace('{{fields}}', $fields, $migrationContent);
		$migrationContent = str_replace('{{indexes}}', $indexes, $migrationContent);
		$filePrefix = sprintf('%03d', $newMigration);
		file_put_contents("../migrations/{$filePrefix}_{$entity->migration}.php", $migrationContent);
		$newMigration++;
	}
}