<?php

namespace Hassen\EnvEditor\Http\Services;

use InvalidArgumentException;
use Illuminate\Support\Facades\Artisan;

class EnvEditorService
{
    protected $variables;
    protected $env;
    protected $data = [];
    protected $exposedData = [];

    public function __construct()
    {
        $env = base_path('.env');

        $this->variables = config('env-editor.exposed_variables', []);

        if (!file_exists($env)) {
            throw new \InvalidArgumentException(sprintf('%s does not exist', $env));
        }

        $this->env = $env;
        $this->setData();
    }

    public function getEnvData()
    {
        return $this->data;
    }

    public function getExposedEnvData()
    {
        $fields = [];

        foreach ($this->data as $name => $value) {
            if (array_key_exists($name, $this->variables)) {
              array_push($fields, [
                'label' => $this->variables[$name],
                'name' => $name,
                'value' => $value,
              ]);
            }
        }

        $this->exposedData = $fields;

        return $this->exposedData;
    }

    private function setData()
    {
        if (!is_readable($this->env)) {
            throw new \RuntimeException(sprintf('%s file is not readable', $this->env));
        }

        $lines = file($this->env, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {

            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            $this->data[$name] = $value;
        }
    }

    public function updateEnv(array $new_data)
    {
      Artisan::call('config:clear');

      foreach ($new_data as $key => $value) {
        $this->data[$key] = $value;
      }

      file_put_contents($this->env, $this->formatEnv());
      Artisan::call('config:cache');
      Artisan::call('config:clear');
    }

    private function formatEnv()
    {
      $lines = [];

      foreach ($this->data as $name => $value) {
        $line = "$name=$value";
        array_push($lines, $line);
      }

      return implode(PHP_EOL, $lines);
    }
}
