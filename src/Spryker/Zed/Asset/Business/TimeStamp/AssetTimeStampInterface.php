<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Asset\Business\TimeStamp;

use Generated\Shared\Transfer\AssetTransfer;
use Generated\Shared\Transfer\MessageAttributesTransfer;

interface AssetTimeStampInterface
{
    public function shouldTransferMessageBeProcessed(AssetTransfer $assetTransfer, MessageAttributesTransfer $messageAttributesTransfer): bool;

    public function updateMessageAttributesTimestampIfRequired(MessageAttributesTransfer $messageAttributesTransfer): MessageAttributesTransfer;
}
