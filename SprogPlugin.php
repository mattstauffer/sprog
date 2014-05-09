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
			'api_route_key' => array(
				AttributeType::Mixed,
				'default' => 'api'
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
		if ($this->shouldCaptureRequest(craft()->request)) {
			craft()->sprog_route->boot(craft()->request);
			craft()->sprog_route->route();
		}
	}

	protected function shouldCaptureRequest(HttpRequestService $request)
	{
		return $this->getSettings()->api_route_key == $request->getSegment(1);
	}
}
