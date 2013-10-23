<?php

use Illuminate\Support\Str;

$string = '<?php

use Kareem3d\Controllers\FreakController;

class '. ucfirst($elementName) .'Controller extends FreakController {
';


$constructorInjection = '
    /**';

foreach($models as $mm)
{
    $string .=
        '
    /**
     * @var '. $mm .'
     */
    protected $' . strtolower(Str::plural($mm)) . ';' . PHP_EOL;

    $constructorInjection .= '
     * @var ' . $mm;

}

$constructorInjection .= '
     */';


$string .= $constructorInjection . '
    public function __construct( ';

foreach($models as $mm)
{
    $string .= $mm . ' $'. Str::plural(strtolower($mm)).', ';
}

$string = rtrim($string, ', ');

$string .= ' )
	{';

foreach($models aS $mm)
{
    $string .= '
        $this->' . Str::plural(strtolower($mm)) . ' = $' . Str::plural(strtolower($mm)) . ';';
}

$string .= '
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
	    $'.$pluralModel.' = $this->'. $pluralModel .'->get();

		return View::make(\'freak::'. $pluralElement .'.data\', compact(\''.$pluralModel.'\'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getShow($id)
	{
		$'.$singularModel.' = $this->'.$pluralModel.'->find( $id );

		return View::make(\'freak::'. $pluralElement .'.detail\', compact(\''.$singularModel.'\'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make(\'freak::'. $pluralElement .'.add\');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit($id)
	{
		$'.$singularModel.' = $this->'.$pluralModel.'->find( $id );

		return View::make(\'freak::'. $pluralElement .'.add\', compact(\''.$singularModel.'\'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postIndex()
	{
		$'.$singularModel.' = $this->'.$pluralModel.'->newInstance(Input::get(\''.$model.'\'));

		if($'.$singularModel.'->isValid())
		{
		    $'.$singularModel.'->save();
		}
		else
		{
		    $this->addModelErrors($'.$singularModel.');
		}

		return $this->jsonResponse(array(\'insert_id\' => $'.$singularModel.'->id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function putIndex($id)
	{
		$'.$singularModel.' = $this->'.$pluralModel.'->find($id)->update(Input::get(\''.$element.'\'));
		
		return $this->jsonResponse();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function deleteIndex($id)
	{
		$this->'.$pluralModel.'->find($id)->delete();
	
		return $this->jsonResponse();
	}

}';

return $string;