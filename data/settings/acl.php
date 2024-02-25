<?php

declare(strict_types=1);

return [
    'authorization' => [
        'roles'     => [
            'Administrator' => ['Manager'],
            'Manager'       => ['Supervisor'],
            'Supervisor'    => ['Employee'],
            'Employee'      => ['Staff'],
            'Staff'         => ['Customer'],
            'Customer'      => ['Member'],
            'Member'        => ['Guest'],
            'Guest'         => [],
        ],
        'resources' => [ // please note that resource inheritance is not supported
            \App\AdminHandler\DashBoardHandler::class,
            \PageManager\AdminHandler\CreatePageHandler::class,
            \PageManager\Handler\PageHandler::class,
            \UserManager\Handler\LoginHandler::class,
            \UserManager\Handler\LogoutHandler::class,
            'home',
        ],
        'allow'     => [
            'Administrator' => [
                \PageManager\AdminHandler\CreatePageHandler::class => [
                    'privileges' => [
                        'create', 'delete',
                    ],
                ],
            ],
            'Supervisor' => [
                \App\AdminHandler\DashBoardHandler::class => [
                    'privileges' => ['dashboard'],
                ],
            ],
            'Member' => [
                \PageManager\Handler\PageHandler::class => [
                    'privileges' => [
                        'create',
                    ],
                    'assertions' => [
                        [
                            'assert' => \Laminas\Permissions\Acl\Assertion\OwnershipAssertion::class,
                            'privileges' => [
                                'edit',
                                'delete',
                            ],
                        ],
                    ],
                ],
            ],
            'Guest'  => [
                \UserManager\Handler\LoginHandler::class => [
                    'privileges' => [
                        'view'
                    ],
                ],
            ],
        ],
        'deny'      => [
            'Member' => [
                \UserManager\Handler\LoginHandler::class => [
                    'privileges' => [
                        'view',
                    ],
                ],
            ],
            'Guest'  => [
                \UserManager\Handler\LogoutHandler::class => [
                    'privileges' => [
                        'view'
                    ],
                ],
            ],
        ],
    ],
];
