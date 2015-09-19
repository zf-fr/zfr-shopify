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

namespace Zfr\Shopify\Client;

use Guzzle\Common\Event;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Zfr\Shopify\Exception;

/**
 * Shopify client used to interact with the Shopify API
 *
 * It also offers several utility, to allow generate URLs needed for the OAuth dance, as well
 * as validating incoming request
 *
 * @author Michaël Gallego
 */
class ShopifyClient extends Client
{
    /**
     * @var string
     */
    private $shop;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $password;

    /**
     * @param string $shop
     * @param string $apiKey
     * @param string $password
     */
    public function __construct($shop, $apiKey, $password)
    {
        $this->shop     = (string) $shop;
        $this->apiKey   = (string) $apiKey;
        $this->password = (string) $password;

        parent::__construct('', [
            'shop'           => $this->shop
        ]);

        $this->setUserAgent('zfr-shopify-php', true);
        $this->setDescription(ServiceDescription::factory(__DIR__ . '/ServiceDescription/Shopify-v1.php'));

        // Add an event to set the Authorization param
        $dispatcher = $this->getEventDispatcher();
        $dispatcher->addListener('command.before_send', [$this, 'authorizeRequest']);
    }

    /**
     * {@inheritdoc}
     */
    public function __call($method, $args = [])
    {
        return parent::__call(ucfirst($method), $args);
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
        $request->setAuth($this->apiKey, $this->password);
    }
}