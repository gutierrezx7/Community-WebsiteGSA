<?php

namespace GameserverApp\Models;

use Carbon\Carbon;
use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;

class News extends Model implements LinkableInterface
{
    const EVENT = 1;
    const MAINTENANCE = 2;
    const IMPORTANT = 3;
    
    use Linkable;

    public function title($limit = false)
    {
        if($limit) {
            return str_limit($this->title, $limit);
        }

        return $this->title;
    }

    public function slug()
    {
        return $this->slug;
    }

    public function summary()
    {
        return $this->summary;
    }

    public function content()
    {
        return $this->content;
    }

    public function metaDescription()
    {
        return $this->summary;
    }

    public function hasImage()
    {
        return isset($this->image) and $this->image;
    }

    public function image()
    {
        return $this->image;
    }

    public function publishedAt()
    {
        return Carbon::parse($this->published_at);
    }

    public function hasType()
    {
        if($this->type == '0') {
            return false;
        }

        return true;
    }

    public function presentType()
    {
        switch($this->type) {
            case self::MAINTENANCE:
                return '<span class="label label-theme">Manutenção</span>';

            case self::EVENT:
                return '<span class="label label-theme">Evento</span>';

            case self::IMPORTANT:
                return '<span class="label label-theme alternative">Importante</span>';

            default:
                return;
        }
    }

    public function category()
    {
        switch($this->type) {
            case self::MAINTENANCE:
                return [translate('maintenance', 'Manutenção')];

            case self::EVENT:
                return [translate('event', 'Evento')];

            case self::IMPORTANT:
                return [translate('important', 'Importante')];

            default:
                return [];
        }
    }

    public function linkableTemplate($url, $options = [])
    {
        // TODO: Implement name() method.
    }

    public function indexRoute()
    {
        return route('news.index');
    }

    public function showRoute()
    {
        return route('news.show', ['id' => $this->id, 'slug' => $this->slug()]);
    }
}