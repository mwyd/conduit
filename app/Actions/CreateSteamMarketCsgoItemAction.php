<?php

namespace App\Actions;

use App\Models\SteamMarketCsgoItem;

class CreateSteamMarketCsgoItemAction
{
    private $stattrakKeyword = 'StatTrak™ ';

    private $exteriors = [
        'FN'    => ' (Factory New)',
        'MW'    => ' (Minimal Wear)',
        'FT'    => ' (Field-Tested)',
        'WW'    => ' (Well-Worn)',
        'BS'    => ' (Battle-Scarred)',
        'Foil'  => ' (Foil)',
        'Holo'  => ' (Holo)',
        'Gold'  => ' (Gold)',
        'Blue'  => ' (Blue)',
        'Red'   => ' (Red)'
    ];

    public function execute($formData)
    {
        SteamMarketCsgoItem::create($formData + $this->unpackHashName($formData['hash_name']));
    }

    private function unpackHashName($hashName)
    {
        $data = [
            'is_stattrak'   => false,
            'exterior'      => null,
            'name'          => ''
        ];

        if(str_contains($hashName, $this->stattrakKeyword))
        {
            $hashName = str_replace($this->stattrakKeyword, '', $hashName);
            $data['is_stattrak'] = true;
        }

        foreach($this->exteriors as $short => $exterior)
        {
            if(str_contains($hashName, $exterior))
            {
                $hashName = str_replace($exterior, '', $hashName);
                $data['exterior'] = $short;

                break;
            }
        }

        $data['name'] = $hashName;

        return $data;
    }
}