<?php

namespace App\Repositories;

use App\Models\Directory;
use Kanata\Forklift\Interfaces\AssetRepositoryInterface;

class AssetRepository implements AssetRepositoryInterface
{
    /**
     * @param string $location_type Model class name.
     * @param int|null $moved_asset_id The directory of this form.
     * @param int|null $location_id The directory we are moving to.
     * @param int $page
     * @return array
     */
    public static function changeCurrentLocation(
        string $location_type,
        ?int $moved_asset_id,
        ?int $location_id,
        int $page = 1
    ): array {
        if ($location_type === Directory::class) {
            return self::changeCurrentDirectory(
                $moved_asset_id,
                $location_id,
                $page,
            );
        }

        return [];
    }

    /**
     * @param string $asset_type
     * @param int $moved_asset_id
     * @param ?int $location_id
     * @param string $parent_field
     * @return bool
     */
    public static function moveAsset(
        string $asset_type,
        int $moved_asset_id,
        ?int $location_id,
        string $parent_field = 'parent',
    ): bool {
        $asset = $asset_type::find($moved_asset_id);
        $asset->$parent_field = $location_id;
        return $asset->save();
    }

    /**
     * @param int|null $moved_asset_id
     * @param int|null $location_id
     * @param int $page
     * @return array
     */
    protected static function changeCurrentDirectory(
        ?int $moved_asset_id,
        ?int $location_id,
        int $page = 1
    ): array {
        $user = auth()->user();

        return Directory::query()
            // ->where('user_id', $user->id)
            ->where('parent', $location_id)
            // ->whereNotIn('directories.id', [$moved_asset_id]) // only because the moved assed is also a directory
            ->paginate(5, ['id', 'title'], 'page', $page)
            ->toArray();
    }
}
