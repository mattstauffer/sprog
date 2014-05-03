<?php  namespace Craft;

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
		echo "Requested asset <b>{$this->resource_key}</b>";
		if ($this->resource_id) {
			echo " (asset #{$this->resource_id})";
		}
		echo ": action <i>{$this->resource_action}</i>";
		exit;
	}
}
