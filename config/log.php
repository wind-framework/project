<?php

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\NoopHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Level;
use Wind\Log\StdoutHandler;

$defaultFormatter = [
	'class' => LineFormatter::class,
	'args' => [
		'format' => str_replace(' %extra%', '', LineFormatter::SIMPLE_FORMAT),
		'dateFormat' => 'Y-m-d H:i:s v',
		'allowInlineLineBreaks' => true
	]
];

$stdoutHandler = \Workerman\Worker::$daemonize ? [
	'class' => NoopHandler::class
] : [
	'class' => StdoutHandler::class,
	'args' => [
		'level' => Level::Debug
	],
	'formatter' => $defaultFormatter
];

return [
    'default' => [
        'handlers' => [
            [
                'class' => RotatingFileHandler::class,
                'args' => [
                    'filename' => RUNTIME_DIR.'/log/app.log',
                    'maxFiles' => 15,
                    'level' => Level::Info
                ]
            ],
            [
                'class' => StdoutHandler::class,
                'args' => [
                    'level' => Level::Info
                ],
                //为 handler 设置独立的 formatter
                'formatter' => [
                    'class' => LineFormatter::class,
                    'args' => [
                        'dateFormat' => 'Y-m-d H:i:s',
                        'allowInlineLineBreaks' => true
                    ]
                ]
            ]
        ],
        //整个组默认的 formatter
        'formatter' => $defaultFormatter
    ]
];
