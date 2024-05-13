<?php

namespace Vis\Builder;

use Illuminate\Console\Command;

class CreateConfig extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'createConfig';

    protected $signature = 'admin:createConfig {table} {--fields=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command generate default config file, model and migration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    private $table;
    private $model;
    private $installPath;
    private $fields;

    public function __construct()
    {
        $this->installPath = __DIR__.'/../install/files/generateFiles';

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->table = $this->argument('table');
        $this->model = ucfirst(camel_case(str_singular($this->table)));
        $this->fields = $this->option('fields');

        $this->createModel();

        $this->createDefinition();

        $this->createMigration();
    }

    private function createModel()
    {
        $fileModel = app_path().'/Models/'.$this->model.'.php';

        if (file_exists($fileModel)) {
            if (! $this->confirm('Model '.$this->model.' is exist, replace model?')) {
                return;
            }
        }

        copy(
            $this->installPath.'/modelName.php',
            $fileModel
        );

        $this->replaceParams($fileModel);

        $this->info('Model '.$this->model.' created');
    }

    private function createDefinition()
    {
        $fileDefinition = config_path().'/builder/tb-definitions/'.$this->table.'.php';

        if (file_exists($fileDefinition)) {
            if (! $this->confirm('Definition '.$this->table.' is exist, replace definition?')) {
                return;
            }
        }

        copy(
            $this->installPath.'/Config.php',
            $fileDefinition
        );

        $this->replaceParams($fileDefinition);
        $this->replaceFieldsConfig($fileDefinition);

        $this->info('Definition '.$this->table.' created');
    }

    private function createMigration()
    {
        $nameMigration = date('Y_m_d_his').'_create_'.$this->table.'.php';
        $fileMigration = base_path().'/database/migrations/'.$nameMigration;

        copy(
            $this->installPath.'/Migration.php',
            $fileMigration
        );

        $this->replaceParams($fileMigration);
        $this->replaceFieldsMigration($fileMigration);

        $this->info('Migration '.$nameMigration.' created');
    }

    private function replaceParams($fileReplace)
    {
        $file = file_get_contents($fileReplace);
        $file = str_replace(
            ['modelName', 'tableName', 'tableUpName'],
            [$this->model, $this->table, ucfirst(camel_case($this->table))], $file);

        file_put_contents($fileReplace, $file);
    }

    private function replaceFieldsConfig($fileReplace)
    {
        $fieldsReplaceTabs = '';
        $fieldsDescription = '';

        if ($this->fields) {
            $arrFields = explode(',', $this->fields);

            foreach ($arrFields as $field) {
                if (strpos($field, ':')) {
                    $nameAndType = explode(':', $field);
                    $field = $nameAndType[0];
                    $type = $this->adaptiveFieldForConfig($nameAndType[1]);
                } else {
                    $type = 'text';
                }

                $fieldsReplaceTabs .= "'".$field."',
                ";

                $fieldsDescription .= "'".$field."' => [
            'caption' => '".$field."',
            'type' => '".$type."',
        ],
        ";
            }
        }

        $file = file_get_contents($fileReplace);
        $file = str_replace(
            ["'fieldsTabs',", "'fieldsDescription',"],
            [$fieldsReplaceTabs, $fieldsDescription],
            $file);

        file_put_contents($fileReplace, $file);
    }

    private function adaptiveFieldForConfig($type)
    {
        switch ($type) {
            case 'string':
                return 'text';
                break;
            case 'text':
                return 'textarea';
                break;
            case 'tinyInteger':
                return 'checkbox';
                break;
            case 'date':
                return 'datetime';
                break;
            default:
                return 'text';
        }
    }

    private function replaceFieldsMigration($fileReplace)
    {
        $fieldsReplace = '';

        if ($this->fields) {
            $arrFields = explode(',', $this->fields);

            foreach ($arrFields as $field) {
                if (strpos($field, ':')) {
                    $nameAndType = explode(':', $field);
                    $type = $nameAndType[1];
                    $field = $nameAndType[0];
                } else {
                    $type = 'string';
                }

                $fieldsReplace .= '$table->'.$type.'("'.$field.'");
            ';
            }
        }

        $file = file_get_contents($fileReplace);
        $file = str_replace(
            ['$table->fieldsReplace;'],
            [$fieldsReplace],
            $file);

        file_put_contents($fileReplace, $file);
    }
}
