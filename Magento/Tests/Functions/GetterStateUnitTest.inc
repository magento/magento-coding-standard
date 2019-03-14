<?php

namespace Foo\Bar;


abstract class Bar
{
    public static $foobar = 100;
}

class Foo extends Bar
{
    /**
     * @var int
     */
    private static $staticProperty;

    /**
     * @var int
     */
    private $property;

    /**
     * @return int
     */
    public function getStaticProperty()
    {
        self::$staticProperty = 12;
        static::$staticProperty -= 12;
        self::$staticProperty .= 12;
        return self::$staticProperty;
    }

    /**
     * @return int
     */
    public function getProperty()
    {
        if (true) {

        }

        $this->property = 1223;
        return $this->property;
    }

    /**
     * @return int
     */
    public function getPropertyCached()
    {
        if ($this->property === null) {
            $this->property = 1223;
        }

        return $this->property;
    }

    public function getPropertyLocal()
    {
        $local = $this->property;
        $localArray = [
            'payment' => [
                'test' => [
                    'isActive' => $this->config->isActive(),
                    'title' => $this->config->getTitle()
                ]
            ]
        ];
        return $this->property;
    }

    private function getSalesChannelForOrder($order)
    {
        $websiteId = (int)$order->getStore()->getWebsiteId();
        $websiteCode = $this->websiteRepository->getById($websiteId)->getCode();

        return $this->salesChannelFactory->create([
            'data' => [
                'type' => '',
                'code' => $websiteCode
            ]
        ]);
    }

    const MODE_AUTO = 0;

    const MODE_MANUAL = 1;

    public function getOptionsArray()
    {
        return [
            self::MODE_AUTO => __('Automatically'),
            self::MODE_MANUAL => __('Manually')
        ];
    }

    public function testigetFoo()
    {
        $this->property = 1223;
        return $this->property;
    }

    /**
     * @return int
     */
    public function normalMethod()
    {
        $localVariable = 12;
        return $localVariable;
    }

    public function getStorageModel($storage = null, $params = [])
    {
        if ($storage === null) {
            $storage = $this->_coreFileStorage->getCurrentStorageCode();
        }

        switch ($storage) {
            case self::STORAGE_MEDIA_FILE_SYSTEM:
                $model = $this->_fileFactory->create();
                break;
            default:
                return false;
        }

        if (isset($params['init']) && $params['init']) {
            $model->init();
        }

        return $model;
    }
}

$d = function ($test) {
    $test = 123;
};

