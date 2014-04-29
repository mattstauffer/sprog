<?php

namespace Craft;

/**
 * Sprog Variable provides access to database objects from templates
 */
class SprogVariable
{
    /**
     * Get all available routes
     *
     * @return array
     */
    public function getAllRoutes()
    {
        return craft()->sprogRoutes->getAllRoutes();
    }

    /**
     * Get a specific route. If no routeis found, returns null
     *
     * @param  int   $id
     * @return mixed
     */
    public function getRouteById($id)
    {
        return craft()->sprogRoutes->getRouteById($id);
    }
}
