<?php

namespace App\Handler;

use App\Dto\CreateSetting;
use App\Entity\Settings;
use Doctrine\ORM\EntityManagerInterface;

final class CreateSettingHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function handle(CreateSetting $input): Settings
    {
        $setting = new Settings();
        $setting->setMediamtxApiUrl($input->mediamtxApiUrl);
        $setting->setHlsBaseUrl($input->hlsBaseUrl);
        $setting->setRequireDeviceAuth($input->requireDeviceAuth);
        $setting->setAllowUnknownDevices($input->allowUnknownDevices);
        $setting->setAutoRegisterUnknownDevices($input->autoRegisterUnknownDevices);
        $setting->setAutoAuthorizeNewDevices($input->autoAuthorizeNewDevices);
        $setting->setExposeOnlyAuthorizedPaths($input->exposeOnlyAuthorizedPaths);
        $setting->setMaxDevices($input->maxDevices);
        $setting->setMaxConnectedDevices($input->maxConnectedDevices);
        $setting->setDeviceOfflineAfterMs($input->deviceOfflineAfterMs);
        $setting->setPollIntervalMs($input->pollIntervalMs);
        $setting->setEnablePublish($input->enablePublish);
        $setting->setEnableRead($input->enableRead);

        if ($input->createdAt instanceof \DateTimeImmutable) {
            $setting->setCreatedAt($input->createdAt);
        }

        if ($input->updatedAt instanceof \DateTimeImmutable) {
            $setting->setUpdatedAt($input->updatedAt);
        }

        $this->entityManager->persist($setting);
        $this->entityManager->flush();

        return $setting;
    }
}