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

use Guzzle\Common\Event;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Symfony\Component\EventDispatcher\EventDispatcher;
use ZfrShopify\Exception;

/**
 * Shopify client used to interact with the Shopify API
 *
 * It also offers several utility, to allow generate URLs needed for the OAuth dance, as well
 * as validating incoming request and webhooks
 *
 * @author Michaël Gallego
 *
 * ARTICLE RELATED METHODS:
 *
 * @method array getArticles(array $args = []) {@command Shopify GetArticles}
 * @method array getBlogArticles(array $args = []) {@command Shopify GetBlogArticles}
 * @method array getArticle(array $args = []) {@command Shopify GetArticle}
 * @method array getBlogArticle(array $args = []) {@command Shopify GetBlogArticle}
 * @method array getArticlesAuthors(array $args = []) {@command Shopify GetArticlesAuthors}
 * @method array getArticlesTags(array $args = []) {@command Shopify GetArticlesTags}
 * @method array createArticle(array $args = []) {@command Shopify CreateArticle}
 * @method array updateArticle(array $args = []) {@command Shopify UpdateArticle}
 * @method array deleteArticle(array $args = []) {@command Shopify DeleteArticle}
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
 * @method array getCustomCollection(array $args = []) {@command Shopify GetCustomCollection}
 * @method array createCustomCollection(array $args = []) {@command Shopify CreateCustomCollection}
 * @method array updateCustomCollection(array $args = []) {@command Shopify UpdateCustomCollection}
 * @method array deleteCustomCollection(array $args = []) {@command Shopify DeleteCustomCollection}
 *
 * EVENTS RELATED METHODS:
 *
 * @method array getEvents(array $args = []) {@command Shopify GetEvents}
 * @method array getEvent(array $args = []) {@command Shopify GetEvent}
 *
 * FULFILLMENTS RELATED METHODS:
 *
 * @method array getFulfillments(array $args = []) {@command Shopify GetFulfillments}
 * @method array getFulfillment(array $args = []) {@command Shopify GetFulfillment}
 * @method array createFulfillment(array $args = []) {@command Shopify CreateFulfillment}
 * @method array updateFilfillment(array $args = []) {@command Shopify UpdateFulfillment}
 * @method array completeFulfillment(array $args = []) {@command Shopify CompleteFulfillment}
 * @method array cancelFulfillment(array $args = []) {@command Shopify CancelFulfillment}
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
 * @method array getOrder(array $args = []) {@command Shopify GetOrder}
 * @method array closeOrder(array $args = []) {@command Shopify CloseOrder}
 * @method array openOrder(array $args = []) {@command Shopify OpenOrder}
 * @method array cancelOrder(array $args = []) {@command Shopify CancelOrder}
 *
 * PAGE RELATED METHODS:
 *
 * @method array getPages(array $args = []) {@command Shopify GetPages}
 * @method array getPage(array $args = []) {@command Shopify GetPage}
 * @method array createPage(array $args = []) {@command Shopify CreatePage}
 * @method array updatePage(array $args = []) {@command Shopify UpdatePage}
 * @method array deletePage(array $args = []) {@command Shopify DeletePage}
 *
 * PRODUCT RELATED METHODS:
 *
 * @method array getProducts(array $args = []) {@command Shopify GetProducts}
 * @method array getProduct(array $args = []) {@command Shopify GetProduct}
 * @method array createProduct(array $args = []) {@command Shopify CreateProduct}
 * @method array updateProduct(array $args = []) {@command Shopify UpdateProduct}
 * @method array deleteProduct(array $args = []) {@command Shopify DeleteProduct}
 *
 * PRODUCT IMAGE RELATED METHODS:
 *
 * @method array getProductImages(array $args = []) {@command Shopify GetProductImages}
 * @method array getProductImage(array $args = []) {@command Shopify GetProductImage}
 * @method array createProductImage(array $args = []) {@command Shopify CreateProductImage}
 * @method array updateProductImage(array $args = []) {@command Shopify UpdateProductImage}
 * @method array deleteProductImage(array $args = []) {@command Shopify DeleteProductImage}
 *
 * RECURRING APPLICATION CHARGE RELATED METHODS:
 *
 * @method array getRecurringApplicationCharges(array $args = []) {@command Shopify GetRecurringApplicationCharges}
 * @method array getRecurringApplicationCharge(array $args = []) {@command Shopify GetRecurringApplicationCharge}
 * @method array createRecurringApplicationCharge(array $args = []) {@command Shopify CreateRecurringApplicationCharge}
 * @method array activateRecurringApplicationCharge(array $args = []) {@command Shopify ActivateRecurringApplicationCharge}
 * @method array deleteRecurringApplicationCharge(array $args = []) {@command Shopify DeleteRecurringApplicationCharge}
 *
 * SHOP RELATED METHODS:
 *
 * @method array getShop(array $args = []) {@command Shopify GetShop}
 *
 * THEME RELATED METHODS:
 *
 * @method array getThemes(array $args = []) {@command Shopify GetThemes}
 * @method array getTheme(array $args = []) {@command Shopify GetTheme}
 * @method array createTheme(array $args = []) {@command Shopify CreateTheme}
 * @method array updateTheme(array $args = []) {@command Shopify UpdateTheme}
 * @method array deleteTheme(array $args = []) {@command Shopify DeleteTheme}
 *
 * WEBHOOK RELATED METHODS:
 *
 * @method array getWebhooks(array $args = []) {@command Shopify GetWebhooks}
 * @method array getWebhook(array $args = []) {@command Shopify GetWebhook}
 * @method array createWebhook(array $args = []) {@command Shopify CreateWebhook}
 * @method array updateWebhook(array $args = []) {@command Shopify UpdateWebhook}
 * @method array deleteWebhook(array $args = []) {@command Shopify DeleteWebhook}
 */
