<?php namespace Kareem3d\Freak\Menu;

use Freak;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Kareem3d\Freak\Core\DefaultInterface;
use Kareem3d\Freak\DBRepositories\User;

class Menu implements DefaultInterface {

    const ACTIVE_HTML_CLASS = 'class="active"';

    /**
     * @var Item[]
     */
    protected $rootItems = array();

    /**
     * @param Item $item
     * @return string
     */
    public function activeClass( Item $item )
    {
        return $this->isActive($item) ? static::ACTIVE_HTML_CLASS : '';
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isActive( Item $item )
    {
        foreach($item->getChildren() as $child)
        {
            if($this->isActive( $child ) === true) return true;
        }

        return $item->isActive();
    }

    /**
     * @return Item
     */
    public function getActiveLeaf()
    {
        $tree = $this->getActiveTree();

        return count($tree) > 0 ? $tree[ count($tree) - 1 ] : null;
    }

    /**
     * @param Item[]|null $items
     * @param Item[] $tree
     * @return Item[]
     */
    public function getActiveTree( $items = null, array $tree = array() )
    {
        $items = $items === null ? $this->getRootItems() : $items;

        foreach($items as $rootItem)
        {
            if($this->isActive($rootItem))
            {
                $tree[] = $rootItem;

                return $this->getActiveTree( $rootItem->getChildren(), $tree );
            }
        }

        return $tree;
    }

    /**
     * @param Item $item
     * @param int|bool $position
     */
    public function addRootItem( Item $item, $position = false )
    {
        // If position was defined
        if($position !== false)
        {
            $this->setItemPosition( $item, $position );
        }
        else
        {
            $this->rootItems[] = $item;
        }
    }

    /**
     * @param Item[] $items
     * @param int|bool $position
     */
    public function addRootItems( array $items, $position = false )
    {
        foreach($items as $item)
        {
            $this->addRootItem($item, $position);

            if($position !== false) $position += 1;
        }
    }

    /**
     * @return int
     */
    public function countRootItems()
    {
        return count($this->rootItems);
    }

    /**
     * @param Item $item
     * @param int $position
     */
    public function setItemPosition( Item $item, $position )
    {
        // First shift down one step to free a position for this new item
        for($i = $this->countRootItems() - 1; $i >= $position; $i--)
        {
            $this->rootItems[ $i + 1 ] = $this->rootItems[ $i ];
        }

        $this->rootItems[$position] = $item;
    }

    /**
     * @return array
     */
    public function getRootItems()
    {
        return $this->rootItems;
    }

    /**
     * Setup with the default settings
     *
     * @return $this
     */
    public function useDefaults()
    {
        $this->addGeneralMenuItem();

        $this->addMembersMenuItem();

        return $this;
    }

    /**
     * Add general menu item
     */
    public function addGeneralMenuItem()
    {
        $this->addRootItem(Item::make('General', '', Icon::make('icon-home'))->addChildren(

            Item::make('Dashboard', 'home', Icon::make('icol-dashboard'))

        ), 0);
    }

    /**
     * Add members menu item
     */
    public function addMembersMenuItem()
    {
        $this->addRootItem(Item::make('Member', '', Icon::make('icon-user'))->addChildren(

//            Item::make('Profile Page', 'user/profile', Icon::make('icol-user')),
            Item::make('Mail Page', 'mail/inbox', Icon::make('icol-email')),
            Item::make('Contact List', 'my-contacts', Icon::make('icol-vcard'))

        ));
    }
}