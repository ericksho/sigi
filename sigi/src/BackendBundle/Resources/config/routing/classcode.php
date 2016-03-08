<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('classcode_index', new Route(
    '/',
    array('_controller' => 'BackendBundle:ClassCode:index'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('classcode_show', new Route(
    '/{id}/show',
    array('_controller' => 'BackendBundle:ClassCode:show'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('classcode_new', new Route(
    '/new',
    array('_controller' => 'BackendBundle:ClassCode:new'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('classcode_edit', new Route(
    '/{id}/edit',
    array('_controller' => 'BackendBundle:ClassCode:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('classcode_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'BackendBundle:ClassCode:delete'),
    array(),
    array(),
    '',
    array(),
    array('DELETE')
));

return $collection;
