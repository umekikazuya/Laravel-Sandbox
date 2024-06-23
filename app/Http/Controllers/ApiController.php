<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends Controller
{
    /**
     * Ajax通信のみ許可する.
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function onlyAjax(Request $request)
    {
        // Initialized.
        $res = new JsonResponse();

        if ($request->ajax()) {
            return $res->setJson(json_encode(['message' => 'Please Ajax!!']));
        }
        $products = [
            ['id' => 1, 'name' => 'Product 1', 'price' => 100],
            ['id' => 2, 'name' => 'Product 2', 'price' => 150],
        ];
        return $res->setJson(json_encode($products));
    }

    /**
     * Ajax通信以外を許可する.
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function excludeAjax(Request $request)
    {
        // Initialized.
        $res = new JsonResponse();

        if ($request->ajax()) {
            return $res->setJson(json_encode(['message' => 'No Ajax!!']));
        }

        $products = [
            ['id' => 1, 'name' => 'Product 1', 'price' => 100],
            ['id' => 2, 'name' => 'Product 2', 'price' => 150],
        ];
        return $res->setJson(json_encode($products));
    }

}
