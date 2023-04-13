<?php

declare(strict_types=1);

namespace DeveloperHub\ProductCustomTabs\Ui;

use Exception;
use Magento\Catalog\Api\AttributeSetRepositoryInterface;
use Magento\Eav\Api\Data\AttributeSetSearchResultsInterface;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\Api\SearchCriteriaBuilder;

class AttributeSetProvider extends AbstractSource
{
    /** @var AttributeSetRepositoryInterface */
    protected $attributeSetRepository;

    /** @var SearchCriteriaBuilder */
    protected $searchCriteriaBuilder;

    /**
     * @param AttributeSetRepositoryInterface $attributeSetRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        AttributeSetRepositoryInterface $attributeSetRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->attributeSetRepository = $attributeSetRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @return array|AttributeSetSearchResultsInterface
     * @throws Exception
     */
    public function listAttributeSet()
    {
        $attributeSetList = [];
        try {
            $searchCriteria = $this->searchCriteriaBuilder->create();
            $attributeSet = $this->attributeSetRepository->getList($searchCriteria);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        if ($attributeSet->getTotalCount()) {
            $attributeSetList = $attributeSet;
        }

        return $attributeSetList;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getOptionArray()
    {
        $options = [];
        $attributeSetList = $this->listAttributeSet();
        if ($attributeSetList) {
            foreach ($attributeSetList->getItems() as $list) {
                $options[$list->getAttributeSetId()] = $list->getAttributeSetName();
            }
        }
        return $options;
    }

    /** @return array */
    public function getAllOptions()
    {
        $res = $this->getOptions();
        array_unshift($res, ['value' => '', 'label' => '']);
        return $res;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getOptions()
    {
        $res = [];
        foreach ($this->getOptionArray() as $value) {
            $res[] = ['value' => $value, 'label' => $value];
        }
        return $res;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function toOptionArray()
    {
        return $this->getOptions();
    }
}
