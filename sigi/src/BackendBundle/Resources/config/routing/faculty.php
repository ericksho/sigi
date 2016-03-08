<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('faculty_index', new Route(
    '/',
    array('_controller' => 'BackendBundle:Faculty:index'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('faculty_show', new Route(
    '/{id}/show',
    array('_controller' => 'BackendBundle:Faculty:show'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('faculty_new', new Route(
    '/new',
    array('_controller' => 'BackendBundle:Faculty:new'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('faculty_edit', new Route(
    '/{id}/edit',
    array('_controller' => 'BackendBundle:Faculty:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('faculty_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'BackendBundle:Faculty:delete'),
    array(),
    array(),
    '',
    array(),
    array('DELETE')
));

return $collection;
