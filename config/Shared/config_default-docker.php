<?php

use Pyz\Shared\Console\ConsoleConstants;
use Pyz\Shared\Scheduler\SchedulerConfig;
use Spryker\Client\RabbitMq\Model\RabbitMqAdapter;
use Spryker\Shared\Api\ApiConstants;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Application\Log\Config\SprykerLoggerConfig;
use Spryker\Shared\Cms\CmsConstants;
use Spryker\Shared\Collector\CollectorConstants;
use Spryker\Shared\DocumentationGeneratorRestApi\DocumentationGeneratorRestApiConstants;
use Spryker\Shared\DummyMarketplacePayment\DummyMarketplacePaymentConfig;
use Spryker\Shared\DummyPayment\DummyPaymentConfig;
use Spryker\Shared\ErrorHandler\ErrorHandlerConstants;
use Spryker\Shared\ErrorHandler\ErrorRenderer\WebExceptionErrorRenderer;
use Spryker\Shared\ErrorHandler\ErrorRenderer\WebHtmlErrorRenderer;
use Spryker\Shared\Event\EventConstants;
use Spryker\Shared\GlueApplication\GlueApplicationConstants;
use Spryker\Shared\Http\HttpConstants;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Shared\Log\LogConstants;
use Spryker\Shared\Mail\MailConstants;
use Spryker\Shared\Oauth\OauthConstants;
use Spryker\Shared\OauthCustomerConnector\OauthCustomerConnectorConstants;
use Spryker\Shared\Oms\OmsConstants;
use Spryker\Shared\Propel\PropelConstants;
use Spryker\Shared\PropelOrm\PropelOrmConstants;
use Spryker\Shared\PropelQueryBuilder\PropelQueryBuilderConstants;
use Spryker\Shared\Queue\QueueConfig;
use Spryker\Shared\Queue\QueueConstants;
use Spryker\Shared\RabbitMq\RabbitMqEnv;
use Spryker\Shared\Router\RouterConstants;
use Spryker\Shared\Sales\SalesConstants;
use Spryker\Shared\Scheduler\SchedulerConstants;
use Spryker\Shared\SchedulerJenkins\SchedulerJenkinsConfig;
use Spryker\Shared\SchedulerJenkins\SchedulerJenkinsConstants;
use Spryker\Shared\Search\SearchConstants;
use Spryker\Shared\SearchElasticsearch\SearchElasticsearchConstants;
use Spryker\Shared\Session\SessionConstants;
use Spryker\Shared\SessionRedis\SessionRedisConstants;
use Spryker\Shared\Storage\StorageConstants;
use Spryker\Shared\StorageRedis\StorageRedisConstants;
use Spryker\Shared\Testify\TestifyConstants;
use Spryker\Shared\Twig\TwigConstants;
use Spryker\Shared\WebProfiler\WebProfilerConstants;
use Spryker\Shared\ZedRequest\ZedRequestConstants;
use Spryker\Zed\Propel\PropelConfig;
use SprykerEco\Shared\Payone\PayoneConstants;
use SprykerEco\Zed\Payone\PayoneConfig;
use SprykerShop\Shared\CalculationPage\CalculationPageConstants;
use SprykerShop\Shared\ErrorPage\ErrorPageConstants;
use SprykerShop\Shared\ShopApplication\ShopApplicationConstants;
use SprykerShop\Shared\WebProfilerWidget\WebProfilerWidgetConstants;
use Twig\Cache\FilesystemCache;

/* ZED */
$config[ApplicationConstants::HOST_ZED] = getenv('SPRYKER_ZED_HOST');
$config[SessionConstants::ZED_SESSION_COOKIE_DOMAIN] = getenv('SPRYKER_BE_HOST');
$config[ApplicationConstants::ZED_TRUSTED_HOSTS]
    = $config[HttpConstants::ZED_TRUSTED_HOSTS]
    = [];