class ShopifyClient extends Client
{
    /**
     * @var array
     */
    private $options;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        parent::__construct();

        $this->options = $options;

        $this->setUserAgent('zfr-shopify-php', true);
        $this->setDescription(ServiceDescription::factory(__DIR__ . '/ServiceDescription/Shopify-v1.php'));

        // Add an event to set the Authorization param
        $dispatcher = $this->getEventDispatcher();
        $dispatcher->addListener('client.command.create', [$this, 'prepareShopBaseUrl']);
        $dispatcher->addListener('command.after_prepare', [$this, 'wrapRequestData']);
        $dispatcher->addListener('command.before_send', [$this, 'authorizeRequest']);
    }

    /**
     * Do a deep clone
     */
    public function __clone()
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->addListener('client.command.create', [$this, 'prepareShopBaseUrl']);
        $dispatcher->addListener('command.after_prepare', [$this, 'wrapRequestData']);
        $dispatcher->addListener('command.before_send', [$this, 'authorizeRequest']);

        $this->setEventDispatcher($dispatcher);
    }

    /**
     * Get the options relative to Shopify
     *
     * @return array
     */
    public function getShopifyOptions()
    {
        return $this->options;
    }

    /**
     * @param string $apiKey
     * @return void
     */
    public function setApiKey(string $apiKey)
    {
        $this->options['api_key'] = $apiKey;
    }

    /**
     * @param  string $password
     * @return void
     */
    public function setPassword(string $password)
    {
        $this->options['password'] = $password;
    }

    /**
     * @param  string $shop
     * @return void
     */
    public function setShopDomain(string $shop)
    {
        $this->options['shop'] = $shop;
    }

    /**
     * @param  string $accessToken
     * @return void
     */
    public function setAccessToken(string $accessToken)
    {
        $this->options['access_token'] = $accessToken;
    }

    /**
     * {@inheritdoc}
     */
    public function __call($method, $args = [])
    {
        // In Shopify, all API responses wrap the data by the resource name. For instance, using the "/shop" endpoint will wrap
        // the data by the "shop" key. This is a bit inconvenient to use in userland. As a consequence, we always "unwrap" the
        // result. The only exception if the "ExchangeCodeForToken" command that works a bit differently

        $command = $this->getCommand(ucfirst($method), isset($args[0]) ? $args[0] : []);
        $data    = $command->getResult();
        $rootKey = $command->getOperation()->getData('root_key');

        return (null === $rootKey) ? $data : $data[$rootKey];
    }

    /**
     * Prepare the base URL
     *
     * @internal
     * @param Event $event
     */
    public function prepareShopBaseUrl(Event $event)
    {
        /** @var Client $client */
        $client = $event['client'];

        // In both cases, we need to set the "shop" options for the request. Note the user may either pass the
        // subdomain (myshop) or the complete domain (myshop.myshopify.com), but we normalize it to always have the subdomain
        $shop = str_replace('.myshopify.com', '', $this->options['shop']);
        $client->setBaseUrl("https://$shop.myshopify.com/admin");
    }

    /**
     * Wrap request data around a top-key (only for POST and PUT requests)
     *
     * @param  Event $event
     * @return void
     */
    public function wrapRequestData(Event $event)
    {
        /* @var \Guzzle\Service\Command\CommandInterface $command */
        $command = $event['command'];
        $request = $command->getRequest();
        $method  = strtolower($request->getMethod());

        if (!($method === 'post' || $method === 'put')) {
            return;
        }

        $rootKey = $command->getOperation()->getData('root_key');

        if (null === $rootKey) {
            return;
        }

        // It's a bit inefficient because we have to decode what has been previously coded... but I didn't find any way to
        // interact before the code
        $data = json_decode($request->getBody(), true);
        $data = [$rootKey => $data];

        $request->setBody(json_encode($data));
    }

    /**
     * Authorize the request
     *
     * @internal
     * @param  Event $event
     * @return void
     */
    public function authorizeRequest(Event $event)
    {
        /* @var \Guzzle\Service\Command\CommandInterface $command */
        $command = $event['command'];
        $request = $command->getRequest();

        // For private app, we need to use basic auth, otherwise we need to add
        // an access token in a header
        if ($this->options['private_app']) {
            $request->setAuth($this->options['api_key'], $this->options['password']);
        } else {
            $request->setHeader('X-Shopify-Access-Token', $this->options['access_token']);
        }
    }
}
