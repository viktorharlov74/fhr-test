<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayerSeasonSeeder extends Seeder
{
    public function run(): void
    {
        // Города
        $chelyabinskId = DB::table('cities')->insertGetId(
            ['name_ru' => 'Челябинск', 'name_en' => 'Chelyabinsk', 'country' => 'Россия']
        );
        $magnitogorskId = DB::table('cities')->insertGetId(
            ['name_ru' => 'Магнитогорск', 'name_en' => 'Magnitogorsk', 'country' => 'Россия']
        );
        $yaroslavlId = DB::table('cities')->insertGetId(
            ['name_ru' => 'Ярославль', 'name_en' => 'Yaroslavl', 'country' => 'Россия']
        );

        // Лига
        $khlId = DB::table('leagues')->insertGetId(['name' => 'Континентальная хоккейная лига', 'code' => 'КХЛ']);

        // Клубы
        $trkId = DB::table('clubs')->insertGetId(
            [
                'name_ru' => 'Трактор',
                'name_en' => 'Traktor',
                'code' => 'trk',
                'city_id' => $chelyabinskId,
                'current_league_id' => $khlId,
                'status' => 'active'
            ]
        );
        $mmgId = DB::table('clubs')->insertGetId(
            [
                'name_ru' => 'Металлург Магнитогорск',
                'name_en' => 'Metallurg Magnitogorsk',
                'code' => 'mmg',
                'city_id' => $magnitogorskId,
                'current_league_id' => $khlId,
                'status' => 'active'
            ]
        );
        $lkmId = DB::table('clubs')->insertGetId(
            [
                'name_ru' => 'Локомотив',
                'name_en' => 'Lokomotiv',
                'code' => 'loko',
                'city_id' => $yaroslavlId,
                'current_league_id' => $khlId,
                'status' => 'active'
            ]
        );

        // Сезоны
        $season2425Id = DB::table('seasons')->insertGetId(['name' => '2024/2025', 'league_id' => $khlId]);
        $season2526Id = DB::table('seasons')->insertGetId(['name' => '2025/2026', 'league_id' => $khlId]);

        // Игроки
        $ivanovId = DB::table('players')->insertGetId(
            [
                'full_name_ru' => 'Иванов Александр Петрович',
                'full_name_en' => 'Ivanov Aleksandr Petrovich',
                'weight' => 91,
                'height' => 185
            ]
        );
        $kozlovId = DB::table('players')->insertGetId(
            [
                'full_name_ru' => 'Козлов Дмитрий Сергеевич',
                'full_name_en' => 'Kozlov Dmitriy Sergeevich',
                'weight' => 86,
                'height' => 181
            ]
        );
        $novikovId = DB::table('players')->insertGetId(
            [
                'full_name_ru' => 'Новиков Михаил Андреевич',
                'full_name_en' => 'Novikov Mikhail Andreevich',
                'weight' => 94,
                'height' => 190
            ]
        );
        $smirnovId = DB::table('players')->insertGetId(
            [
                'full_name_ru' => 'Смирнов Алексей Владимирович',
                'full_name_en' => 'Smirnov Aleksey Vladimirovich',
                'weight' => 88,
                'height' => 183
            ]
        );
        $volkovId = DB::table('players')->insertGetId(
            [
                'full_name_ru' => 'Волков Никита Игоревич',
                'full_name_en' => 'Volkov Nikita Igorevich',
                'weight' => 82,
                'height' => 178
            ]
        );
        $morozovId = DB::table('players')->insertGetId(
            [
                'full_name_ru' => 'Морозов Павел Евгеньевич',
                'full_name_en' => 'Morozov Pavel Evgenyevich',
                'weight' => 89,
                'height' => 184
            ]
        );
        $sokolovId = DB::table('players')->insertGetId(
            [
                'full_name_ru' => 'Соколов Илья Романович',
                'full_name_en' => 'Sokolov Ilya Romanovich',
                'weight' => 93,
                'height' => 188
            ]
        );
        $lebedevId = DB::table('players')->insertGetId(
            [
                'full_name_ru' => 'Лебедев Виктор Николаевич',
                'full_name_en' => 'Lebedev Viktor Nikolaevich',
                'weight' => 87,
                'height' => 182
            ]
        );
        $popovId = DB::table('players')->insertGetId(
            [
                'full_name_ru' => 'Попов Андрей Михайлович',
                'full_name_en' => 'Popov Andrey Mikhailovich',
                'weight' => 85,
                'height' => 180
            ]
        );

        // Заявки сезон 2024/2025
        DB::table('player_season')->insert([
            ['player_id' => $ivanovId, 'club_id' => $trkId, 'season_id' => $season2425Id, 'number' => 10],
            ['player_id' => $kozlovId, 'club_id' => $trkId, 'season_id' => $season2425Id, 'number' => 23],
            ['player_id' => $morozovId, 'club_id' => $trkId, 'season_id' => $season2425Id, 'number' => 77],

            ['player_id' => $novikovId, 'club_id' => $mmgId, 'season_id' => $season2425Id, 'number' => 7],
            ['player_id' => $sokolovId, 'club_id' => $mmgId, 'season_id' => $season2425Id, 'number' => 55],
            ['player_id' => $lebedevId, 'club_id' => $mmgId, 'season_id' => $season2425Id, 'number' => 18],

            ['player_id' => $smirnovId, 'club_id' => $lkmId, 'season_id' => $season2425Id, 'number' => 15],
            ['player_id' => $volkovId, 'club_id' => $lkmId, 'season_id' => $season2425Id, 'number' => 44],
            ['player_id' => $popovId, 'club_id' => $lkmId, 'season_id' => $season2425Id, 'number' => 91],
        ]);

        // Заявки сезон 2025/2026
        // Иванов перешёл в ММГ, Лебедев перешёл в Трактор, Попов перешёл в ММГ
        DB::table('player_season')->insert([
            ['player_id' => $kozlovId, 'club_id' => $trkId, 'season_id' => $season2526Id, 'number' => 23],
            ['player_id' => $morozovId, 'club_id' => $trkId, 'season_id' => $season2526Id, 'number' => 77],
            ['player_id' => $lebedevId, 'club_id' => $trkId, 'season_id' => $season2526Id, 'number' => 18],

            ['player_id' => $ivanovId, 'club_id' => $mmgId, 'season_id' => $season2526Id, 'number' => 10],
            ['player_id' => $novikovId, 'club_id' => $mmgId, 'season_id' => $season2526Id, 'number' => 7],
            ['player_id' => $popovId, 'club_id' => $mmgId, 'season_id' => $season2526Id, 'number' => 91],

            ['player_id' => $smirnovId, 'club_id' => $lkmId, 'season_id' => $season2526Id, 'number' => 15],
            ['player_id' => $volkovId, 'club_id' => $lkmId, 'season_id' => $season2526Id, 'number' => 44],
            ['player_id' => $sokolovId, 'club_id' => $lkmId, 'season_id' => $season2526Id, 'number' => 55],
        ]);
    }
}
