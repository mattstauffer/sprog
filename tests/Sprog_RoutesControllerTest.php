<?php

namespace Craft;

use Mockery as m;
use PHPUnit_Framework_TestCase;

class Sprog_RoutesControllerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // unfortunately we need to stub out some methods on parent class
        $this->controller = m::mock('Craft\Sprog_RoutesController[redirectToPostedUrl,renderRequestedTemplate,returnJson]');

        // inject service dependencies
        $this->sprogRoutes = m::mock('Craft\sprogRoutesService');
        $this->sprogRoutes->shouldReceive('getIsInitialized')->andReturn(true);
        craft()->setComponent('sprogRoutes', $this->sprogRoutes);

        $this->user = m::mock('Craft\UsersService');
        $this->user->shouldReceive('getIsInitialized')->andReturn(true);
        craft()->setComponent('user', $this->user);

        $this->request = m::mock('Craft\HttpRequestService');
        $this->request->shouldReceive('getIsInitialized')->andReturn(true);
        craft()->setComponent('request', $this->request);
    }

    public function testSaveRoute()
    {
        $this->request->shouldReceive('getRequestType')->once()
            ->andReturn('POST');

        $this->request->shouldReceive('getPost')->with('routeId')->once()
            ->andReturn(5);

        $mockModel = m::mock('Craft\Sprog_RouteModel');
        $this->sprogRoutes->shouldReceive('getRouteById')->with(5)->once()
            ->andReturn($mockModel);

        $attributes = array('name' => 'example');
        $this->request->shouldReceive('getPost')->with('route')->once()
            ->andReturn($attributes);
        $mockModel->shouldReceive('setAttributes')->with($attributes);

        $this->sprogRoutes->shouldReceive('saveRoute')->with($mockModel)->once()
            ->andReturn(true);
        $mockModel->shouldReceive('getAttribute')->with('id')->once()
            ->andReturn(5);

        $this->user->shouldReceive('setNotice');
        $this->controller->shouldReceive('redirectToPostedUrl');

        $this->controller->actionsaveRoute();
    }

    public function testSaveRouteNew()
    {
        $this->request->shouldReceive('getRequestType')->once()
            ->andReturn('POST');

        $this->request->shouldReceive('getPost')->with('routeId')->once()
            ->andReturn(null);

        $mockModel = m::mock('Craft\Sprog_RouteModel');
        $this->sprogRoutes->shouldReceive('newRoute')->once()
            ->andReturn($mockModel);

        $attributes = array('name' => 'example');
        $this->request->shouldReceive('getPost')->with('route')->once()
            ->andReturn($attributes);
        $mockModel->shouldReceive('setAttributes')->with($attributes);

        $this->sprogRoutes->shouldReceive('saveRoute')->with($mockModel)->once()
            ->andReturn(true);
        $mockModel->shouldReceive('getAttribute')->with('id')->once()
            ->andReturn(5);

        $this->user->shouldReceive('setNotice');
        $this->controller->shouldReceive('redirectToPostedUrl');

        $this->controller->actionSaveRoute();
    }

    public function testSaveRouteError()
    {
        $this->request->shouldReceive('getRequestType')->once()
            ->andReturn('POST');

        $this->request->shouldReceive('getPost')->with('routeId')->once()
            ->andReturn(5);

        $mockModel = m::mock('Craft\Sprog_RouteModel');
        $this->sprogRoutes->shouldReceive('getRouteById')->with(5)->once()
            ->andReturn($mockModel);

        $attributes = array('name' => 'example');
        $this->request->shouldReceive('getPost')->with('route')->once()
            ->andReturn($attributes);
        $mockModel->shouldReceive('setAttributes')->with($attributes);

        $this->sprogRoutes->shouldReceive('saveRoute')->with($mockModel)->once()
            ->andReturn(false);

        $this->user->shouldReceive('setError');
        $this->controller->shouldReceive('renderRequestedTemplate')
            ->with(array('route' => $mockModel));

        $this->controller->actionSaveRoute();
    }

    public function testDeleteRoute()
    {
        $this->request->shouldReceive('getRequestType')->once()
            ->andReturn('POST');
        $this->request->shouldReceive('isAjaxRequest')->once()
            ->andReturn(true);

        $this->request->shouldReceive('getRequiredPost')->with('id')->once()
            ->andReturn(5);
        $this->sprogRoutes->shouldReceive('deleteRouteById')->with(5)->once();

        $this->controller->shouldReceive('returnJson')->with(array('success' => true))->once();

        $this->controller->actionDeleteRoute();
    }
}
