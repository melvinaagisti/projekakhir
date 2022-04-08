<?php

namespace App\Main;

use Auth;


class SideMenu
{
    /**
     * List of side menu items.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function menu()
    {

        
        return [
            
            'Data Master' => [
                'icon' => 'box',
                'title' => 'Data Master',
                'sub_menu' => [
                    'Modul Barang' => [
                        'icon' => 'user-plus',
                        'route_name' => 'barang',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Modul Pegawai'
                    ],
                    
                ],
            ],
            
            'devider',
            'users' => [
                'icon' => 'users',
                'route_name' => 'user',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'Users'
            ],
            'Setting' => [
                'icon' => 'trello',
                'title' => 'Setting Perusahaan',
                'route_name' => 'setting-perusahaan',
                'params' => [
                    'layout' => 'side-menu'
                ],
            ],
                
            
        ];
    }
}
