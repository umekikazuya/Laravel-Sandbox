<?php

namespace App\Models;

class Profile extends DynamoDbModel
{
    protected static $tableName = 'profiles';

    /**
     * 固定キーを生成
     */
    public static function getKey(): array
    {
        return ['PK' => ['S' => 'PROFILE#1']];
    }

    /**
     * シングルトン的にプロフィールを取得または作成
     */
    public static function findOrCreate(): array
    {
        $item = self::find(self::getKey());

        if (! $item) {
            $item = [
                'PK' => ['S' => 'PROFILE#1'],
                'Name' => ['S' => 'Default Name'],
                'Title' => ['S' => 'Default Title'],
                'Bio' => ['S' => 'Default Bio'],
                'Avatar' => ['S' => 'https://example.com/default-avatar.jpg'],
                'UpdatedAt' => ['S' => now()->toIso8601String()],
            ];
            self::save($item);
        }

        return $item;
    }
}
