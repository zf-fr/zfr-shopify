<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace ZfrShopify;

use Generator;
use GuzzleHttp\Client;
use GuzzleHttp\Command\CommandInterface;
use GuzzleHttp\Command\Exception\CommandException;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Command\Guzzle\Serializer;
use GuzzleHttp\Command\Result;
use GuzzleHttp\Command\ToArrayInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ZfrShopify\Exception\RuntimeException;

/**
 * Shopify client used to interact with the Shopify API
 *
 * It also offers several utility, to allow generate URLs needed for the OAuth dance, as well
 * as validating incoming request and webhooks
 *
 * @author Michaël Gallego
 *
 * ACCESS SCOPES METHODS:
 *
 * @method array getAccessScopes(array $args = []) {@command Shopify GetAccessScopes}
 *
 * APPLICATION CHARGE RELATED METHODS:
 *
 * @method array getApplicationCharges(array $args = []) {@command Shopify GetApplicationCharges}
 * @method array getApplicationCharge(array $args = []) {@command Shopify GetApplicationCharge}
 * @method array createApplicationCharge(array $args = []) {@command Shopify CreateApplicationCharge}
 * @method array activateApplicationCharge(array $args = []) {@command Shopify ActivateApplicationCharge}
 *
 * ARTICLE RELATED METHODS:
 *
 * @method array getArticles(array $args = []) {@command Shopify GetArticles}
 * @method int getArticleCount(array $args = []) {@command Shopify GetArticleCount}
 * @method array getBlogArticles(array $args = []) {@command Shopify GetBlogArticles}
 * @method int getBlogArticleCount(array $args = []) {@command Shopify GetBlogArticleCount}
 * @method array getArticle(array $args = []) {@command Shopify GetArticle}
 * @method array getArticleMetafields(array $args = []) {@command Shopify GetArticleMetafields}
 * @method array getBlogArticle(array $args = []) {@command Shopify GetBlogArticle}
 * @method array getArticlesAuthors(array $args = []) {@command Shopify GetArticlesAuthors}
 * @method array getArticlesTags(array $args = []) {@command Shopify GetArticlesTags}
 * @method array createArticle(array $args = []) {@command Shopify CreateArticle}
 * @method array createBlogArticle(array $args = []) {@command Shopify CreateBlogArticle}
 * @method array updateArticle(array $args = []) {@command Shopify UpdateArticle}
 * @method array updateBlogArticle(array $args = []) {@command Shopify UpdateBlogArticle}
 * @method array deleteArticle(array $args = []) {@command Shopify DeleteArticle}
 * @method array deleteBlogArticle(array $args = []) {@command Shopify DeleteBlogArticle}
 *
 * ASSET RELATED METHODS:
 *
 * @method array getAssets(array $args = []) {@command Shopify GetAssets}
 * @method array getAsset(array $args = []) {@command Shopify GetAsset}
 * @method array createAsset(array $args = []) {@command Shopify CreateAsset}
 * @method array updateAsset(array $args = []) {@command Shopify UpdateAsset}
 * @method array deleteAsset(array $args = []) {@command Shopify DeleteAsset}
 *
 * CUSTOM COLLECTION RELATED METHODS:
 *
 * @method array getCustomCollections(array $args = []) {@command Shopify GetCustomCollections}
 * @method int getCustomCollectionCount(array $args = []) {@command Shopify GetCustomCollectionCount}
 * @method array getCustomCollection(array $args = []) {@command Shopify GetCustomCollection}
 * @method array createCustomCollection(array $args = []) {@command Shopify CreateCustomCollection}
 * @method array updateCustomCollection(array $args = []) {@command Shopify UpdateCustomCollection}
 * @method array deleteCustomCollection(array $args = []) {@command Shopify DeleteCustomCollection}
 *
 * CUSTOMER RELATED METHODS:
 *
 * @method array getCustomers(array $args = []) {@command Shopify GetCustomers}
 * @method int getCustomerCount(array $args = []) {@command Shopify GetCustomerCount}
 * @method array searchCustomers(array $args = []) {@command Shopify SearchCustomers}
 * @method array getCustomer(array $args = []) {@command Shopify GetCustomer}
 * @method array getCustomerMetafields(array $args = []) {@command Shopify GetCustomerMetafields}
 * @method array createCustomer(array $args = []) {@command Shopify CreateCustomer}
 * @method array updateCustomer(array $args = []) {@command Shopify UpdateCustomer}
 * @method array deleteCustomer(array $args = []) {@command Shopify DeleteCustomer}
 *
 * DISCOUNT CODE RELATED METHODS:
 *
 * @method array getDiscountCodes(array $args = []) {@command Shopify GetDiscountCodes}
 * @method int getDiscountCode(array $args = []) {@command Shopify GetDiscountCode}
 * @method array createDiscountCode(array $args = []) {@command Shopify CreateDiscountCode}
 * @method array deleteDiscountCode(array $args = []) {@command Shopify DeleteDiscountCode}
 *
 * EVENTS RELATED METHODS:
 *
 * @method array getEvents(array $args = []) {@command Shopify GetEvents}
 * @method int getEventCount(array $args = []) {@command Shopify GetEventCount}
 * @method array getEvent(array $args = []) {@command Shopify GetEvent}
 *
 * FULFILLMENTS RELATED METHODS:
 *
 * @method array getFulfillments(array $args = []) {@command Shopify GetFulfillments}
 * @method int getFulfillmentCount(array $args = []) {@command Shopify GetFulfillmentCount}
 * @method array getFulfillment(array $args = []) {@command Shopify GetFulfillment}
 * @method array createFulfillment(array $args = []) {@command Shopify CreateFulfillment}
 * @method array updateFilfillment(array $args = []) {@command Shopify UpdateFulfillment}
 * @method array completeFulfillment(array $args = []) {@command Shopify CompleteFulfillment}
 * @method array cancelFulfillment(array $args = []) {@command Shopify CancelFulfillment}
 *
 * GIFT CARD RELATED METHODS:
 *
 * @method array getGiftCards(array $args = []) {@command Shopify GetGiftCards}
 * @method int getGiftCardCount(array $args = []) {@command Shopify GetGiftCardCount}
 * @method array getGiftCard(array $args = []) {@command Shopify GetGiftCard}
 * @method array createGiftCard(array $args = []) {@command Shopify CreateGiftCard}
 * @method array updateGiftCard(array $args = []) {@command Shopify CreateGiftCard}
 * @method array disableGiftCard(array $args = []) {@command Shopify DisableGiftCard}
 *
 * INVENTORY ITEM RELATED METHODS:
 *
 * @method array getInventoryItems(array $args = []) {@command Shopify GetInventoryItems}
 * @method array getInventoryItem(array $args = []) {@command Shopify GetInventoryItem}
 * @method array updateInventoryItem(array $args = []) {@command Shopify UpdateInventoryItem}
 *
 * INVENTORY LEVEL RELATED METHODS
 *
 * @method array getInventoryLevels(array $args = []) {@command Shopify GetInventoryLevels}
 * @method array adjustInventoryLevel(array $args = []) {@command Shopify AdjustInventoryLevel}
 * @method array deleteInventoryLevel(array $args = []) {@command Shopify DeleteInventoryLevel}
 * @method array connectInventoryLevel(array $args = []) {@command Shopify ConnectInventoryLevel}
 * @method array setInventoryLevel(array $args = []) {@command Shopify SetInventoryLevel}
 *
 * LOCATION RELATED METHODS:
 *
 * @method array getLocations(array $args = []) {@command Shopify GetLocations}
 * @method array getLocation(array $args = []) {@command Shopify GetLocation}
 * @method int getLocationCount(array $args = []) {@command Shopify GetLocationCount}
 * @method array getLocationInventoryLevels(array $args = []) {@command Shopify GetLocationInventoryLevels}
 *
 * METAFIELDS RELATED METHODS:
 * 
 * @method array getMetafields(array $args = []) {@command Shopify GetMetafields}
 * @method array getMetafield(array $args = []) {@command Shopify GetMetafield}
 * @method array createMetafield(array $args = []) {@command Shopify CreateMetafield}
 * @method array updateMetafield(array $args = []) {@command Shopify UpdateMetafield}
 * @method array deleteMetafield(array $args = []) {@command Shopify DeleteMetafield}
 * 
 * ORDER RELATED METHODS:
 *
 * @method array getOrders(array $args = []) {@command Shopify GetOrders}
 * @method int getOrderCount(array $args = []) {@command Shopify GetOrderCount}
 * @method array createOrder(array $args = []) {@command Shopify CreateOrder}
 * @method array updateOrder(array $args = []) {@command Shopify UpdateOrder}
 * @method array getOrder(array $args = []) {@command Shopify GetOrder}
 * @method array getOrderMetafields(array $args = []) {@command Shopify GetOrderMetafields}
 * @method array closeOrder(array $args = []) {@command Shopify CloseOrder}
 * @method array openOrder(array $args = []) {@command Shopify OpenOrder}
 * @method array cancelOrder(array $args = []) {@command Shopify CancelOrder}
 *
 * PAGE RELATED METHODS:
 *
 * @method array getPages(array $args = []) {@command Shopify GetPages}
 * @method int getPageCount(array $args = []) {@command Shopify GetPageCount}
 * @method array getPage(array $args = []) {@command Shopify GetPage}
 * @method array getPageMetafields(array $args = []) {@command Shopify GetPageMetafields}
 * @method array createPage(array $args = []) {@command Shopify CreatePage}
 * @method array updatePage(array $args = []) {@command Shopify UpdatePage}
 * @method array deletePage(array $args = []) {@command Shopify DeletePage}
 *
 * PRICE RULE RELATED METHODS:
 *
 * @method array getPriceRules(array $args = []) {@command Shopify GetPriceRules}
 * @method int getPriceRule(array $args = []) {@command Shopify GetPriceRule}
 * @method array createPriceRule(array $args = []) {@command Shopify CreatePriceRule}
 * @method array updatePriceRule(array $args = []) {@command Shopify UpdatePriceRule}
 * @method array deletePriceRule(array $args = []) {@command Shopify DeletePriceRule}
 *
 * PRODUCT RELATED METHODS:
 *
 * @method array getProducts(array $args = []) {@command Shopify GetProducts}
 * @method int getProductCount(array $args = []) {@command Shopify GetProductCount}
 * @method array getProduct(array $args = []) {@command Shopify GetProduct}
 * @method array getProductMetafields(array $args = []) {@command Shopify GetProductMetafields}
 * @method array createProduct(array $args = []) {@command Shopify CreateProduct}
 * @method array updateProduct(array $args = []) {@command Shopify UpdateProduct}
 * @method array deleteProduct(array $args = []) {@command Shopify DeleteProduct}
 *
 * PRODUCT IMAGE RELATED METHODS:
 *
 * @method array getProductImages(array $args = []) {@command Shopify GetProductImages}
 * @method int getProductImageCount(array $args = []) {@command Shopify GetProductImageCount}
 * @method array getProductImage(array $args = []) {@command Shopify GetProductImage}
 * @method array createProductImage(array $args = []) {@command Shopify CreateProductImage}
 * @method array updateProductImage(array $args = []) {@command Shopify UpdateProductImage}
 * @method array deleteProductImage(array $args = []) {@command Shopify DeleteProductImage}
 *
 * REDIRECT RELATED METHODS:
 *
 * @method array getRedirects(array $args = []) {@command Shopify GetRedirects}
 * @method int getRedirectCount(array $args = []) {@command Shopify GetRedirectCount}
 * @method array getRedirect(array $args = []) {@command Shopify GetRedirect}
 * @method array createRedirect(array $args = []) {@command Shopify CreateRedirect}
 * @method array updateRedirect(array $args = []) {@command Shopify UpdateRedirect}
 * @method array deleteRedirect(array $args = []) {@command Shopify DeleteRedirect}
 *
 * RECURRING APPLICATION CHARGE RELATED METHODS:
 *
 * @method array getRecurringApplicationCharges(array $args = []) {@command Shopify GetRecurringApplicationCharges}
 * @method array getRecurringApplicationCharge(array $args = []) {@command Shopify GetRecurringApplicationCharge}
 * @method array createRecurringApplicationCharge(array $args = []) {@command Shopify CreateRecurringApplicationCharge}
 * @method array activateRecurringApplicationCharge(array $args = []) {@command Shopify ActivateRecurringApplicationCharge}
 * @method array deleteRecurringApplicationCharge(array $args = []) {@command Shopify DeleteRecurringApplicationCharge}
 *
 * REFUND RELATED METHODS:
 *
 * @method array getRefunds(array $args = []) {@command Shopify GetRefunds}
 * @method array getRefund(array $args = []) {@command Shopify GetRefund}
 * @method array calculateRefund(array $args = []) {@command Shopify CalculateRefund}
 * @method array createRefund(array $args = []) {@command Shopify CreateRefund}
 *
 * SHOP RELATED METHODS:
 *
 * @method array getShop(array $args = []) {@command Shopify GetShop}
 * 
 * SMART COLLECTION RELATED METHODS:
 *
 * @method array getSmartCollections(array $args = []) {@command Shopify GetSmartCollections}
 * @method int getSmartCollectionCount(array $args = []) {@command Shopify GetSmartCollectionCount}
 * @method array getSmartCollection(array $args = []) {@command Shopify GetSmartCollection}
 * @method array createSmartCollection(array $args = []) {@command Shopify CreateSmartCollection}
 * @method array updateSmartCollection(array $args = []) {@command Shopify UpdateSmartCollection}
 * @method array deleteSmartCollection(array $args = []) {@command Shopify DeleteSmartCollection}
 *
 * THEME RELATED METHODS:
 *
 * @method array getThemes(array $args = []) {@command Shopify GetThemes}
 * @method array getTheme(array $args = []) {@command Shopify GetTheme}
 * @method array createTheme(array $args = []) {@command Shopify CreateTheme}
 * @method array updateTheme(array $args = []) {@command Shopify UpdateTheme}
 * @method array deleteTheme(array $args = []) {@command Shopify DeleteTheme}
 *
 * VARIANT RELATED METHODS:
 *
 * @method array getProductVariants(array $args = []) {@command Shopify GetProductVariants}
 * @method int getProductVariantCount(array $args = []) {@command Shopify GetProductVariantCount}
 * @method array getProductVariant(array $args = []) {@command Shopify GetProductVariant}
 * @method array getProductVariantMetafields(array $args = []) {@command Shopify GetProductVariantMetafields}
 * @method array createProductVariant(array $args = []) {@command Shopify CreateProductVariant}
 * @method array updateProductVariant(array $args = []) {@command Shopify UpdateProductVariant}
 * @method array deleteProductVariant(array $args = []) {@command Shopify DeleteProductVariant}
 *
 * SCRIPT TAGS RELATED METHODS:
 *
 * @method array getScriptTags(array $args = []) {@command Shopify GetScriptTags}
 * @method int getScriptTagCount(array $args = []) {@command Shopify GetScriptTagCount}
 * @method array getScriptTag(array $args = []) {@command Shopify GetScriptTag}
 * @method array createScriptTag(array $args = []) {@command Shopify CreateScriptTag}
 * @method array updateScriptTag(array $args = []) {@command Shopify UpdateScriptTag}
 * @method array deleteScriptTag(array $args = []) {@command Shopify DeleteScriptTag}
 *
 * TRANSACTION RELATED METHODS:
 *
 * @method array getTransactions(array $args = []) {@command Shopify GetTransactions}
 * @method int getTransactionCount(array $args = []) {@command Shopify GetTransactionCount}
 * @method array getTransaction(array $args = []) {@command Shopify GetTransaction}
 * @method array createTransaction(array $args = []) {@command Shopify CreateTransaction}
 *
 * USAGE CHARGE RELATED METHODS:
 *
 * @method array getUsageCharges(array $args = []) {@command Shopify GetUsageCharges}
 * @method array getUsageCharge(array $args = []) {@command Shopify GetUsageCharge}
 * @method array createUsageCharge(array $args = []) {@command Shopify CreateUsageCharge}
 * 
 * WEBHOOK RELATED METHODS:
 *
 * @method array getWebhooks(array $args = []) {@command Shopify GetWebhooks}
 * @method int getWebhookCount(array $args = []) {@command Shopify GetWebhookCount}
 * @method array getWebhook(array $args = []) {@command Shopify GetWebhook}
 * @method array createWebhook(array $args = []) {@command Shopify CreateWebhook}
 * @method array updateWebhook(array $args = []) {@command Shopify UpdateWebhook}
 * @method array deleteWebhook(array $args = []) {@command Shopify DeleteWebhook}
 * 
 * OTHER METHODS:
 * 
 * @method array createDelegateAccessToken(array $args = []) {@command Shopify CreateDelegateAccessToken}
 *
 * ITERATOR METHODS:
 *
 * @method \Traversable getApplicationChargesIterator(array $commandArgs = [], array $iteratorArgs = []) {@command Shopify GetApplicationCharges}
 * @method \Traversable getArticlesIterator(array $commandArgs = [], array $iteratorArgs = []) {@command Shopify GetArticles}
 * @method \Traversable getBlogArticlesIterator(array $commandArgs = [], array $iteratorArgs = []) {@command Shopify GetBlogArticles}
 * @method \Traversable getCustomCollectionsIterator(array $commandArgs = [], array $iteratorArgs = []) {@command Shopify GetCustomCollections}
 * @method \Traversable getCustomersIterator(array $commandArgs = [], array $iteratorArgs = []) {@command Shopify GetCustomersIterator}
 * @method \Traversable getDiscountCodesIterator(array $commandArgs = [], array $iteratorArgs = []) {@command Shopify GetDiscountCodes}
 * @method \Traversable getEventsIterator(array $commandArgs = [], array $iteratorArgs = []) {@command Shopify GetEvents}
 * @method \Traversable getFulfillmentsIterator(array $commandArgs = [], array $iteratorArgs = []) {@command Shopify GetFulfillments}
 * @method \Traversable getGiftCardsIterator(array $commandArgs = [], array $iteratorArgs = []) {@command Shopify GetGiftCards}
 * @method \Traversable getMetafieldsIterator(array $commandArgs = [], array $iteratorArgs = []) {@command Shopify GetMetafields}
 * @method \Traversable getOrdersIterator(array $commandArgs = [], array $iteratorArgs = []) {@command Shopify GetOrders}
 * @method \Traversable getPagesIterator(array $commandArgs = [], array $iteratorArgs = []) {@command Shopify GetPages}
 * @method \Traversable getPriceRulesIterator(array $commandArgs = [], array $iteratorArgs = []) {@command Shopify GetPriceRules}
 * @method \Traversable getProductsIterator(array $commandArgs = [], array $iteratorArgs = []) {@command Shopify GetProducts}
 * @method \Traversable getProductImagesIterator(array $commandArgs = [], array $iteratorArgs = []) {@command Shopify GetProductImages}
 * @method \Traversable getRecurringApplicationChargesIterator(array $commandArgs = [], array $iteratorArgs = []) {@command Shopify GetRecurringApplicationCharges}
 * @method \Traversable getSmartCollectionsIterator(array $commandArgs = [], array $iteratorArgs = []) {@command Shopify GetSmartCollections}
 * @method \Traversable getProductVariantsIterator(array $commandArgs = [], array $iteratorArgs = []) {@command Shopify GetProductVariants}
 * @method \Traversable getWebhooksIterator(array $commandArgs = [], array $iteratorArgs = []) {@command Shopify GetWebhooks}
 */
