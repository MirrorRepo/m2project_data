<?php
namespace Jeff\Contacts\Api;

use Jeff\Contacts\Api\Data\ContactInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SearchCriteriaInterface;

interface ContactRepositoryInterface 
{
    public function save(ContactInterface $page);

    public function getById($id);

    public function getList(SearchCriteriaInterface $criteria);

    public function delete(ContactInterface $page);

    public function deleteById($id);
}