$config[ApplicationConstants::PORT_ZED] = getenv('SPRYKER_ZED_PORT') ? ':' . getenv('SPRYKER_ZED_PORT') : '';
$config[ApplicationConstants::BASE_URL_ZED] = sprintf(
    'http://%s%s',
    getenv('SPRYKER_BE_HOST'),
    getenv('SPRYKER_BE_PORT') ? ':' . getenv('SPRYKER_BE_PORT') : ''
);
$config[ApplicationConstants::BASE_URL_SSL_ZED] = sprintf(
    'https://%s%s',
    getenv('SPRYKER_BE_HOST'),
    getenv('SPRYKER_BE_PORT') ? ':' . getenv('SPRYKER_BE_PORT') : ''
);
$config[ZedRequestConstants::HOST_ZED_API] = sprintf(
    '%s:%d',
    getenv('SPRYKER_ZED_HOST'),
    getenv('SPRYKER_ZED_PORT')
);
$config[ZedRequestConstants::BASE_URL_ZED_API] = sprintf(
    'http://%s',
    $config[ZedRequestConstants::HOST_ZED_API]
);
$config[ZedRequestConstants::BASE_URL_SSL_ZED_API] = sprintf(
    'https://%s',
    $config[ZedRequestConstants::HOST_ZED_API]
);

$config[TwigConstants::ZED_TWIG_OPTIONS] = [
    'cache' => new FilesystemCache(
        sprintf(
            '%s/data/cache/codeBucket%s/ZED/twig',
            APPLICATION_ROOT_DIR,
            APPLICATION_CODE_BUCKET
        ),
        FilesystemCache::FORCE_BYTECODE_INVALIDATION
    ),
];

$config[ZedRequestConstants::TRANSFER_DEBUG_SESSION_FORWARD_ENABLED] = true;
$config[ZedRequestConstants::SET_REPEAT_DATA] = true;
$config[ZedRequestConstants::YVES_REQUEST_REPEAT_DATA_PATH] = APPLICATION_ROOT_DIR . '/data/cache/codeBucket/yves-requests';

$config[SessionConstants::ZED_SSL_ENABLED] = (bool)getenv('SPRYKER_SSL_ENABLE');

$config[ErrorHandlerConstants::DISPLAY_ERRORS] = true;
$config[ErrorHandlerConstants::ERROR_RENDERER] = getenv('SPRYKER_DEBUG_ENABLED') ? WebExceptionErrorRenderer::class : WebHtmlErrorRenderer::class;

$config[KernelConstants::DEPENDENCY_INJECTOR_ZED] = [
    'Payment' => [
        'DummyPayment',
    ],
    'Oms' => [
        'DummyPayment',
    ],
];
/* End ZED */

// ---------- Routing
$config[RouterConstants::YVES_IS_SSL_ENABLED] = (bool)getenv('SPRYKER_SSL_ENABLE');
$config[RouterConstants::ZED_IS_SSL_ENABLED] = (bool)getenv('SPRYKER_SSL_ENABLE');

/* Backend */
$config[ApplicationConstants::ENABLE_APPLICATION_DEBUG]
    = $config[ShopApplicationConstants::ENABLE_APPLICATION_DEBUG]
    = (bool)getenv('SPRYKER_DEBUG_ENABLED');

$config[WebProfilerConstants::IS_WEB_PROFILER_ENABLED]
    = $config[WebProfilerWidgetConstants::IS_WEB_PROFILER_ENABLED]
    = getenv('SPRYKER_DEBUG_ENABLED') && !getenv('SPRYKER_TESTING_ENABLED');

$config[OmsConstants::ACTIVE_PROCESSES] = [
    'DummyPayment01',
    'MarketplacePayment01',
    'PayoneCreditCardPartialOperations',
    'PayoneOnlineTransferPartialOperations',
];
$config[SalesConstants::PAYMENT_METHOD_STATEMACHINE_MAPPING] = [
    DummyPaymentConfig::PAYMENT_METHOD_INVOICE => 'DummyPayment01',
    DummyPaymentConfig::PAYMENT_METHOD_CREDIT_CARD => 'DummyPayment01',
    DummyMarketplacePaymentConfig::PAYMENT_METHOD_DUMMY_MARKETPLACE_PAYMENT_INVOICE => 'MarketplacePayment01',
    PayoneConfig::PAYMENT_METHOD_CREDIT_CARD => 'PayoneCreditCardPartialOperations',
    PayoneConfig::PAYMENT_METHOD_INSTANT_ONLINE_TRANSFER => 'PayoneOnlineTransferPartialOperations',
];

$config[EventConstants::LOGGER_ACTIVE] = true;

//Check how to generate https://oauth2.thephpleague.com/installation/
$config[OauthConstants::PRIVATE_KEY_PATH] = 'file://' . APPLICATION_ROOT_DIR . '/config/Zed/dev_only_private.key';
$config[OauthConstants::PUBLIC_KEY_PATH] = 'file://' . APPLICATION_ROOT_DIR . '/config/Zed/dev_only_public.key';
$config[OauthConstants::ENCRYPTION_KEY] = 'lxZFUEsBCJ2Yb14IF2ygAHI5N4+ZAUXXaSeeJm6+twsUmIen';

