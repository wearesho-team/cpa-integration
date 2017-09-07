<?php

namespace Wearesho\Cpa\PrimeLead;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use Wearesho\Cpa\Exceptions\DuplicatedConversionException;
use Wearesho\Cpa\Exceptions\UnsupportedConversionTypeException;
use Wearesho\Cpa\Interfaces\ConversionInterface;
use Wearesho\Cpa\Interfaces\ConversionRepositoryInterface;
use Wearesho\Cpa\Interfaces\PostbackServiceInterface;
use Wearesho\Cpa\Interfaces\StoredConversionInterface;

/**
 * Class PostbackService
 * @package Wearesho\Cpa\PrimeLead
 */
class PostbackService implements PostbackServiceInterface
{
    /** @var PostbackServiceConfig */
    protected $config;

    /** @var  ConversionRepositoryInterface */
    protected $repository;

    /** @var ClientInterface */
    protected $client;

    /**
     * PostbackService constructor.
     * @param ConversionRepositoryInterface $repository
     * @param PostbackServiceConfig $config
     * @param ClientInterface $client
     */
    public function __construct(
        ConversionRepositoryInterface $repository,
        PostbackServiceConfig $config,
        ClientInterface $client
    )
    {
        $this->repository = $repository;
        $this->config = $config;
        $this->client = $client;
    }

    /**
     * Sending POST query to CPA network after creating conversion
     *
     * @param ConversionInterface $conversion
     *
     * @throws UnsupportedConversionTypeException
     * @throws DuplicatedConversionException
     * @throws RequestException
     *
     * @return ResponseInterface
     */
    public function send(ConversionInterface $conversion): ResponseInterface
    {
        if (!$conversion instanceof Conversion) {
            throw new UnsupportedConversionTypeException($this, $conversion);
        }

        $previousSentConversion = $this->repository->pull(
            $conversion->getId(),
            get_class($conversion)
        );
        if ($previousSentConversion instanceof StoredConversionInterface) {
            throw new DuplicatedConversionException($conversion);
        }

        $request = new Request("get", $uri = $this->getPath($conversion));
        $response = $this->client->send($request);

        $this->repository->push($conversion, $response);
        return $response;
    }

    /**
     * @param Conversion $conversion
     * @return string
     */
    private function getPath(Conversion $conversion): string
    {
        $template = "/:id?adv_sub=:conversionId&transaction_id=:transactionId";
        return rtrim($this->config->getBaseUri(), '/') . str_replace(
                [':id', ':conversionId', ':transactionId'],
                [
                    $this->config->getId(),
                    $conversion->getId(),
                    $conversion->getLead()->getTransactionId(),
                ],
                $template
            );
    }
}