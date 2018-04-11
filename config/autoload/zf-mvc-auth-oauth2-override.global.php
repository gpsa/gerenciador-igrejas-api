<?php
/**
 * This file was autogenerated by zfcampus/zf-mvc-auth (bin/zf-mvc-auth-oauth2-override.php),
 * and overrides the ZF\OAuth2\Service\OAuth2Server to provide the ability to create named
 * OAuth2\Server instances.
 */
return [
    'service_manager' => [
        'factories' => [
            \ZF\OAuth2\Service\OAuth2Server::class => \ZF\MvcAuth\Factory\NamedOAuth2ServerFactory::class,
        ],
    ],
    'zf-mvc-auth' => array(
        'authentication' => array(
            'adapters' => array(
                'oauth2_doctrine' => array(
                    'adapter' => 'ZF\\MvcAuth\\Authentication\\OAuth2Adapter',
                    'storage' => array(
                        'storage' => 'oauth2.doctrineadapter.default',
                        'route' => '/oauth',
                    ),
                ),
            ),
        ),
    ),
];
