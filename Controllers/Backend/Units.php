<?php

use Shopware\Models\Article\Unit;

class Shopware_Controllers_Backend_Units extends Shopware_Controllers_Backend_Application
{

    /** @var Category $model */
    protected $model = Unit::class;

    public function indexAction()
    {
        $this->get('front')->Plugins()->ViewRenderer()->setNoRender();
        $this->Response()->setHeader('Content-Type', 'application/json');
        $data = [];
        $units = $this->getRepository($this->model)->findAll();

        foreach ($units as $unit) {
            if($unit->getName() != '') {
                $data[] = [
                    'id' => $unit->getId(),
                    'name' => $unit->getName()
                ];
            }
        }

        $this->Response()->setContent(json_encode([
            'data' => $data,
            'total' => count($data),
        ]));
    }
}