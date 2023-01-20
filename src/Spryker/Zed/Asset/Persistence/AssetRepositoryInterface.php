<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Asset\Persistence;

use Generated\Shared\Transfer\AssetCollectionTransfer;
use Generated\Shared\Transfer\AssetCriteriaTransfer;
use Generated\Shared\Transfer\AssetTransfer;

interface AssetRepositoryInterface
{
    /**
     * @param string $assetUuid
     *
     * @return \Generated\Shared\Transfer\AssetTransfer|null
     */
    public function findAssetByAssetUuid(string $assetUuid): ?AssetTransfer;

    /**
     * @deprecated Will be removed without replacement.
     *
     * @param int $idAsset
     *
     * @return \Generated\Shared\Transfer\AssetTransfer|null
     */
    public function findAssetById(int $idAsset): ?AssetTransfer;

    /**
     * @param \Generated\Shared\Transfer\AssetCriteriaTransfer $assetCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\AssetCollectionTransfer
     */
    public function getAssetCollection(AssetCriteriaTransfer $assetCriteriaTransfer): AssetCollectionTransfer;
}
