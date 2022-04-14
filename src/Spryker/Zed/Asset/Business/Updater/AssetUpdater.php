<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Asset\Business\Updater;

use Generated\Shared\Transfer\AssetTransfer;
use Generated\Shared\Transfer\AssetUpdatedTransfer;
use Spryker\Zed\Asset\Business\Exception\InvalidAssetException;
use Spryker\Zed\Asset\Dependency\Facade\AssetToStoreReferenceInterface;
use Spryker\Zed\Asset\Persistence\AssetEntityManagerInterface;
use Spryker\Zed\Asset\Persistence\AssetRepositoryInterface;

class AssetUpdater implements AssetUpdaterInterface
{
    /**
     * @var \Spryker\Zed\Asset\Persistence\AssetRepositoryInterface
     */
    protected $assetRepository;

    /**
     * @var \Spryker\Zed\Asset\Persistence\AssetEntityManagerInterface
     */
    protected $assetEntityManager;

    /**
     * @var \Spryker\Zed\Asset\Dependency\Facade\AssetToStoreReferenceInterface
     */
    private $storeReferenceFacade;

    /**
     * @param \Spryker\Zed\Asset\Persistence\AssetRepositoryInterface $assetRepository
     * @param \Spryker\Zed\Asset\Persistence\AssetEntityManagerInterface $assetEntityManager
     * @param \Spryker\Zed\Asset\Dependency\Facade\AssetToStoreReferenceInterface $storeReferenceFacade
     */
    public function __construct(
        AssetRepositoryInterface $assetRepository,
        AssetEntityManagerInterface $assetEntityManager,
        AssetToStoreReferenceInterface $storeReferenceFacade
    ) {
        $this->assetRepository = $assetRepository;
        $this->assetEntityManager = $assetEntityManager;
        $this->storeReferenceFacade = $storeReferenceFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\AssetUpdatedTransfer $assetUpdatedTransfer
     *
     * @throws \Spryker\Zed\Asset\Business\Exception\InvalidAssetException
     *
     * @return \Generated\Shared\Transfer\AssetTransfer
     */
    public function updateAsset(AssetUpdatedTransfer $assetUpdatedTransfer): AssetTransfer
    {
        $messageAttributes = $assetUpdatedTransfer->getMessageAttributesOrFail();

        $assetUpdatedTransfer
            ->requireAssetView()
            ->requireAssetIdentifier()
            ->requireAssetSlot();

        $storeTransfer = $this->storeReferenceFacade->getStoreByStoreReference($messageAttributes->getStoreReferenceOrFail());
        $assetTransfer = $this->assetRepository
            ->findAssetByAssetUuid((string)$assetUpdatedTransfer->getAssetIdentifier());

        if ($assetTransfer === null) {
            throw new InvalidAssetException('This asset doesn\'t exist in DB.');
        }

        $assetTransfer
            ->setAssetContent($assetUpdatedTransfer->getAssetView())
            ->setAssetSlot($assetUpdatedTransfer->getAssetSlot());

        return $this->assetEntityManager->saveAssetWithStores($assetTransfer, [$storeTransfer]);
    }
}
