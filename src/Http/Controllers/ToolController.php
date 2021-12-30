<?php

namespace Hassen\EnvEditor\Http\Controllers;

use Illuminate\Routing\Controller;
use Hassen\EnvEditor\Http\Services\EnvEditorService;

class ToolController extends Controller
{
    /**
     * @var mixed
     */
    protected $service;

    /**
     * @param EnvEditorService $enveditorService
     */
    public function __construct(EnvEditorService $enveditorService)
    {
        $this->service = $enveditorService;
    }

    public function index()
    {
        $fields = [];

        foreach ($this->service->getExposedEnvData() as $variable) {
            array_push($fields,
            [
              "component" => "text-field",
              "prefixComponent" => true,
              "indexName" => $variable['name'],
              "name" => $variable['label'],
              "attribute" => $variable['name'],
              "value" => $variable['value'],
              "panel" => null,
              "sortable" => false,
              "textAlign" => "left",
          ],);
        }

        return response()->json($fields);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $new_data = request()->input();
        try {
          $this->service->updateEnv($new_data);
          return response()->json(__("Your env file has been updated!"));
        } catch (\Throwable $th) {
          return response()->json("Un problème est survenu!", 500);
        }

    }
}