class ShopifyClient
{
    /**
     * @var GuzzleClient
     */
    private $guzzleClient;

    /**
     * @var array
     */
    private $connectionOptions;

    /**
     * @param array             $connectionOptions
     * @param GuzzleClient|null $guzzleClient
     */
    public function __construct(array $connectionOptions, GuzzleClient $guzzleClient = null)
    {
        $this->validateConnectionOptions($connectionOptions);
        $this->connectionOptions = $connectionOptions;

        $this->guzzleClient = $guzzleClient ?? $this->createDefaultClient();
    }

    /**
     * Manually create a command (without executing it)
     *
     * This can be used to execute multiple commands in parallel by taking advantage of Guzzle multi-requests. Please
     * note that creating a command will not execute it. You will need to use the "execute" method of the Shopify client
     * to execute it and get the result
     *
     * @param  string $method
     * @param  array  $args
     * @return CommandInterface
     */
    public function getCommand(string $method, $args = []): CommandInterface
    {
        // Add authentication parameters to each command based on the Shopify app type

        if ($this->connectionOptions['private_app']) {
            $args = array_merge($args, [
                '@http' => [
                    'auth' => [$this->connectionOptions['api_key'], $this->connectionOptions['password']]
                ]
            ]);
        } else {
            $args = array_merge($args, [
                '@http' => [
                    'headers' => [
                        'X-Shopify-Access-Token' => $this->connectionOptions['access_token']
                    ]
                ]
            ]);
        }

        return $this->guzzleClient->getCommand(ucfirst($method), $args);
    }