$config[OauthCustomerConnectorConstants::OAUTH_CLIENT_IDENTIFIER] = 'frontend';
$config[OauthCustomerConnectorConstants::OAUTH_CLIENT_SECRET] = 'abc123';

$config[MailConstants::MAILCATCHER_GUI] = sprintf('http://%s:1080', $config[ApplicationConstants::HOST_ZED]);
/* End Backend */

/* Yves */
$config[ApplicationConstants::HOST_YVES] = getenv('SPRYKER_FE_HOST');
$config[SessionConstants::YVES_SESSION_COOKIE_DOMAIN] = $config[ApplicationConstants::HOST_YVES];
$config[ApplicationConstants::YVES_TRUSTED_HOSTS]
    = $config[HttpConstants::YVES_TRUSTED_HOSTS]
    = [];
$config[ApplicationConstants::PORT_YVES] = getenv('SPRYKER_FE_PORT');
$config[ApplicationConstants::BASE_URL_YVES] = sprintf(
    'http://%s%s',
    $config[ApplicationConstants::HOST_YVES],
    getenv('SPRYKER_FE_PORT') ? ':' . getenv('SPRYKER_FE_PORT') : ''
);

$config[ApplicationConstants::YVES_SSL_ENABLED] = (bool)getenv('SPRYKER_SSL_ENABLE');
$config[SessionConstants::YVES_SSL_ENABLED] = (bool)getenv('SPRYKER_SSL_ENABLE');

$YVES_THEME = 'default';
$config[TwigConstants::YVES_THEME] = $YVES_THEME;
$config[CmsConstants::YVES_THEME] = $YVES_THEME;

$config[ErrorHandlerConstants::DISPLAY_ERRORS] = true;
$config[ErrorHandlerConstants::IS_PRETTY_ERROR_HANDLER_ENABLED] = (bool)getenv('SPRYKER_DEBUG_ENABLED');

// Due to some deprecation notices we silence all deprecations for the time being
// To only log e.g. deprecations instead of throwing exceptions here use
//$config[ErrorHandlerConstants::ERROR_LEVEL] = E_ALL
//$config[ErrorHandlerConstants::ERROR_LEVEL_LOG_ONLY] = E_DEPRECATED | E_USER_DEPRECATED;

$config[KernelConstants::DEPENDENCY_INJECTOR_YVES] = [
    'CheckoutPage' => [
        'DummyPayment',
    ],
];
/* End Yves */

/* Glue */
$protocol = getenv('SPRYKER_SSL_ENABLE') ? 'https' : 'http';
$glueHost = getenv('SPRYKER_API_HOST') ?: 'localhost';
$gluePort = (int)(getenv('SPRYKER_API_PORT') ?: 80);
$config[GlueApplicationConstants::GLUE_APPLICATION_DOMAIN] = sprintf(
    '%s://%s%s',
    $protocol,
    $glueHost, // TODO: refactor GlueControllerFilterPluginTest to avoid the knowledge of GLUE_APPLICATION_DOMAIN in Zed
    $gluePort !== 80 ? ':' . $gluePort : ''
);
$config[GlueApplicationConstants::GLUE_APPLICATION_REST_DEBUG] = (bool)getenv('SPRYKER_DEBUG_ENABLED');
$config[GlueApplicationConstants::GLUE_APPLICATION_CORS_ALLOW_ORIGIN] = getenv('SPRYKER_GLUE_APPLICATION_CORS_ALLOW_ORIGIN') ?: '';

$config[TestifyConstants::GLUE_APPLICATION_DOMAIN] = $config[GlueApplicationConstants::GLUE_APPLICATION_DOMAIN];
$config[TestifyConstants::GLUE_OPEN_API_SCHEMA] = APPLICATION_SOURCE_DIR . '/Generated/Glue/Specification/spryker_rest_api.schema.yml';
/* End Glue */

/* Database */
$config[PropelConstants::SCHEMA_FILE_PATH_PATTERN] = APPLICATION_VENDOR_DIR . '/*/*/src/*/Zed/*/Persistence/Propel/Schema/';
$config[PropelConstants::USE_SUDO_TO_MANAGE_DATABASE] = false;

