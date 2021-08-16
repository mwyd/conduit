<?php

namespace App\Actions;

use App\Models\SteamMarketCsgoItem;

class CreateSteamMarketCsgoItemAction
{
    public function execute($formData)
    {
        SteamMarketCsgoItem::create($formData + [
            'is_stattrak'   => $this->isStattrak($formData['hash_name']),
            'exterior'      => $this->getItemExterior($formData['hash_name'])
        ]);
    }

    private function isStattrak($hashName)
    {
        return str_contains($hashName, 'StatTrak™');
    }

    private function getItemExterior($hashName)
    {
        $exteriors = [
            'FN' => '(Factory New)',
            'MW' => '(Minimal Wear)',
            'FT' => '(Field-Tested)',
            'WW' => '(Well-Worn)',
            'BS' => '(Battle-Scarred)',
            'Foil' => '(Foil)',
            'Holo' => '(Holo)',
            'Gold' => '(Gold)'
        ];

        foreach($exteriors as $short => $exterior)
        {
            if(str_contains($hashName, $exterior)) return $short;
        }

        return null;
    }
}