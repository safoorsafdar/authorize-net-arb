<?php
namespace SafoorSafdar\AuthorizeNetARB;


use SafoorSafdar\AuthorizeNetARB\Bridge\AuthorizeNetARB;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;

class AuthorizeNetARBGatewayFactory extends GatewayFactory
{
    /**
     * {@inheritDoc}
     */
    protected function populateConfig(ArrayObject $config)
    {
        if (!class_exists(\AuthorizeNetARB::class)) {
            throw new \LogicException('You must install "authorizenet/authorizenet" library.');
        }

        $config->defaults(array(
            'payum.factory_name' => 'authorize_net_aim',
            'payum.factory_title' => 'Authorize.NET AIM',
        ));

        if (false == $config['payum.api']) {
            $config['payum.default_options'] = array(
                'login_id' => '',
                'transaction_key' => '',
                'sandbox' => true,
            );
            $config->defaults($config['payum.default_options']);
            $config['payum.required_options'] = array('login_id', 'transaction_key');

            $config['payum.api'] = function (ArrayObject $config) {
                $config->validateNotEmpty($config['payum.required_options']);

                $api = new AuthorizeNetARB($config['login_id'], $config['transaction_key']);
                $api->setSandbox($config['sandbox']);

                return $api;
            };
        }
    }
}