$config[PropelOrmConstants::PROPEL_SHOW_EXTENDED_EXCEPTION] = true;
$config[PropelConstants::ZED_DB_USERNAME] = getenv('SPRYKER_DB_USERNAME');
$config[PropelConstants::ZED_DB_PASSWORD] = getenv('SPRYKER_DB_PASSWORD');
$config[PropelConstants::ZED_DB_HOST] = getenv('SPRYKER_DB_HOST');
$config[PropelConstants::ZED_DB_PORT] = getenv('SPRYKER_DB_PORT');
$config[PropelConstants::ZED_DB_ENGINE] = strtolower(getenv('SPRYKER_DB_ENGINE') ?: '') ?: PropelConfig::DB_ENGINE_PGSQL;
$config[PropelQueryBuilderConstants::ZED_DB_ENGINE] = $config[PropelConstants::ZED_DB_ENGINE];
$config[PropelConstants::ZED_DB_DATABASE] = getenv('SPRYKER_DB_DATABASE');
/* End Database */

/* Job runner */
// ---------- Scheduler
$config[SchedulerConstants::ENABLED_SCHEDULERS] = [
    SchedulerConfig::SCHEDULER_JENKINS,
];
$config[SchedulerJenkinsConstants::JENKINS_CONFIGURATION] = [
    SchedulerConfig::SCHEDULER_JENKINS => [
        SchedulerJenkinsConfig::SCHEDULER_JENKINS_BASE_URL => 'http://' . getenv('SPRYKER_SCHEDULER_HOST') . ':' . getenv('SPRYKER_SCHEDULER_PORT') . '/',
    ],
];

$config[SchedulerJenkinsConstants::JENKINS_TEMPLATE_PATH] = getenv('SPRYKER_JENKINS_TEMPLATE_PATH');
/* End Job runner */

/* Broker */
/*
 * Queues can have different adapters and maximum worker number
 * QUEUE_ADAPTER_CONFIGURATION can have the array like this as an example:
 *
 *   'mailQueue' => [
 *       QueueConfig::CONFIG_QUEUE_ADAPTER => \Spryker\Client\RabbitMq\Model\RabbitMqAdapter::class,
 *       QueueConfig::CONFIG_MAX_WORKER_NUMBER => 5
 *   ],
 *
 *
 */

$config[QueueConstants::QUEUE_ADAPTER_CONFIGURATION] = [
    EventConstants::EVENT_QUEUE => [
        QueueConfig::CONFIG_QUEUE_ADAPTER => RabbitMqAdapter::class,
        QueueConfig::CONFIG_MAX_WORKER_NUMBER => 1,
    ],
];

$config[RabbitMqEnv::RABBITMQ_API_HOST] = getenv('SPRYKER_BROKER_API_HOST');
$config[RabbitMqEnv::RABBITMQ_API_PORT] = getenv('SPRYKER_BROKER_API_PORT');
$config[RabbitMqEnv::RABBITMQ_API_USERNAME] = getenv('SPRYKER_BROKER_API_USERNAME');
$config[RabbitMqEnv::RABBITMQ_API_PASSWORD] = getenv('SPRYKER_BROKER_API_PASSWORD');
$config[RabbitMqEnv::RABBITMQ_API_VIRTUAL_HOST] = getenv('SPRYKER_BROKER_NAMESPACE');

$rabbitConnections = json_decode(getenv('SPRYKER_BROKER_CONNECTIONS') ?: '[]', true);

$config[RabbitMqEnv::RABBITMQ_CONNECTIONS] = [];

foreach ($rabbitConnections as $key => $connection) {
    $config[RabbitMqEnv::RABBITMQ_CONNECTIONS][$key] = [];
    foreach ($connection as $constant => $value) {
        $config[RabbitMqEnv::RABBITMQ_CONNECTIONS][$key][constant(RabbitMqEnv::class . '::' . $constant)] = $value;
    }

    $config[RabbitMqEnv::RABBITMQ_CONNECTIONS][$key][RabbitMqEnv::RABBITMQ_DEFAULT_CONNECTION] =
        $config[RabbitMqEnv::RABBITMQ_API_VIRTUAL_HOST] === $config[RabbitMqEnv::RABBITMQ_CONNECTIONS][$key][RabbitMqEnv::RABBITMQ_VIRTUAL_HOST];
}
/* End Broker */

/* Search service */
$config[SearchConstants::ELASTICA_PARAMETER__HOST]
    = $config[SearchElasticsearchConstants::HOST] = getenv('SPRYKER_SEARCH_HOST');
