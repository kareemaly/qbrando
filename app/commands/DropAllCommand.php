<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DropAllCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'drop:all';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Drop all tables.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $queries = DB::select("SELECT concat('DROP TABLE IF EXISTS `', table_name, '`;')
                FROM information_schema.tables
                WHERE table_schema = '". DB::getDatabaseName() ."'");

        foreach($queries as $query)
        {
            $query = get_object_vars($query);
            $query = array_shift($query);

            DB::statement($query);
        }

        $this->comment('All tables dropped.');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
		);
	}

}