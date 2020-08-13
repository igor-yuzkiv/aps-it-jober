<?php

namespace App\Repository;

use Waavi\Translation\Models\Language as Model;

/**
 * Class TranslationLanguagesReposiotry
 * @package App\Repository
 */
class TranslationLanguagesReposiotry extends CoreRepository
{
    /**
     * @return mixed|string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * @return mixed
     */
    public function getForSelect()
    {
        return $this->_GetForSelect("locale", "name");
    }
}