$ELASTICA_TRANSPORT_PROTOCOL = 'http';
$config[SearchConstants::ELASTICA_PARAMETER__TRANSPORT]
    = $config[SearchElasticsearchConstants::TRANSPORT] = $ELASTICA_TRANSPORT_PROTOCOL;
$config[SearchConstants::ELASTICA_PARAMETER__PORT]
    = $config[SearchElasticsearchConstants::PORT] = getenv('SPRYKER_SEARCH_PORT');
$ELASTICA_AUTH_HEADER = null;
$config[SearchConstants::ELASTICA_PARAMETER__AUTH_HEADER]
    = $config[SearchElasticsearchConstants::AUTH_HEADER] = $ELASTICA_AUTH_HEADER;
$config[CollectorConstants::ELASTICA_PARAMETER__INDEX_NAME] = getenv('SPRYKER_SEARCH_NAMESPACE');
$ELASTICA_DOCUMENT_TYPE = 'page';
$config[CollectorConstants::ELASTICA_PARAMETER__DOCUMENT_TYPE] = $ELASTICA_DOCUMENT_TYPE;
$ELASTICA_PARAMETER__EXTRA = [];
$config[SearchConstants::ELASTICA_PARAMETER__EXTRA]
    = $config[SearchElasticsearchConstants::EXTRA] = $ELASTICA_PARAMETER__EXTRA;
/* End Search service */

// ---------- KV storage
$config[StorageConstants::STORAGE_KV_SOURCE] = strtolower(getenv('SPRYKER_KEY_VALUE_STORE_ENGINE'));

/**
 * Data source names are used exclusively when set, e.g. no other Redis storage configuration will be used for the client.
 *
 * Example:
 *   $config[StorageRedisConstants::STORAGE_REDIS_DATA_SOURCE_NAMES] = ['tcp://127.0.0.1:10009', 'tcp://10.0.0.1:6379']
 */
//$config[StorageRedisConstants::STORAGE_REDIS_DATA_SOURCE_NAMES] = [];

$config[StorageRedisConstants::STORAGE_REDIS_HOST] = getenv('SPRYKER_KEY_VALUE_STORE_HOST');
$config[StorageRedisConstants::STORAGE_REDIS_PORT] = getenv('SPRYKER_KEY_VALUE_STORE_PORT');
$config[StorageRedisConstants::STORAGE_REDIS_DATABASE] = getenv('SPRYKER_KEY_VALUE_STORE_NAMESPACE');

// ---------- Session

/**
 * Data source names are used exclusively when set, e.g. no other Redis session configuration will be used for the client.
 *
 * Example:
 *   $config[SessionRedisConstants::YVES_SESSION_REDIS_DATA_SOURCE_NAMES] = ['tcp://127.0.0.1:10009', 'tcp://10.0.0.1:6379']
 */
//$config[SessionRedisConstants::YVES_SESSION_REDIS_DATA_SOURCE_NAMES] = [];

$config[SessionRedisConstants::YVES_SESSION_REDIS_PROTOCOL] = 'tcp';
$config[SessionRedisConstants::YVES_SESSION_REDIS_HOST] = getenv('SPRYKER_SESSION_FE_HOST');
$config[SessionRedisConstants::YVES_SESSION_REDIS_PORT] = getenv('SPRYKER_SESSION_FE_PORT');
$config[SessionRedisConstants::YVES_SESSION_REDIS_PASSWORD] = false;
$config[SessionRedisConstants::YVES_SESSION_REDIS_DATABASE] = getenv('SPRYKER_SESSION_FE_NAMESPACE');

/**
 * Data source names are used exclusively when set, e.g. no other Redis session configuration will be used for the client.
 *
 * Example:
 *   $config[SessionRedisConstants::ZED_SESSION_REDIS_DATA_SOURCE_NAMES] = ['tcp://127.0.0.1:10009', 'tcp://10.0.0.1:6379']
 */
//$config[SessionRedisConstants::ZED_SESSION_REDIS_DATA_SOURCE_NAMES] = [];

$config[SessionRedisConstants::ZED_SESSION_REDIS_PROTOCOL] = 'tcp';
$config[SessionRedisConstants::ZED_SESSION_REDIS_HOST] = getenv('SPRYKER_SESSION_BE_HOST');
$config[SessionRedisConstants::ZED_SESSION_REDIS_PORT] = getenv('SPRYKER_SESSION_BE_PORT');
$config[SessionRedisConstants::ZED_SESSION_REDIS_PASSWORD] = false;
$config[SessionRedisConstants::ZED_SESSION_REDIS_DATABASE] = getenv('SPRYKER_SESSION_BE_NAMESPACE');

