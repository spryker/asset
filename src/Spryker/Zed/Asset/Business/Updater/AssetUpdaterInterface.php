<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Asset\Business\Updater;

use Generated\Shared\Transfer\AssetTransfer;
use Generated\Shared\Transfer\AssetUpdatedTransfer;

interface AssetUpdaterInterface
{
    /**
     * @param \Generated\Shared\Transfer\AssetUpdatedTransfer $assetUpdatedTransfer
     *
     * @return \Generated\Shared\Transfer\AssetTransfer
     */
    public function updateAsset(AssetUpdatedTransfer $assetUpdatedTransfer): AssetTransfer;
}
