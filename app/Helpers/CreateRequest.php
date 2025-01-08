<?php

namespace App\LaravelModuleCreate\Helpers;

class CreateRequest
{
    /**
     * @param string $projectName
     * @param string $moduleName
     * @param string $className
     * @return string
     */
    public function toRequest(string $projectName, string $moduleName, string $className): string
    {
        $namespace = "App\\" . $projectName . "\\" . $moduleName . "\\Requests";
        $modelModule = '$this->' . strtolower($moduleName);
        return <<<PHP
            <?php
            
            namespace {$namespace};
            
            use Illuminate\Foundation\Http\FormRequest;
            use Illuminate\Validation\Rule;
            
            class {$className}Request extends FormRequest
            {
                /**
                 * Determine if the user is authorized to make this request.
                 *
                 * @return bool
                 */
                public function authorize()
                {
                    return true;
                }
            
                /**
                 * Get the validation rules that apply to the request.
                 *
                 * @return array
                 */
                public function rules()
                {
                    if (!{$modelModule}) {
                        return [
                            'name' => ['required', 'string'],
                        ];
                    }
            
                    return [
                        'name' => ['required', 'string'],
                    ];
                }
            }
            PHP;
    }
}