<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Asset\Business\Mapper;

use Generated\Shared\Transfer\AssetAddedTransfer;
use Generated\Shared\Transfer\AssetDeletedTransfer;
use Generated\Shared\Transfer\AssetTransfer;

interface AssetMapperInterface
{
    public function mapAssetAddedTransferToAssetTransfer(
        AssetAddedTransfer $assetAddedTransfer,
        AssetTransfer $assetTransfer
    ): AssetTransfer;

    public function generateAssetTransferFromAssetDeletedTransfer(AssetDeletedTransfer $assetDeletedTransfer): AssetTransfer;
}