    /**
     * Execute a single command
     *
     * @param  CommandInterface $command
     * @return mixed
     */
    public function execute(CommandInterface $command)
    {
        $result = $this->guzzleClient->execute($command);

        return $this->unwrapResponseData($command, $result);
    }

    /**
     * Execute multiple commands
     *
     * @param  array $commands
     * @return array
     */
    public function executeAll(array $commands = []): array
    {
        $commandResults = $this->guzzleClient->executeAll($commands);
        $results        = [];

        // Normally, results are expected to be returned in the same order as initial commands, so we can post-process them

        /** @var Result $commandResult */
        foreach ($commandResults as $index => $commandResult) {
            // If the command has failed, we store the exception, otherwise the payload
            $results[$index] = ($commandResult instanceof CommandException) ? $commandResult : $this->unwrapResponseData($commands[$index], $commandResult);
        }

        return $results;
    }

    /**
     * Directly call a specific endpoint by creating the command and executing it
     *
     * Using __call magic methods is equivalent to creating and executing a single command. It also supports using optimized
     * iterator requests by adding "Iterator" keyword to the command
     *
     * @param  $method
     * @param  array $args
     * @return array|Generator
     */
    public function __call($method, $args)
    {
        $args = $args[0] ?? [];

        // Allow magic method calls for iterators (e.g. $client-><CommandName>Iterator($params))
        if (substr($method, -8) === 'Iterator') {
            return $this->iterateResources(substr($method, 0, -8), $args);
        }

        $command = $this->getCommand($method, $args);

        return $this->execute($command);
    }

