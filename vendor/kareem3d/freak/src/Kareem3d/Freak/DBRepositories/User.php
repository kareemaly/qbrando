<?php namespace Kareem3d\Freak\DBRepositories;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Kareem3d\Freak\Core\Element;
use Kareem3d\Membership\User as Kareem3dUser;

class User extends Kareem3dUser {

    const HIGH_ACCESS = 3;
    const MEDIUM_ACCESS = 2;
    const LOW_ACCESS = 1;

    /**
     * @var array
     */
    protected $extensions = array( 'Images' );

    /**
     * @param array $elements
     * @return array
     */
    public function filterElements( array $elements )
    {
        $that = $this;

        return array_filter($elements, function( Element $element ) use ($that)
        {
            return $that->hasControlOver( $element );
        });
    }

    /**
     * @param $element
     * @return bool
     */
    public function hasControlOver( Element $element )
    {
        return $this->elements()->where('element', $element->getName())->count() > 0;
    }

    /**
     * @param Element $element
     */
    public function controlElement( Element $element )
    {
        if(! $this->hasControlOver( $element ))
        {
            DB::table('user_element')->insert(array(
                'user_id' => $this->id,
                'element' => $element->getName()
            ));
        }
    }

    /**
     * @param $access
     * @return bool
     */
    public function isAccess( $access )
    {
        return $this->access == $access;
    }

    /**
     * @param ControlPanel $controlPanel
     * @return bool
     */
    public function hasAccessOn( ControlPanel $controlPanel )
    {
        return $this->getControlPanelPivotQuery( $controlPanel )->where('user_control_panel.accepted', true)->count() > 0;
    }

    /**
     * @return bool
     */
    public function hasHighAccess()
    {
        return $this->access >= self::HIGH_ACCESS;
    }

    /**
     * @return bool
     */
    public function hasMediumAccess()
    {
        return $this->access >= self::MEDIUM_ACCESS;
    }

    /**
     * @return bool
     */
    public function hasLowAccess()
    {
        return $this->access >= self::LOW_ACCESS;
    }

    /**
     * @param ControlPanel $controlPanel
     */
    public function registerControlPanel( ControlPanel $controlPanel )
    {
        if(! $this->hasRegisteredControlPanel($controlPanel))

            $this->controlPanels()->attach($controlPanel);
    }

    /**
     * @param ControlPanel $controlPanel
     * @return bool
     */
    public function hasRegisteredControlPanel( ControlPanel $controlPanel )
    {
        return $this->getControlPanelPivotQuery( $controlPanel )->count() > 0;
    }

    /**
     * @param ControlPanel $controlPanel
     * @return Builder
     */
    public function getControlPanelPivotQuery( ControlPanel $controlPanel )
    {
        return $this->controlPanels()->where('user_control_panel.control_panel_id', $controlPanel->id);
    }

    /**
     * @param $id
     * @return ControlPanel
     */
    public function getControlPanelById( $id )
    {
        return $this->controlPanels()->where('user_control_panel.control_panel_id', $id)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function controlPanels()
    {
        return $this->belongsToMany( ControlPanel::getClass(), 'user_control_panel' )->withPivot('accepted');
    }

    /**
     * @return Builder
     */
    public function elements()
    {
        return DB::table('user_element')->where('user_id', $this->id);
    }
}