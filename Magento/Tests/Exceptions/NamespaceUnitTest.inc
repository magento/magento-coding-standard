<?php
namespace Foo\Bar;

class TestNamespace
{
    public function go()
    {
        try {
            throw new Exception('test');
        } catch (Exception $e) {
            return false;
        }
    }

    public function test()
    {
        try {
            throw new \Exception('test');
        } catch (\Exception $e) {
            return false;
        }
    }

    public function execute()
    {
        $ch = curl_init();
        $this->setAuth($ch);
        try {
            switch (strtoupper($this->verb)) {
                case 'GET':
                    $this->executeGet($ch);
                    break;
                case 'POST':
                    $this->executePost($ch);
                    break;
                case 'PUT':
                    $this->executePut($ch);
                    break;
                case 'DELETE':
                    $this->executeDelete($ch);
                    break;
                default:
                    throw new \InvalidArgumentException(
                        'Current verb (' . $this->verb
                        . ') is an invalid REST verb.'
                    );
            }
        } catch (InvalidArgumentException $e) {
            curl_close($ch);
            throw $e;
        } catch (\Exception $e) {
            curl_close($ch);
            throw $e;
        }
    }
}