    /**
     * Wrap request data around a top-key (only for POST and PUT requests)
     *
     * @internal
     * @param  CommandInterface $command
     * @return RequestInterface
     */
    public function wrapRequestData(CommandInterface $command): RequestInterface
    {
        $operation = $this->guzzleClient->getDescription()->getOperation($command->getName());
        $method    = strtolower($operation->getHttpMethod());
        $rootKey   = $operation->getData('root_key');

        $serializer = new Serializer($this->guzzleClient->getDescription()); // Create a default serializer to handle all the hard-work
        $request    = $serializer($command);

        if (($method === 'post' || $method === 'put') && $rootKey !== null) {
            $newBody = [$rootKey => json_decode($request->getBody()->getContents(), true)];
            $request = $request->withBody(Psr7\stream_for(json_encode($newBody)));
        }

        return $request;
    }

    /**
     * Decide when we should retry a request
     *
     * @internal
     * @param  int                    $retries
     * @param  RequestInterface       $request
     * @param  ResponseInterface|null $response
     * @param  RequestException|null  $exception
     * @return bool
     */
    public function retryDecider(int $retries, RequestInterface $request, ResponseInterface $response = null, RequestException $exception = null): bool
    {
        // Limit the number of retries to 5
        if ($retries >= 5) {
            return false;
        }

        // Retry connection exceptions
        if ($exception instanceof ConnectException) {
            return true;
        }

        // Retry 5XX
        if ($exception instanceof ServerException) {
            return true;
        }

        // Otherwise, retry when we're having a 429 exception
        if ((! is_null($response)) && ($response->getStatusCode() === 429)) {
            return true;
        }

        return false;
    }

