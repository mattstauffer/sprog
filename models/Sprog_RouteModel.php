<?php

namespace Craft;

/**
 * Route Model
 *
 * View-only View Model for routes
 */
class Sprog_RouteModel extends BaseModel
{
    /**
     * Defines what is returned when someone puts {{ route }} directly
     * in their template.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Define the attributes this model will have.
     *
     * @return array
     */
    public function defineAttributes()
    {
        return array(
            'id'    => AttributeType::Number,
            'name'  => AttributeType::String,
        );
    }
}
