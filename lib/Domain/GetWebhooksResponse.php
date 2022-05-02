<?php

/**
 * Get Webhooks Reponse
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Pagination;

/**
 * Get Webhooks Reponse
 * Object used to map the get webhooks method response.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class GetWebhooksResponse extends BaseResponseWithoutMessage
{
    /**
     * Integer field used for the page.
     * @var int
     * @Type("int")
     */
    public $page;
    /**
     * Integer field used for the returned count.
     * @var int
     * @Type("int")
     */
    public $returnedCount;
    /**
     * Integer field used for the total count.
     * @var int
     * @Type("int")
     */
    public $totalCount;
    /**
     * webhooks list used for the webhooks.
     * @Type("array")
     */
    public $webhooks;
    /**
     * Pagination.
     * @var Silamoney\Client\Domain\Pagination
     * @Type("Silamoney\Client\Domain\Pagination")
     */
    public $pagination;
    /**
     * @return Silamoney\Client\Domain\Pagination
     */
    public function getPagination(): Simanoney\Client\Domain\Pagination
    {
        return $this->pagination;
    }

    public function getTransactionById($id)
    {
        $tx = array_values(array_filter($this->webhooks, function ($v) use ($id) {
            return $v->referenceId = $id;
        }, ARRAY_FILTER_USE_BOTH));
        return count($tx) ? $tx[0] : null;
    }
}
