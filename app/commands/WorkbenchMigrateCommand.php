<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class WorkbenchMigrateCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'wmigrate';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return \WorkbenchMigrateCommand
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
        $bench = $this->argument('bench');


        if($bench)
        {

            $bracket1 = strpos($bench, '[');
            $bracket2 = strpos($bench, ']');

            if($bracket1 > -1)
            {
                $prefix = substr($bench, 0, $bracket1);
                $betweenBrackets = substr($bench, $bracket1 + 1, $bracket2 - $bracket1 - 1);

                $benches = explode(',', $betweenBrackets);

                $this->migrateBenches($benches, $prefix);
            }

            else
            {
                $benches = explode(',', $bench);

                $this->migrateBenches($benches);
            }
        }

        else
        {

            $this->call('wmigrate', array(
                'bench' => 'kareem3d/[code,url,routing,marketing,membership,messaging,notification,images,interaction,freak,ecommerce]'
            ));
        }
	}

    /**
     * @param $benches
     * @param string $prefix
     */
    protected function migrateBenches( $benches, $prefix = '' )
    {
        foreach($benches as $bench)
        {
            $bench = $prefix . $bench;

            $this->call('migrate', array('--package' => $bench));
        }
    }

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
            array('bench', InputArgument::OPTIONAL, 'Benches.')
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