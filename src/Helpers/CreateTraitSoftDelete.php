<?php

namespace Wagner\LaravelModuleCreate\Helpers;

class CreateTraitSoftDelete
{
    private $trashed = '$this->trashed()';

    public function toTraitSoftDelete(string $projectName): string
    {
        $namespace = "App\\" . $projectName . "\\Common\Traits";
        return <<<PHP
            <?php
            
            namespace {$namespace};
            
            use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;
            
            trait SoftDeletes
            {
                use EloquentSoftDeletes;

                /**
                 * @return bool
                 */
                public function isEnabled()
                {
                    return {$this->trashed};
                }                
            }
            PHP;
    }
}