<?php namespace Craft;

use CJavaScript;
use CWebLogRoute;
use Yii;

class Sprog_RouteService extends BaseApplicationComponent
{
	protected $request;
	protected $segments;
	protected $resource_key;
	protected $resource_id;
	protected $resource_action = 'list';
	protected $valid_actions = array(
		'list',
		'show',
		'edit',
		'delete',
		'create'
	);

	public function initRequest(HttpRequestService $request)
	{
		$this->request = $request;
		$this->segments = $request->getSegments();

		// Drop 'api' (or other key)
		array_shift($this->segments);

		// Set key
		$this->resource_key = reset($this->segments);

		// Set id
		if (count($this->segments > 1)) {
			$this->resource_id = next($this->segments);
			$this->resource_action = 'show';
		}

		// Set method
		if (count($this->segments > 2)) {
			$action_key = next($this->segments);
			if (in_array($action_key, $this->valid_actions)) {
				$this->resource_action = next($this->segments);
			}
		}
	}

	public function route()
	{
		if ( ! $this->resource_key) {
			// @todo: Throw 404?
			return; // Allow pass through to 404
		}

		// $this->renderJSON(['testing' => 'yes i am']);

		echo "Requested asset <b>{$this->resource_key}</b>";
		if ($this->resource_id) {
			echo " (asset #{$this->resource_id})";
		}
		echo ": action <i>{$this->resource_action}</i>";
		exit;
	}

	protected function renderJSON(array $object)
	{
		header('Content-type: application/json');
		echo CJavaScript::encode($object);

		// http://stackoverflow.com/questions/2824805/how-to-get-response-as-json-formatapplication-json-in-yii
		foreach (Yii::app()->log->routes as $route) {
			if ($route instanceof CWebLogRoute) {
				$route->enabled = false; // disable any weblogroutes
			}
		}
		
		Yii::app()->end();
	}
}
