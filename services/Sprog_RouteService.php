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
		// 'edit',
		// 'delete',
		// 'create'
	);

	public function boot(HttpRequestService $request)
	{
		$this->request = $request;
		$this->segments = $request->getSegments();

		// E.g. mysite.com/api/users/1/edit

		// Drop key segment
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

		if ( ! $this->isValidRouteKey($this->resource_key)) {
			return;
		}

		// craft()->runController('Sprog_' . $this->resource_key . 'Controller')

		// $this->renderJSON(['testing' => 'yes i am']);

		echo "Requested asset <b>{$this->resource_key}</b>";
		if ($this->resource_id) {
			echo " (asset #{$this->resource_id})";
		}
		echo ": action <i>{$this->resource_action}</i>";
		exit;
	}

	protected function getElementTypes()
	{
		// @todo: Singleton/cache this result
			// const Asset       = 'Asset';
			// const Category    = 'Category';
			// const Entry       = 'Entry';
			// const GlobalSet   = 'GlobalSet';
			// const MatrixBlock = 'MatrixBlock';
			// const Tag         = 'Tag';
			// const User        = 'User';
		$refl = new ReflectionClass('ElementType');
		return $refl->getConstants();
	}

	protected function isValidRouteKey($key)
	{
		// @todo: Can we get a list internally?
		$types = array(
			'users',
			// 'globals',
			// 'singles',
			// 'tags',
		);

		// @todo: Add all sections

		return in_array($key, $types);
	}

	protected function fetchElementOrSomething()
	{
		// Every time you fetch elements, you use an ElementCriteriaModel object to set the params. There's a handy getCriteria() method for creating one of those:

		// $criteria = craft()->elements->getCriteria(ElementType::Entry);

		// That will give you the same thing craft.entries gives you on the templating side, so any params you can set on entries can also be set here.

		// $criteria->sectionId = 5;
		// $criteria->order = "title";
		// // ...

		// Then to fetch the actual elements, you would just call find() on it:

		// $entries = $criteria->find();

		// That same technique also works for fetching assets, users, tags, categories, globals, and even matrix blocks.
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
