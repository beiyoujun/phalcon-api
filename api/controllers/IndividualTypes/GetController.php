<?php

declare(strict_types=1);

namespace Niden\Api\Controllers\IndividualTypes;

use Niden\Api\Controllers\BaseController;
use Niden\Constants\Relationships;
use Niden\Models\IndividualTypes;
use Niden\Transformers\IndividualTypesTransformer;

/**
 * Class GetController
 *
 * @package Niden\Api\Controllers\IndividualTypes
 */
class GetController extends BaseController
{
    /** @var string */
    protected $model       = IndividualTypes::class;

    /** @var array */
    protected $relationships = [
        Relationships::INDIVIDUALS,
    ];

    /** @var string */
    protected $resource    = Relationships::INDIVIDUAL_TYPES;

    /** @var string */
    protected $transformer = IndividualTypesTransformer::class;
}

