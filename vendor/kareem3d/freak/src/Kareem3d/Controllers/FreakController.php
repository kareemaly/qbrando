<?php namespace Kareem3d\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\MessageBag;
use Kareem3d\Eloquent\Model;
use Kareem3d\Freak\Core\PackageData;
use Kareem3d\Freak\DBRepositories\ControlPanel;
use Kareem3d\Freak;
use Kareem3d\Freak\DBRepositories\User;
use Kareem3d\Freak\Environment;

class FreakController extends \Illuminate\Routing\Controllers\Controller {

    /**
     * @var array
     */
    protected $extra = array();

    /**
     * @var Model
     */
    protected $model = null;

    /**
     * @var \Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * Validate model by adding errors
     */
    protected function validateAndSave( Model $model = null )
    {
        $model ? $this->setModel($model) : null;

        if($this->model)
        {
            // If model is not valid then add model errors
            if(! $this->model->isValid()) $this->addModelErrors($this->model);

            // Save model if is valid
            else $this->model->save();
        }
    }

    /**
     * @return \Illuminate\Support\MessageBag
     */
    public function getErrors()
    {
        return $this->errors ?: $this->errors = new MessageBag();
    }

    /**
     * @return void
     */
    protected function addModelErrors()
    {
        $models = func_get_args();

        foreach($models as $model)
        {
            $this->errors = $model->getValidatorMessages()->merge($this->getErrors()->toArray());
        }
    }

    /**
     * @param $messages
     * @param string|array $messages
     */
    protected function addErrors( $messages )
    {
        $this->errors = $this->getErrors()->merge((array) $messages);
    }

    /**
     * @return bool
     */
    protected function hasErrors()
    {
        return ! $this->getErrors()->isEmpty();
    }

    /**
     * @param $success
     * @return mixed
     */
    protected function redirectWithSuccess( $success )
    {
        return Redirect::back()->with('success', (array) $success);
    }

    /**
     * @return mixed
     */
    protected function redirectWithErrors()
    {
        return Redirect::back()->withInput()->withErrors($this->getErrors()->toArray());
    }

    /**
     * @return array
     */
    protected function getExtra()
    {
        return $this->extra;
    }

    /**
     * @param array $extra
     */
    protected function setExtra( array $extra = array() )
    {
        $this->extra = $extra;
    }

    /**
     * @param $key
     * @param $value
     */
    protected function addExtra( $key, $value )
    {
        $this->extra[ $key ] = $value;
    }

    /**
     * @param Model $model
     */
    protected function setModel( Model $model )
    {
        $this->model = $model;
    }

    /**
     * @return Model|null
     */
    protected function getModel()
    {
        return $this->model;
    }

    /**
     * @param $message
     * @return mixed
     */
    protected function redirectBack($message)
    {
        if($this->hasErrors())
        {
            return $this->redirectWithErrors();
        }

        return $this->redirectWithSuccess($message);
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonError(array $data = array())
    {
        return Response::json(array(
            'status' => 'fail',
            'data'   => $data
        ));
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonSuccess(array $data = array())
    {
        return Response::json(array(
            'status' => 'success',
            'data' => $data
        ));
    }

    /**
     * @param Model $model
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonValidateResponse( Model $model = null )
    {
        $this->validateAndSave($model);

        return $this->jsonModelResponse();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonModelResponse()
    {
        if($this->hasErrors())
        {
            return $this->jsonError($this->getErrors()->toArray());
        }

        return $this->jsonModelSuccess();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonModelSuccess()
    {
        if(! $this->getModel()) return $this->jsonSuccess();

        return $this->jsonSuccess(array(
            'packageData' => array(
                'model_type' => get_class($this->getModel()),
                'model_id'   => $this->getModel()->id,
                'extra'      => $this->getExtra(),
                'from'       => 'element',
            ),
            'insert_id' => $this->getModel()->id
        ));
    }

    /**
     * Use packages
     */
    protected function usePackages()
    {
        $packages = func_get_args();

        foreach($packages as $package)
        {
            $this->usePackage($package);
        }
    }

    /**
     * Use package.
     *
     * @param $package
     */
    protected function usePackage( $package )
    {
        // Get package registered in freak...
        $package = $this->freak()->findPackage($package);

        // Get current element and add package to him...
        $this->freak()->getCurrentElement()->addPackage($package);
    }

    /**
     * Set packages data with the current model and extra
     */
    protected function setPackagesData(Model $model = null, array $extra = array())
    {
        $model = $model ?: $this->getModel();
        $extra = !empty($extra) ? $extra : $this->getExtra();

        foreach($this->getCurrentElement()->getPackages() as $package)
        {
            $package->addData(new PackageData($model, 'element', $extra));
        }
    }

    /**
     * @return Freak\Core\Element|null
     */
    protected function getCurrentElement()
    {
        return $this->freak()->getCurrentElement();
    }

    /**
     * @param $package
     * @param $model
     * @param array $extra
     */
    protected function setPackageData( $package, $model, $extra = array() )
    {
        $this->getCurrentElement()->getPackage($package)->setData($model, $extra);
    }

    /**
     * @return ControlPanel
     */
    protected function getControlPanel()
    {
        return Environment::instance()->controlPanel();
    }

    /**
     * @return User
     */
    protected function getAuthUser()
    {
        return Environment::instance()->authUser();
    }

    /**
     * @return Freak
     */
    protected function freak()
    {
        return Freak::instance();
    }

    /**
     * @return string
     */
    public static function getClass()
    {
        return get_called_class();
    }
}