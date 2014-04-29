<?php

namespace Craft;

/**
 * Sprog controller
 */
class Sprog_RoutesController extends BaseController
{
    /**
     * Save Route
     *
     * Create or update an existing Route, based on POST data
     */
    public function actionSaveRoute()
    {
        $this->requirePostRequest();

        if ($id = craft()->request->getPost('routeId')) {
            $model = craft()->sprogRoutes->getRouteById($id);
        } else {
            $model = craft()->sprogRoutes->newRoute($id);
        }

        $attributes = craft()->request->getPost('route');
        $model->setAttributes($attributes);

        if (craft()->sprogRoutes->saveRoute($model)) {
            craft()->userSession->setNotice(Craft::t('Route saved.'));

            return $this->redirectToPostedUrl(array('routeId' => $model->getAttribute('id')));
        } else {
            craft()->userSession->setError(Craft::t("Couldn't save route."));

            craft()->urlManager->setRouteVariables(array('route' => $model));
        }
    }

    /**
     * Delete Route
     *
     * Delete an existing route
     */
    public function actionDeleteRoute()
    {
        $this->requirePostRequest();
        $this->requireAjaxRequest();

        $id = craft()->request->getRequiredPost('id');
        craft()->sprogRoutes->deleteRouteById($id);

        $this->returnJson(array('success' => true));
    }
}
