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

    private $typeColors = [
        'Contraband'        => '#FFAE39',
        'Covert'            => '#EB4B4B',
        'Extraordinary'     => '#EB4B4B',
        'Master'            => '#EB4B4B',
        'Classified'        => '#D32EE6',
        'Exotic'            => '#D32EE6',
        'Superior'          => '#D32EE6',
        'Restricted'        => '#8847FF',
        'Remarkable'        => '#8847FF',
        'Exceptional'       => '#8847FF',
        'Mil-Spec'          => '#4B69FF',
        'High Grade'        => '#4B69FF',
        'Distinguished'     => '#4B69FF',
        'Industrial Grade'  => '#5E98D9',
        'Consumer Grade'    => '#B0C3D9',
        'Base Grade'        => '#B0C3D9'
    ];

    public function execute($formData)
    {
        return SteamMarketCsgoItem::create($this->prepareData($formData));
    }

    private function prepareData($formData)
    {
        $data = $formData + [
            'is_stattrak'   => false,
            'exterior'      => null,
            'name'          => $formData['hash_name'],
            'type_color'    => $formData['name_color']
        ];

        if(str_contains($data['name'], $this->stattrakKeyword))
        {
            $data['name'] = str_replace($this->stattrakKeyword, '', $data['name']);
            $data['is_stattrak'] = true;
        }

        foreach($this->exteriors as $short => $exterior)
        {
            if(str_contains($data['name'], $exterior))
            {
                $data['name'] = str_replace($exterior, '', $data['name']);
                $data['exterior'] = $short;

                break;
            }
        }

        foreach($this->typeColors as $type => $color)
        {
            if(str_contains($data['type'], $type))
            {
                $data['type_color'] = $color;

                break;
            }
        }

        return $data;
    }
}