    /**
     * Basic retry delay
     *
     * @internal
     * @param  int $retries
     * @return int
     */
    public function retryDelay(int $retries): int
    {
        return 1000 * $retries;
    }

    /**
     * Validate all the connection parameters
     *
     * @param array $connectionOptions
     */
    private function validateConnectionOptions(array $connectionOptions)
    {
        if (!isset($connectionOptions['shop'], $connectionOptions['api_key'], $connectionOptions['private_app'])) {
            throw new RuntimeException('"shop", "private_app" and/or "api_key" must be provided when instantiating the Shopify client');
        }

        if ($connectionOptions['private_app'] && !isset($connectionOptions['password'])) {
            throw new RuntimeException('You must specify the "password" option when instantiating the Shopify client for a private app');
        }

        if (!$connectionOptions['private_app'] && !isset($connectionOptions['access_token'])) {
            throw new RuntimeException('You must specify the "access_token" option when instantiating the Shopify client for a public app');
        }
    }

    /**
     * @return GuzzleClient
     */
    private function createDefaultClient(): GuzzleClient
    {
        $baseUri = 'https://' . str_replace('.myshopify.com', '', $this->connectionOptions['shop']) . '.myshopify.com';

        $handlerStack = HandlerStack::create(new CurlHandler());
        $handlerStack->push(Middleware::retry([$this, 'retryDecider'], [$this, 'retryDelay']));

        $httpClient  = new Client(['base_uri' => $baseUri, 'handler' => $handlerStack]);
        $description = new Description(require __DIR__ . '/ServiceDescription/Shopify-v1.php');

        return new GuzzleClient($httpClient, $description, [$this, 'wrapRequestData']);
    }

