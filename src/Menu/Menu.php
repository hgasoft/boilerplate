<?php namespace Sebastienheyd\Boilerplate\Menu;

use Lavary\Menu\Menu as LavaryMenu;

class Menu extends LavaryMenu
{
    public function make($name, $callback)
    {
        if(is_callable($callback))
        {
            if (!array_key_exists($name, $this->menu)) {
                $this->menu[$name] = new Builder($name, $this->loadConf($name));
            }

            // Registering the items
            call_user_func($callback, $this->menu[$name]);

            // Storing each menu instance in the collection
            $this->collection->put($name, $this->menu[$name]);

            // Make the instance available in all views
            \View::share($name, $this->menu[$name]);

            return $this->menu[$name];
        }
    }
}