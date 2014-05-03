<?php namespace Craft;

class SprogPlugin extends BasePlugin
{
	protected $route_key = 'api';

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
    public function registerCpRoutes()
    {
        return array(
            'sprog\/routes\/new' => 'sprog/routes/_edit',
            'sprog\/routes\/(?P<routeId>\d+)' => 'sprog/routes/_edit',
        );
    }

	protected function defineSettings()
	{
		return array(
			'testSettingsDude' => array(
				AttributeType::Mixed,
				'default' => 'All the things'
			),
		);
	}

	public function getSettingsHtml()
	{
		return craft()->templates->render('sprog/_settings', array(
			'settings' => $this->getSettings()
		));
	}

	public function prepSettings($settings)
	{
		// Modify $settings here...

		return $settings;
	}

	public function init()
	{
		if (craft()->request->getSegment(1) == $this->route_key) {
			craft()->sprog_route->initRequest(craft()->request);
			craft()->sprog_route->route();
		}
	}

}
