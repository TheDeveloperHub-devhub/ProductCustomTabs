<?php

declare(strict_types=1);

namespace DeveloperHub\ProductCustomTabs\Model;

use Exception;
use Magento\Framework\Exception\AlreadyExistsException;
use DeveloperHub\ProductCustomTabs\Api\CustomTabsRepositoryInterface;
use DeveloperHub\ProductCustomTabs\Api\Data\CustomTabsInterface;
use DeveloperHub\ProductCustomTabs\Model\ResourceModel\CustomTabs as CustomTabsResourceModel;

class CustomTabsRepository implements CustomTabsRepositoryInterface
{
    /** @var CustomTabsResourceModel */
    protected $customTabsResourceModel;

    /** @var CustomTabsInterface */
    protected $tab;

    /**
     * @param CustomTabsResourceModel $customTabsResourceModel
     * @param CustomTabsInterface $tab
     */
    public function __construct(
        CustomTabsResourceModel $customTabsResourceModel,
        CustomTabsInterface $tab
    ) {
        $this->customTabsResourceModel=$customTabsResourceModel;
        $this->tab=$tab;
    }

    /**
     * @param CustomTabsInterface $tab
     * @return mixed|void
     * @throws AlreadyExistsException
     */
    public function save(CustomTabsInterface $tab)
    {
        $this->customTabsResourceModel->save($tab);
    }

    /**
     * @param CustomTabsInterface $tab
     * @return CustomTabsResourceModel
     * @throws Exception
     */
    public function delete(CustomTabsInterface $tab)
    {
        return $this->customTabsResourceModel->delete($tab);
    }

    /**
     * @param $id
     * @return CustomTabsInterface
     */
    public function getById($id)
    {
        $this->customTabsResourceModel->load($this->tab, $id);
        return $this->tab;
    }

    /**
     * @param $id
     * @return mixed|CustomTabsResourceModel
     * @throws Exception
     */
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }
}