/* Mail */
$config[MailConstants::SMTP_HOST] = getenv('SPRYKER_SMTP_HOST');
$config[MailConstants::SMTP_PORT] = getenv('SPRYKER_SMTP_PORT');
/* End Mail */

/* Logging */
$config[LogConstants::LOGGER_CONFIG] = SprykerLoggerConfig::class;
$config[LogConstants::LOG_FILE_PATH] = (getenv('SPRYKER_LOG_DIRECTORY') ?: APPLICATION_ROOT_DIR . '/data') . '/logs';

$logDir = (getenv('SPRYKER_LOG_DIRECTORY') ?: APPLICATION_ROOT_DIR . '/data') . '/' . APPLICATION_STORE;

$config[QueueConstants::QUEUE_WORKER_OUTPUT_FILE_NAME] = $logDir . '/ZED/queue.log';
$config[PropelConstants::LOG_FILE_PATH] = $logDir . '/ZED/propel.log';

$config[LogConstants::LOG_FILE_PATH_YVES] = $logDir . '/YVES/application.log';
$config[LogConstants::LOG_FILE_PATH_ZED] = $logDir . '/ZED/application.log';
$config[LogConstants::LOG_FILE_PATH_GLUE] = $logDir . '/GLUE/application.log';

$config[LogConstants::EXCEPTION_LOG_FILE_PATH_YVES] = $logDir . '/YVES/exception.log';
$config[LogConstants::EXCEPTION_LOG_FILE_PATH_ZED] = $logDir . '/ZED/exception.log';
$config[LogConstants::EXCEPTION_LOG_FILE_PATH_GLUE] = $logDir . '/GLUE/exception.log';
/* End Logging */

// ----------- Api
$config[ApiConstants::ENABLE_API_DEBUG] = (bool)getenv('SPRYKER_DEBUG_ENABLED');

// ----------- Kernel test
$config[KernelConstants::ENABLE_CONTAINER_OVERRIDING] = (bool)getenv('SPRYKER_TESTING_ENABLED');

// ----------- Calculation page
$config[CalculationPageConstants::ENABLE_CART_DEBUG] = (bool)getenv('SPRYKER_DEBUG_ENABLED');

// ----------- Error page
$config[ErrorPageConstants::ENABLE_ERROR_404_STACK_TRACE] = (bool)getenv('SPRYKER_DEBUG_ENABLED');

// ----------- Console
$config[ConsoleConstants::ENABLE_DEVELOPMENT_CONSOLE_COMMANDS] = (bool)getenv('DEVELOPMENT_CONSOLE_COMMANDS');

// ----------- Documentation generator
$config[DocumentationGeneratorRestApiConstants::ENABLE_REST_API_DOCUMENTATION_GENERATION] = true;

// ----------- Payone
$config[PayoneConstants::PAYONE] = [
    PayoneConstants::PAYONE_CREDENTIALS_ENCODING => 'UTF-8',
    PayoneConstants::PAYONE_CREDENTIALS_KEY => 'Atf7vFdpMvhqlQwJ',
    PayoneConstants::PAYONE_CREDENTIALS_MID => '32481',
    PayoneConstants::PAYONE_CREDENTIALS_AID => '32893',
    PayoneConstants::PAYONE_CREDENTIALS_PORTAL_ID => '2026219',
    PayoneConstants::PAYONE_PAYMENT_GATEWAY_URL => 'https://api.pay1.de/post-gateway/',
    PayoneConstants::HOST_YVES => $config[ApplicationConstants::BASE_URL_YVES],
    PayoneConstants::PAYONE_MODE => PayoneConstants::PAYONE_MODE_TEST,
    PayoneConstants::PAYONE_EMPTY_SEQUENCE_NUMBER => 0,
    PayoneConstants::PAYONE_REDIRECT_SUCCESS_URL => sprintf(
        '%s/payone/payment-success',
        $config[ApplicationConstants::BASE_URL_YVES]
    ),
    PayoneConstants::PAYONE_REDIRECT_ERROR_URL => sprintf(
        '%s/payone/payment-failure',
        $config[ApplicationConstants::BASE_URL_YVES]
    ),
    PayoneConstants::PAYONE_REDIRECT_BACK_URL => sprintf(
        '%s/payone/regular-redirect-payment-cancellation',
        $config[ApplicationConstants::BASE_URL_YVES]
    ),
];
