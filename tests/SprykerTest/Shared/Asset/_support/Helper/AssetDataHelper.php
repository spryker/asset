<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Shared\Asset\Helper;

use Codeception\Module;
use Generated\Shared\DataBuilder\AssetBuilder;
use Generated\Shared\Transfer\AssetTransfer;
use Orm\Zed\Asset\Persistence\SpyAsset;
use Orm\Zed\Asset\Persistence\SpyAssetQuery;
use Orm\Zed\Asset\Persistence\SpyAssetStoreQuery;
use SprykerTest\Shared\Testify\Helper\DataCleanupHelperTrait;
use SprykerTest\Shared\Testify\Helper\LocatorHelperTrait;

class AssetDataHelper extends Module
{
    use DataCleanupHelperTrait;
    use LocatorHelperTrait;

    /**
     * @param array $seed
     *
     * @return \Generated\Shared\Transfer\AssetTransfer
     */
    public function haveAssetTransfer(array $seed = []): AssetTransfer
    {
        return (new AssetBuilder($seed))->build();
    }

    /**
     * @param array $seed
     *
     * @return \Generated\Shared\Transfer\AssetTransfer
     */
    public function haveAsset(array $seed = []): AssetTransfer
    {
        $assetTransfer = $this->haveAssetTransfer($seed);

        $assetEntity = SpyAssetQuery::create()
            ->filterByAssetUuid($assetTransfer->getAssetUuid())
            ->findOneOrCreate();

        if ($assetEntity->isNew()) {
            $assetEntity = (new SpyAsset())
                ->setAssetSlot($assetTransfer->getAssetSlot())
                ->setAssetContent($assetTransfer->getAssetContent())
                ->setAssetUuid($assetTransfer->getAssetUuid())
                ->setAssetName($assetTransfer->getAssetName());

            $assetEntity->save();
        }

        $this->getDataCleanupHelper()->_addCleanup(function () use ($assetEntity): void {
            $assetEntity->delete();
        });

        $assetTransfer = (new AssetTransfer())->fromArray($assetEntity->toArray(), true);
        $assetTransfer->setAssetSlot($assetEntity->getAssetSlot());

        return $assetTransfer;
    }

    /**
     * @param int $idAsset
     * @param int $idStore
     *
     * @return void
     */
    public function haveAssetStoreRelation(int $idAsset, int $idStore): void
    {
        $assetStoreEntity = SpyAssetStoreQuery::create()
            ->filterByFkAsset($idAsset)
            ->filterByFkStore($idStore)
            ->findOneOrCreate();

        if ($assetStoreEntity->isNew()) {
            $assetStoreEntity->save();
        }

        $this->getDataCleanupHelper()->_addCleanup(function () use ($assetStoreEntity): void {
            $assetStoreEntity->delete();
        });
    }
}
