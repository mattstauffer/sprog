<?php namespace Craft;

class SprogPlugin extends BasePlugin
{
    public function getName()
    {
        return Craft::t('Sprog');
    }

    public function getVersion()
    {
        return '0.1';
    }

    public function getDeveloper()
    {
        return 'ninetwelve (Anthony Colangelo & Matt Stauffer)';
    }

    public function getDeveloperUrl()
    {
        return 'http://ninetwelve.co/';
    }

    public function hasCpSection()
    {
        return true;
    }

    /**
     * Register control panel routes
     */
    public function hookRegisterCpRoutes()
    {
        return array(
            'sprog\/routes\/new' => 'sprog/routes/_edit',
            'sprog\/routes\/(?P<routeId>\d+)' => 'sprog/routes/_edit',
        );
    }
}
