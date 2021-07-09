<?php

namespace GameserverApp\Transformers;

use GameserverApp\Interfaces\ModelTransformerInterface;
use GameserverApp\Models\Message;
use GameserverApp\Models\News;
use GameserverApp\Models\Shop;
use GameserverApp\Models\Token;
use GameserverApp\Models\Transaction;
use GameserverApp\Models\User;

class ShopTransformer extends ModelTransformer implements ModelTransformerInterface
{

    public static function model(array $args)
    {
        return new Shop($args);
    }

    public static function transformableInput($args)
    {
        $data = [
            'id'          => $args->id,
            'name'        => $args->name,
            'description' => $args->description,
            'type'        => $args->type,
            'cluster'     => $args->cluster,
            'image'       => $args->image
        ];

        if(isset($args->limit)) {
            $data['limit'] = $args->limit;
        }

        if(isset($args->limit_days)) {
            $data['limit_days'] = $args->limit_days;
        }

        if(isset($args->usage)) {
            $data['usage'] = $args->usage;
        }

        if(isset($args->token_price)) {
            $data['token_price'] = $args->token_price;
        }

        if(isset($args->requires_character)) {
            $data['requires_character'] = $args->requires_character;
        }

        if (isset($args->characters) and $args->characters) {
            $data['characters'] = CharacterTransformer::transformMultiple($args->characters);
        } else {
            $data['characters'] = false;
        }

        return $data;
    }
}