    /**
     * @param  string $commandName
     * @param  array  $args
     * @return Generator
     */
    private function iterateResources(string $commandName, array $args): Generator
    {
        // When using the iterator, we force the maximum number of items per page. Also, if no "since_id" is set, we force it to 0 because by
        // default Shopify sort resources by title
        $args['limit'] = 250;

        if ($commandName === 'getGiftCards') {
            $args['page'] = $args['page'] ?? 1;
        } else {
            $args['since_id'] = $args['since_id'] ?? 0;
        }

        // Because the iteration depends on the presence of the "id" field, we must make sure that if the "fields" filter is set, it contains
        // at the minimum the "id" one. We make a simple detection here
        if (isset($args['fields'])) {
            $fields         = explode(',', str_replace(' ', '', $args['fields']));
            $args['fields'] = implode(',', array_unique(array_merge(['id'], $fields)));
        }

        do {
            $command = $this->getCommand($commandName, $args);
            $results = $this->execute($command);

            foreach ($results as $result) {
                yield $result;
            }

            // Unfortunately as of today gift card endpoint does not support "since_id" parameter, so we are forced to use the page
            // instead of this endpoint
            if ($commandName === 'getGiftCards') {
                $args['page']++;
            } else {
                // Advance the since_id
                $args['since_id'] = end($results)['id'];
            }
        } while(count($results) >= 250);
    }

    /**
     * In Shopify, all API responses wrap the data by the resource name. For instance, using the "/shop" endpoint will wrap
     * the data by the "shop" key. This is a bit inconvenient to use in userland. As a consequence, we always "unwrap" the result.
     *
     * @param  CommandInterface $command
     * @param  ToArrayInterface $commandResult
     * @return mixed
     */
    private function unwrapResponseData(CommandInterface $command, ToArrayInterface $commandResult)
    {
        $operation = $this->guzzleClient->getDescription()->getOperation($command->getName());
        $rootKey   = $operation->getData('root_key');

        $result = (null === $rootKey) ? $commandResult->toArray() : $commandResult->toArray()[$rootKey];

        if (substr($command->getName(), -5) === 'Count') {
            return $result['count'];
        }

        return $result;
    }
}
