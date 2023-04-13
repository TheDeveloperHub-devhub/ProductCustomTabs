<?php

declare(strict_types=1);

namespace DeveloperHub\ProductCustomTabs\Api;

use DeveloperHub\ProductCustomTabs\Api\Data\CustomTabsInterface;

interface CustomTabsRepositoryInterface
{
    /**
     * @param CustomTabsInterface $tab
     * @return mixed
     */
    public function save(CustomTabsInterface $tab);

    /**
     * @param CustomTabsInterface $tab
     * @return mixed
     */
    public function delete(CustomTabsInterface $tab);

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @param $id
     * @return mixed
     */
    public function deleteById($id);
}
