<?php

namespace GameserverApp\Transformers;

use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Models\Message;
use GameserverApp\Models\News;
use GameserverApp\Models\SupportTier;
use GameserverApp\Models\Token;
use GameserverApp\Models\User;

class SupportTierTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new SupportTier($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'id'               => $args->id,
            'name'             => $args->name,
            'description'      => $args->description,
            'total_price'      => $args->total_price,
            'currency'         => $args->currency,
            'gateway'          => $args->gateway,
            'type'             => $args->type,
            'image'            => $args->image,
            'requires_discord' => $args->requires_discord,
            'cluster'          => $args->cluster,
            'order_url'        => $args->order_url
        ];

        return $data;
    }
}