<?php

namespace GameserverApp\Models;

use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;
use Illuminate\Support\Str;

class SupportTier extends Model implements LinkableInterface
{
    use Linkable;

    public function name()
    {
        return $this->name;
    }

    public function description()
    {
        return $this->description;
    }

    public function summary()
    {
        return Str::limit(strip_tags($this->description()));
    }

    public function hasLabel()
    {
        return $this->label();
    }

    public function label()
    {
        if($discount = $this->discount()) {
            return $discount . '% desconto';
        }

        if($this->cluster()) {
            return $this->cluster() . ' somente';
        }

        return false;
    }

    public function totalPrice()
    {
        return $this->total_price;
    }

    public function discountedPrice()
    {
        return $this->discounted_price;
    }

    public function discount()
    {
        return $this->discount;
    }

    public function displayTotalPrice()
    {
        $suffix = '';

        if($this->isSubscription()) {
            $suffix = ' p/mo';
        }

        if($this->discount()) {
            return '<span class="discounted_price">
                        <span class="from_price">From: <span>' . $this->displayCurrency() . ' ' . $this->totalPrice() . $suffix . '</span></span><br>
                        <span class="to_price">To: <span>' . $this->displayCurrency() . ' ' . $this->discountedPrice() . $suffix . '</span></span>
                    </span>';
        }

        return $this->displayCurrency() . ' ' . $this->totalPrice() . $suffix;
    }

    public function requiresDiscordSetup()
    {
        return $this->requires_discord;
    }

    public function isSubscription()
    {
        return $this->type() == 'subscription';
    }

    public function currency()
    {
        return $this->currency;
    }

    public function type()
    {
        return $this->type;
    }

    public function cluster()
    {
        return $this->cluster;
    }

    public function gateway()
    {
        return $this->gateway;
    }

    public function isPayPal()
    {
        return $this->gateway() == 'PayPal';
    }

    public function isStripe()
    {
        return $this->gateway() == 'Stripe';
    }

    public function displayCurrency()
    {
        switch($this->currency()) {
            case 'EUR':
                return '€';

            case 'GBP':
                return '£';

            case 'BRL':
                return 'R$';

            case 'AUD':
                return 'A$';

            case 'CAD':
                return 'C$';

            case 'PLN':
                return 'zł';

            default:
                return '$';
        }
    }

    public function image()
    {
        return $this->image;
    }

    public function orderUrl()
    {
        return $this->order_url;
    }

    public function linkableTemplate($url, $options = [])
    {
        // TODO: Implement name() method.
    }

    public function indexRoute()
    {
        // TODO: Implement indexRoute() method.
    }

    public function showRoute()
    {
        // TODO: Implement showRoute() method.
    }
}